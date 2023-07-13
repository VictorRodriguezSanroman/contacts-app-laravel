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
        return view('contacts.index', ['contacts' => auth()->user()->contacts()->orderBy('name', 'asc')->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
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
            $user = auth()->user();
            $find = Contact::where('name', $request->name)
                ->where('phone_number', $request->phone_number)
                ->where('email', $request->email)
                ->where('age', $request->age)
                ->where('user_id', $user->id)
                ->first();

            if ($find) return redirect()->back()->with('findIt', 'Contact already registered');

            $data = $request->validated();

            if ($request->hasFile('profile_picture')) {
                $path = $request->file('profile_picture')->store('profiles', 'public');
                $data['profile_picture'] = $path;
            }

            $user->contacts()->create($data);

            return redirect()->back()->with('success', 'Contact successfully added');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('err', 'An unexpected error has occurred');
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
        $this->authorize('view', $contact);

        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $this->authorize('update', $contact);

        return view('contacts.edit', compact('contact'));
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
            $this->authorize('update', $contact);

            $data = $request->validated();

            if ($request->hasFile('profile_picture')) {
                $path = $request->file('profile_picture')->store('profiles', 'public');
                $data['profile_picture'] = $path;
            }
            
            $contact->update($data);

            return redirect()->route('home')->with('success', 'Contact successfully updated');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('err', 'An unexpected error has occurred');
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
            $this->authorize('delete', $contact);
            $contact->delete();
            return redirect()->back()->with('success', 'Contact successfully deleted');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('err', 'An unexpected error has occurred');
        }
    }
}
