<?php

namespace App\Http\Controllers;

use App\ContactCenter;
use Illuminate\Http\Request;
use App\Pillar;
use App\Perspective;
use App\FocusArea;
use App\Standard;
use App\Touchpoint;
use Illuminate\Support\Collection;

class StandardsController extends Controller
{
    /* Show the list of standards*/
    public function index()
    {
        //Todo: lookup why the "with('focusarea')->get(); is faster than get();
        $pillars = Pillar::get();
        $perspectives = Perspective::get();
        $focus_areas = FocusArea::get();
        $standards = Standard::with('focusarea')->get();

        //Todo: Extract this into a function that is called anytime the cc info is updated.
        $cc = ContactCenter::where('id', 3)->first();
        $ccTouchpoints = $cc->touchpoints()->pluck('touchpoints.id')->toArray();
        $touchpointNames = Touchpoint::getForCheckboxes();

        foreach ($touchpointNames as $touchpointId => $touchpointName) {
            $touchpoints[$touchpointId] = in_array($touchpointId, $ccTouchpoints) ? true : false;
        }

        $crm = $cc->crm;

        //Todo: This section needs to be run once for now.  Once we add Standards management, we need to remove the rankings calculation from this function
        foreach ($focus_areas as $focus_area) {
            $rankings = $standards->where('focus_area_id', $focus_area->id)->pluck('std_ranking');
            $max_ranking = max($rankings->toArray());

            //Reverse the ranking and get the sum
            $rankings_sum = 0;
            foreach ($standards as $standard) {
                //Only look at standards, not indicators
                if (($standard->focus_area_id == $focus_area->id) && ($standard->std_type == 1)) {
                    $ranking = $max_ranking - $standard->std_ranking + 1;
                    $rankings_sum += $ranking;
                    $standard->weight = $ranking;
                    //dump('Ranking = '.$ranking.', rankings_sum = '.$rankings_sum);
                }
            }

            foreach ($standards as $standard) {
                //Only look at standards, not indicators
                if (($standard->focus_area_id == $focus_area->id) && ($standard->std_type == 1)) {
                    $standard->weight = ((100 / $rankings_sum) * $standard->weight);
                }
                $standard->save();
            }
        }

        /*Calculation step #XX */
        $ccs = 0;
        foreach ($perspectives as $perspective) {
            $ccs += $perspective->result;
        }

        return view('standards.index')->with([
            'pillars' => $pillars,
            'perspectives' => $perspectives,
            'focus_areas' => $focus_areas,
            'standards' => $standards,
            'ccs' => $ccs,
            'touchpoints' => $touchpoints,
            'crm' => $crm,
        ]);
    }

