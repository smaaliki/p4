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
        # Query the database to get the last 3 books added
        # $newBooks = Book::latest()->limit(3)->get();

        # [Better] Query the existing Collection to get the last 3 books added
        #$newBooks = $ccs->sortByDesc('created_at')->take(3);

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

        # Save the book to the database
        $cc = new ContactCenter();
        $cc->name = $request->ccName;
        $cc->street_address = $request->address;
        $cc->emirate = $request->emirate ? $request->emirate: ' ';
        $cc->phone_number = $request->phoneNumber;
        $cc->save();

        # Logging code just as proof of concept that this method is being invoked
        # Log::info('Add the book ' . $cc->title);

        # Send the user back to the page to add a book; include the title as part of the redirect
        # so we can display a confirmation message on that page
        return redirect('/manageCCs/create')->with([
            'alert' => 'The contact center ' . $cc->name . ' was added.'
        ]);
    }

    /**
     * Show the form to edit an existing book
     * GET /books/{id}/edit
     */
    public function edit($id)
    {
        # Find the book the visitor is requesting to edit
        $cc = ContactCenter::find($id);

        $emirates = [1 => 'Abu Dhabi', 2 => 'Ajman', 3 => 'Dubai', 4 => 'Fujairah', 5 => 'Ras Al Kahimah', 6 => 'Sharjah', 7 => 'Umm Al Quwain',];

        # Handle the case where we can't find the given book
        if (!$cc) {
            return redirect('/manageCCs')->with(
                ['alert' => 'Contact Center ' . $id . ' not found.']
            );
        }

        # Show the book edit form
        return view('contactcenters.edit')->with([
            'cc' => $cc,
            'emirates' => $emirates,
        ]);
    }

    /**
     * Process the form to edit an existing book
     * PUT /books/{id}
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'ccName' => 'required',
            'phoneNumber' => 'required',
        ]);

        # Fetch the book we want to update
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
