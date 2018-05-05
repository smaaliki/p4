<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
#use Log;

class CalculatorsController extends Controller
{
    /**
     * @param Request $request
     * @return $this
     */
    public function Sample_Size_Calc(Request $request)
    {
        $numCalls = $request->session()->get('numCalls');
        $confLevel = $request->session()->get('confLevel');
        $errorMargin = $request->session()->get('errorMargin');
        $sampleSize = $request->session()->get('sampleSize');

        return view('calculators.sampleSize')->with([
            'numCalls' => $numCalls,
            'confLevel' => $confLevel,
            'errorMargin' => $errorMargin,
            'sampleSize' => $sampleSize,
        ]);
    }

    public function sampleSize(Request $request)
    {
        # Validate the request data
        $this->validate($request, [
            'numCalls' => 'required|numeric',
            'errorMargin' => 'required|numeric|min:1|max:6',
        ]);

        # Get/Set the data
        $numCalls = $request->input('numCalls');
        $confLevel = $request->input('confLevel');
        $errorMargin = $request->input('errorMargin');

        //if ($numCalls && $confLevel) {
        $zScore = 1.28;
        if ($confLevel == 1) {
            $zScore = 1.28;
        } else if ($confLevel == 2) {
            $zScore = 1.44;
        } else if ($confLevel == 3) {
            $zScore = 1.65;
        } else if ($confLevel == 4) {
            $zScore = 1.96;
        } else if ($confLevel == 5) {
            $zScore = 2.58 * 2.58;
        }

        $sampleSize = 0.25 / ((($errorMargin / 100) / $zScore) * (($errorMargin / 100) / $zScore));
        $sampleSize = round(($sampleSize * $numCalls) / ($sampleSize + $numCalls - 1));

        # Return the view, with the results
        return redirect('/calculators/Sample_Size_Calc')->with([
            'numCalls' => $numCalls,
            'confLevel' => $confLevel,
            'errorMargin' => $errorMargin,
            'sampleSize' => $sampleSize,
        ]);
    }

    public function System_Uptime_Calc(Request $request)
    {
        $month = $request->session()->get('month');
        $year = $request->session()->get('year');
        $fullOperation = $request->session()->get('fullOperation');
        $weekDayHours = $request->session()->get('weekDayHours');
        $weekendWorkHours = $request->session()->get('weekendWorkHours');
        $workDays = $request->session()->get('workDays');
        $downTime = $request->session()->get('downTime');
        $monthWorkHours = $request->session()->get('monthWorkHours');
        $systemUpTime = $request->session()->get('systemUpTime');
        $tempWorkDays = $request->session()->get('tempWorkDays');

        return view('calculators.systemUptime')->with([
            'fullOperation' => $fullOperation,
            'month' => $month,
            'year' => $year,
            'weekDayHours' => $weekDayHours,
            'weekendWorkHours' => $weekendWorkHours,
            'workDays' => $workDays,
            'downTime' => $downTime,
            'monthWorkHours' => $monthWorkHours,
            'systemUpTime' => $systemUpTime,
            'tempWorkDays' => $tempWorkDays,
        ]);
    }