    public function calculate(Request $request)
    {
        //Todo: validation.
        /*        $messages = [
                    'achieved.*' => 'All fields must be numeric',
                ];

                $this->validate($request, [
                    'achieved.*' => 'numeric',
                ],$messages);*/

        $standards = Standard::get();
        $focus_areas = FocusArea::get();
        $perspectives = Perspective::get();

        //Todo: Extract this into a function that is called anytime the cc info is updated.
        $cc = ContactCenter::where('id', 3)->first();
        $ccTouchpoints = $cc->touchpoints()->pluck('touchpoints.id')->toArray();
        $touchpointNames = Touchpoint::getForCheckboxes();
        dump($cc->name);
        foreach ($touchpointNames as $touchpointId => $touchpointName) {
            $touchpoints[$touchpointId] = in_array($touchpointId, $ccTouchpoints) ? true : false;
        }

        $inbound_inf_calls = $touchpoints[1];
        $inbound_trans_calls = $touchpoints[2];
        $outbound_calls = $touchpoints[3];
        $email = $touchpoints[4];
        $webchat = $touchpoints[5];
        $sms = $touchpoints[6];
        $social_media = $touchpoints[7];
        $inbound_inf_ivr = $touchpoints[8];
        $inbound_trans_ivr = $touchpoints[9];
        $crm = $cc->crm; //Todo: This needs to be acquired from CC info, for now we will assume that it is true

        /*Todo: This needs to be done when the cc settings are modified as it only depends on the CC offering of the self-service options */
        //1. Calculate the Perspectives weights
        $perspective_ranking = [2, 1, 3, 2, 3, 4, 4];
        $lowest_ranking = max($perspective_ranking);

        $sum_reverse_ranking = 0;
        $reverse_ranking = null;
        for ($i = 0; $i < 7; $i++) {
            $reverse_ranking[$i] = $lowest_ranking - ($perspective_ranking[$i] - 1);
            $sum_reverse_ranking += $reverse_ranking[$i];
        }

        $perspective_weights[0] = ($inbound_inf_ivr || $inbound_trans_ivr) ? 100 * ($reverse_ranking[0] / $sum_reverse_ranking) : 100 * ($reverse_ranking[0] + $reverse_ranking[1]) / $sum_reverse_ranking;
        $perspective_weights[1] = ($inbound_inf_ivr || $inbound_trans_ivr) ? 100 * ($reverse_ranking[1] / $sum_reverse_ranking) : 0;
        $perspective_weights[2] = 100 * $reverse_ranking[2] / $sum_reverse_ranking;
        $perspective_weights[3] = 100 * $reverse_ranking[3] / $sum_reverse_ranking;
        $perspective_weights[4] = 100 * $reverse_ranking[4] / $sum_reverse_ranking;
        $perspective_weights[5] = 100 * $reverse_ranking[5] / $sum_reverse_ranking;
        $perspective_weights[6] = 100 * $reverse_ranking[6] / $sum_reverse_ranking;

        //2. Calculate Focus Area Weights
        //$start = microtime(true);
        $ce_weight_sum = 0;         //This is the sum of all focus areas in the Customer Experience - Agent Handled Perspective
        $phone_weight_sum = 0;
        $written_weight_sum = 0;
        $fa_2_3_weight = $crm ? 10 : 0;
        $agents_training_weight_sum = 0;
        foreach ($focus_areas as $focus_area) {
            if ($focus_area->fa_id == '1.1') {
                $phone_weight_sum += $focus_area->weight;
                $ce_weight_sum += $focus_area->weight;
            } else if ($focus_area->fa_id == '1.2') {
                $focus_area->weight = $inbound_trans_calls ? 18 : 0;
                $phone_weight_sum += $focus_area->weight;
                $ce_weight_sum += $focus_area->weight;
            } else if ($focus_area->fa_id == '1.3') {
                $focus_area->weight = $outbound_calls ? 12 : 0;
                $phone_weight_sum += $focus_area->weight;
                $ce_weight_sum += $focus_area->weight;
            } else if ($focus_area->fa_id == '1.4') {
                $focus_area->weight = $email ? 14 : 0;
                $written_weight_sum += $focus_area->weight;
                $ce_weight_sum += $focus_area->weight;
            } else if ($focus_area->fa_id == '1.5') {
                $focus_area->weight = $webchat ? 12 : 0;
                $written_weight_sum += $focus_area->weight;
                $ce_weight_sum += $focus_area->weight;
            } else if ($focus_area->fa_id == '1.6') {
                $focus_area->weight = $sms ? 14 : 0;
                $written_weight_sum += $focus_area->weight;
                $ce_weight_sum += $focus_area->weight;
            } else if ($focus_area->fa_id == '1.7') {
                $focus_area->weight = $social_media ? 12 : 0;
                $written_weight_sum += $focus_area->weight;
                $ce_weight_sum += $focus_area->weight;
            } else if ($focus_area->fa_id == '2.1') {
                $focus_area->weight = (60 - $fa_2_3_weight) * ($phone_weight_sum / $ce_weight_sum);
                $agents_training_weight_sum += $focus_area->weight;
            } else if ($focus_area->fa_id == '2.2') {
                $focus_area->weight = (60 - $fa_2_3_weight) * ($written_weight_sum / $ce_weight_sum);
                $agents_training_weight_sum += $focus_area->weight;
            } else if ($focus_area->fa_id == '2.3') {
                $focus_area->weight = $fa_2_3_weight;
                $agents_training_weight_sum += $focus_area->weight;
            } else if ($focus_area->fa_id == '2.4' || $focus_area->fa_id == '2.5' || $focus_area->fa_id == '2.6') {
                $focus_area->weight = (100 - $agents_training_weight_sum) / 3;
            } else if (($focus_area->fa_id == '1.8') || ($focus_area->fa_id == '1.9')) {
                $ivr_inf_vol = $request->achievedi1_8_1;
                $ivr_trans_vol = $request->achievedi1_9_1;
                $ivr_volume = $ivr_inf_vol + $ivr_trans_vol;
                if ($focus_area->fa_id == '1.8') {
                    $focus_area->weight = 0;
                    if ($inbound_inf_ivr) {
                        $focus_area->weight = 50;
                        if ($ivr_volume > 0) {
                            $focus_area->weight = 100 * ($ivr_inf_vol / $ivr_volume);
                        }
                    }
                }
                if ($focus_area->fa_id == '1.9') {
                    $focus_area->weight = 0;
                    if ($inbound_trans_ivr) {
                        $focus_area->weight = 50;
                        if ($ivr_volume > 0) {
                            $focus_area->weight = 100 * ($ivr_trans_vol / $ivr_volume);
                        }
                    }
                }
            }
            $focus_area->save();
        }
        //$time_elapsed_secs = microtime(true) - $start;
        //dump($time_elapsed_secs);

        //Todo: This ia a replication of what is going on in the function above. However, we are not saving the standards
        foreach ($focus_areas as $focus_area) {
            $fa_standards = $standards->where('focus_area_id', $focus_area->id);
            $rankings = $fa_standards->pluck('std_ranking');
            $max_ranking = max($rankings->toArray());

            //Reverse the ranking and get the sum
            $reverse_rankings_sum = 0;
            foreach ($fa_standards as $standard) {
                //Only look at standards, not indicators
                if ($standard->std_type == 1) {
                    $reverse_ranking = $max_ranking - $standard->std_ranking + 1;
                    $reverse_rankings_sum += $reverse_ranking;
                    $standard->weight = $reverse_ranking;
                }
            }

            foreach ($fa_standards as $standard) {
                //Only look at standards, not indicators
                if ($standard->std_type == 1) {
                    $standard->weight = (100 * $standard->weight) / $reverse_rankings_sum;
                }
             }
        }
        //$time_elapsed_secs = microtime(true) - $start;
        //dump($time_elapsed_secs);

        //Save the scores and Calculate the performance for each standard and focus area
        foreach ($perspectives as $key => $perspective) {
            $perspective->achieved = 0;
            $perspective->weight = $perspective_weights[$key];
            $fa_total_weight = 0;
            $perspective_focus_areas = $focus_areas->where('perspective_id', $perspective->id);
            foreach ($perspective_focus_areas as $focus_area) {
                $fa_standards = $standards->where('focus_area_id', $focus_area->id);
                $fa_achieved = 0;
                foreach ($fa_standards as $standard) {
                    //dump($standard->weight);
                    $perf = 0;
                    if ($standard->target_type == 0) {
                        /*Todo: can the next statement be inside of the if statement */
                        $standard->achieved = $request->get('achieved' . str_replace('.', '_', $standard->std_num)) == 'on' ? true : false;
                        if ($standard->std_type == 1) {
                            //$score = $standard->achieved ? 5:0;
                            //$perf = ($standard->weight * $score) / 5;
                            $perf = $standard->achieved ? $standard->weight : 0;
                        }
                    } else {
                        /*Todo: can the next statement be inside of the if statement */
                        $standard->achieved = $request->{'achieved' . str_replace('.', '_', $standard->std_num)};
                        if ($standard->std_type == 1) {
                            if ($standard->achieved) {
                                $difference = 0;
                                if ($standard->target_type == 1) {
                                    $difference = ($standard->target_min - $standard->achieved) / $standard->target_min;
                                } else if ($standard->target_type == 2) {
                                    if ($standard->achieved <= $standard->target_min) {
                                        $difference = ($standard->target_min - $standard->achieved) / $standard->target_min;
                                    } else {
                                        $difference = ($standard->achieved - $standard->target_max) / $standard->target_max;
                                    }
                                } else if ($standard->target_type == 3) {
                                    $difference = ($standard->achieved - $standard->target_max) / $standard->target_max;
                                }
                                if ($difference <= 0) {
                                    $score = 5;
                                } else if ($difference <= 0.02) {
                                    $score = 4;
                                } else if ($difference <= 0.05) {
                                    $score = 3;
                                } else if ($difference <= 0.1) {
                                    $score = 2;
                                } else if ($difference <= 0.2) {
                                    $score = 1;
                                } else {
                                    $score = 0;
                                }

                                /*Todo: Should we check before getting to this point ?*/
                                //$u = $standard->achieved ? $score : 0;
                                $perf = ($standard->weight * $score) / 5;
                            } else {
                                $perf = 0;
                            }
                        }
                    }
                    $standard->performance = $perf;
                    $standard->save();
                    $fa_achieved += $perf;
                }
                $focus_area->achieved = $fa_achieved;
                $focus_area->result = ($fa_achieved * $focus_area->weight) / 100;
                $focus_area->save();
                $fa_total_weight += $focus_area->weight;
                $perspective->achieved += $focus_area->result;
            }
            $perspective->achieved = ($fa_total_weight > 0) ? 100 * ($perspective->achieved / $fa_total_weight) : 0;
            $perspective->result = ($perspective->achieved * $perspective->weight) / 100;
            $perspective->save();
        }

        //$time_elapsed_secs = microtime(true) - $start;
        //dump($time_elapsed_secs);

        return redirect('/standards')->with([

            'alert' => 'The calculation is done.',
            //'fa_scores' => $fa_scores,
        ]);
    }

    public
    function reset(Request $request)
    {
        $standards = Standard::with('focusarea')->get();
        foreach ($standards as $standard) {
            $standard->achieved = null;
            $standard->performance = null;
            $standard->save();
        }

        # Send the user back to the page; include a message as part of the redirect
        # so we can display a confirmation message on that page
        return redirect('/standards')->with(['alert' => 'Reset was successful']);
    }

    /*    private
        function assess_focus_area_weights(Collections $focus_areas)
        {
            return $focus_areas;
        }*/
}