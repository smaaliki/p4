<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactCenter;
use App\Service;

class ContactCentersController extends Controller
{
    public function index()
    {
        $ccs = ContactCenter::orderBy('name')->get();
        $emirates = [1 => 'Abu Dhabi', 2 => 'Ajman', 3 => 'Dubai', 4 => 'Fujairah', 5 => 'Ras Al Kahimah', 6 => 'Sharjah', 7 => 'Umm Al Quwain',];

        return view('contactcenters.index')->with([
            'ccs' => $ccs,
            'emirates' => $emirates,
        ]);
    }

    public function manageCCs()
    {
        $ccs = ContactCenter::orderBy('name')->get();
        $emirates = [1 => 'Abu Dhabi', 2 => 'Ajman', 3 => 'Dubai', 4 => 'Fujairah', 5 => 'Ras Al Kahimah', 6 => 'Sharjah', 7 => 'Umm Al Quwain',];

        return view('contactcenters.manageCCs')->with([
            'ccs' => $ccs,
            'emirates' => $emirates,
        ]);
    }

    public function showContactCenters()
    {
        return view('calculators.sampleSize');
    }

    public function create()
    {
        $emirates = [1 => 'Abu Dhabi', 2 => 'Ajman', 3 => 'Dubai', 4 => 'Fujairah', 5 => 'Ras Al Kahimah', 6 => 'Sharjah', 7 => 'Umm Al Quwain',];

        return view('contactcenters.create')->with([
            'emirates' => $emirates,
            'servicesForCheckboxes' => Service::getForCheckboxes(),
            'services' =>  [],
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'ccName' => 'required',
            'phoneNumber' => 'required',
        ]);

        # Save the contact center to the database
        $cc = new ContactCenter();
        $cc->name = $request->ccName;
        $cc->street_address = $request->address;
        $cc->emirate = $request->emirate ? $request->emirate: ' ';
        $cc->phone_number = $request->phoneNumber;
        $cc->save();

        $cc->services()->sync($request->input('services'));

        # Send the user back to the page to add a contact center; include the title as part of the redirect
        # so we can display a confirmation message on that page
        return redirect('/manageCCs/create')->with([
            'alert' => 'The contact center ' . $cc->name . ' was added.'
        ]);
    }

    /**
     * Show the form to edit an existing contact center
     */
    public function edit($id)
    {
        # Find the contact center the visitor is requesting to edit
       // $cc = ContactCenter::find($id);
        # Get this book and eager load its tags
        $cc = ContactCenter::with('services')->find($id);

        # Handle the case where we can't find the given contact center
        if (!$cc) {
            return redirect('/manageCCs')->with(
                ['alert' => 'Contact Center ' . $id . ' not found.']
            );
        }

        #Todo: Can this be turned into a relationship, like the services? Do we want to if the emirates will never change?  Otherwise, can we make this a global variable?
        $emirates = [1 => 'Abu Dhabi', 2 => 'Ajman', 3 => 'Dubai', 4 => 'Fujairah', 5 => 'Ras Al Kahimah', 6 => 'Sharjah', 7 => 'Umm Al Quwain',];

        # Show the contact center edit form
        return view('contactcenters.edit')->with([
            'cc' => $cc,
            'emirates' => $emirates,
            'servicesForCheckboxes' => Service::getForCheckboxes(),
            'services' =>  $cc->services()->pluck('services.id')->toArray(),
        ]);
    }

    /**
     * Process the form to edit an existing contact center
     * PUT /contact center/{id}
     */
    public function update(Request $request, $id)
    {
        # Custom validation messages
        # Todo: this is not working. Why?
        $messages = [
            'ccName.required' => 'The Contact Center Name field is required.',
            'phoneNumber.required' => 'The cc Phone Number field is required.',
        ];

        $this->validate($request, [
            'ccName' => 'required',
            'phoneNumber' => 'required',
        ], $messages);

        # Fetch the contact center we want to update
        $cc = ContactCenter::find($id);

        # Update data
        $cc->name = $request->ccName;
        $cc->street_address = $request->address;
        $cc->emirate = $request->emirate ? $request->emirate: ' ';
        $cc->phone_number = $request->phoneNumber;

        # Sync the services
        $cc->services()->sync($request->input('services'));

        # Save
        $cc->save();

        # Send the user back to the edit page in case they want to make more edits
        return redirect('/manageCCs/' . $id . '/edit')->with([
            'alert' => 'Your changes were saved'
        ]);
    }

    public function remove($id)
    {
        //Todo: Ideally, we should never delete a CC.  It should be de-activated so that if in teh future we want to look at its data, we can still access it.

        $removedCC = ContactCenter::where('id', '=', $id)->first();
        $emirates = [1 => 'Abu Dhabi', 2 => 'Ajman', 3 => 'Dubai', 4 => 'Fujairah', 5 => 'Ras Al Kahimah', 6 => 'Sharjah', 7 => 'Umm Al Quwain',];

        if (!$removedCC) {
            $ccs = ContactCenter::orderBy('name')->get();

            return redirect('/manageCCs')->with([
                'ccs' => $ccs,
                'emirates' => $emirates,
                'alert' => 'The contact center was not found!',
            ]);
        } else {
            # Before we delete the cc we have to delete any employee associations
            $removedCC->employees()->delete();

            # Before we delete the cc we have to delete any employee associations
            $removedCC->services()->detach();

            $removedCC->delete();

            $ccs = ContactCenter::orderBy('name')->get();

            return redirect('/manageCCs')->with([
                'ccs' => $ccs,
                'emirates' => $emirates,
                'alert' => 'The contact center ' . $removedCC ->name . ' was removed',
                ]);
        }

    }
}
