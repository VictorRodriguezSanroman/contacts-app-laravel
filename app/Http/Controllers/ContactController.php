<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        try {
            $find = Contact::where('name', $request->name)
                ->where('phone_number', $request->phone_number)
                ->where('email', $request->email)
                ->where('age', $request->age)
                ->first();

            if ($find) return redirect()->back()->with('findIt', 'Contact already registered');

            Contact::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'age' => $request->age
            ]);

            return redirect()->back()->with('success', 'Contact successfully added');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('errors', 'An unexpected error has occurred');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return view('contact.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        return view('contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactRequest  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        try {
            $contact->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'age' => $request->age
            ]);

            return redirect()->route('home')->with('success', 'Contact successfully updated');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('errors', 'An unexpected error has occurred');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            return back()->with('success', 'Contact successfully deleted');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('err', 'An unexpected error has occurred');
        }
    }
}
