<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactCenter;

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

        # Logging code just as proof of concept that this method is being invoked
        # Log::info('Add the contact center ' . $cc->title);

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
        $cc = ContactCenter::find($id);

        $emirates = [1 => 'Abu Dhabi', 2 => 'Ajman', 3 => 'Dubai', 4 => 'Fujairah', 5 => 'Ras Al Kahimah', 6 => 'Sharjah', 7 => 'Umm Al Quwain',];

        # Handle the case where we can't find the given contact center
        if (!$cc) {
            return redirect('/manageCCs')->with(
                ['alert' => 'Contact Center ' . $id . ' not found.']
            );
        }

        # Show the contact center edit form
        return view('contactcenters.edit')->with([
            'cc' => $cc,
            'emirates' => $emirates,
        ]);
    }

    /**
     * Process the form to edit an existing contact center
     * PUT /contact center/{id}
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'ccName' => 'required',
            'phoneNumber' => 'required',
        ]);

        # Fetch the contact center we want to update
        $cc = ContactCenter::find($id);

        # Update data
        $cc->name = $request->ccName;
        $cc->street_address = $request->address;
        $cc->emirate = $request->emirate ? $request->emirate: ' ';
        $cc->phone_number = $request->phoneNumber;
        $cc->save();

        # Send the user back to the edit page in case they want to make more edits
        return redirect('/manageCCs/' . $id . '/edit')->with([
            'alert' => 'Your changes were saved'
        ]);
    }

    public function remove($id)
    {
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