    public function systemUptime(Request $request)
    {
        # Validate the request data
        #@Todo: For some reason the validation causes the claculator page to go back to the calculators homepage.
        $this->validate($request, [
            'downTime' => 'required|numeric',
            'workDays' => 'required',
        ]);

        #Get the inputs
        $fullOperation = $request->input('fullOperation');
        $month = $request->input('month');
        $year = $request->input('year');
        $weekDayHours = $request->input('weekDayHours');
        $weekendWorkHours = $request->input('weekendWorkHours');
        $workDays = $request->input('workDays');
        $downTime = $request->input('downTime');

        #Figure out how many days there are in the month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $monthWorkHours = $daysInMonth * 24;
        $tempWorkDays = [true, true, true, true, true, true, true];

        #Calculate the System Uptime
        if ($downTime == "0") {
            $systemUpTime = '100';
        } else if ($fullOperation == true) {
            $systemUpTime = !empty($_GET['downTime']) ? round(100 * (1 - ($downTime / $monthWorkHours))) : '';
        } else {
            #Figure out how many weekdays there are in the month (i.e. how many, Sundays, Mondays, etc.)
            #@Todo: The following sets the time zone to Dubai.  We might want to consider opening this up
            #to other regions by letting users select the targeted timezone.
            date_default_timezone_set('Asia/Dubai');
            $firstDate = mktime(0, 0, 0, $month, 1, $year);
            $lastDate = mktime(0, 0, 0, $month, $daysInMonth, $year);

            $sundays = $mondays = $tuesdays = $wednesdays = $thursdays = $fridays = $saturdays = 0;

            for ($i = $firstDate; $i <= $lastDate; $i = $i + (24 * 3600)) {
                if (date("D", $i) == "Sun")
                    $sundays++;
                else if (date("D", $i) == "Mon")
                    $mondays++;
                else if (date("D", $i) == "Tue")
                    $tuesdays++;
                else if (date("D", $i) == "Wed")
                    $wednesdays++;
                else if (date("D", $i) == "Thu")
                    $thursdays++;
                else if (date("D", $i) == "Fri")
                    $fridays++;
                else if (date("D", $i) == "Sat")
                    $saturdays++;
            }

            $nonWorkingDays = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

            foreach ($workDays as $index => $dayString) {
                $match = false;
                foreach ($nonWorkingDays as $i => $dayString2) {
                    $match = ($dayString == $dayString2);
                    if ($match) {
                        unset($nonWorkingDays[$i]);
                        break;
                    }
                }
            }

            foreach ($nonWorkingDays as $i => $dayString) {
                $tempWorkDays[$i] = false;
                if ($nonWorkingDays[$i] == 'sunday') {
                    $sundays = 0;
                } else if ($nonWorkingDays[$i] == 'monday') {
                    $mondays = 0;
                } else if ($nonWorkingDays[$i] == 'tuesday') {
                    $tuesdays = 0;
                } else if ($nonWorkingDays[$i] == 'wednesday') {
                    $wednesdays = 0;
                } else if ($nonWorkingDays[$i] == 'thursday') {
                    $thursdays = 0;
                } else if ($nonWorkingDays[$i] == 'friday') {
                    $fridays = 0;
                } else if ($nonWorkingDays[$i] == 'saturday') {
                    $saturdays = 0;
                }
            }
            $monthWorkHours = ($weekDayHours * ($sundays + $mondays + $tuesdays + $wednesdays + $thursdays)) + ($weekendWorkHours * ($fridays + $saturdays));
            $systemUpTime = round(100 * (1 - $downTime / $monthWorkHours));
        }

        /*$tempWorkDays = [false, false, false, false, false, false, false];
foreach ($workDays as $i => $workday) {
    if ($workday == 'sunday')
        $tempWorkDays[0] = true;
    elseif ($workday == 'monday')
        $tempWorkDays[0] = true;
    elseif ($workday == 'tuesday')
        $tempWorkDays[0] = true;
    elseif ($workday == 'wednesday')
        $tempWorkDays[0] = true;
    elseif ($workday == 'thursday')
        $tempWorkDays[0] = true;
    elseif ($workday == 'friday')
        $tempWorkDays[0] = true;
    elseif ($workday == 'saturday')
        $tempWorkDays[0] = true;
}*/

        return redirect('/calculators/System_Uptime_Calc')->with([
            'fullOperation' => $fullOperation,
            'month' => $month,
            'year' => $year,
            'weekDayHours' => $weekDayHours,
            'weekendWorkHours' => $weekendWorkHours,
            'workDays' => $workDays,
            'downTime' => $downTime,
            'monthWorkHours' => $monthWorkHours,
            'systemUpTime' => $systemUpTime,
            'tempWorkDays' => $tempWorkDays,
        ]);
    }

//@Todo: Clean this up
    public function index($n = null, Request $request)
    {
        $methods = [];
        # If no specific calculator is specified, show index of all available methods
        if (is_null($n)) {
            foreach (get_class_methods($this) as $method) {
                if (strstr($method, 'Calc')) {
                    $methods[] = $method;
                }
            }

            return view('calculators')->with(['methods' => $methods]);
        } # Otherwise, load the requested method
        else {
            $method = $n;

            return (method_exists($this, $method)) ? $this->$method($request) : abort(404);
        }
    }
}
