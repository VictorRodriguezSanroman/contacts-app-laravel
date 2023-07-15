<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ContactShareController extends Controller
{
    public function create()
    {
        return view('contact-shares.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'user_email'    => "exists:users,email|not_in:{$request->user()->email}",
                'contact_email' => Rule::exists('contacts', 'email')->where('user_id', auth()->id()),
            ], [
                'user_email.not_in'    => "You can share a contact with yourself",
                'contact_email.exists' => "This contact whas not  found in your contact list"
            ]);

            $user    = User::where('email', $data['user_email'])->first();
            $contact = Contact::where('email', $data['contact_email'])->first(['id']);

            $shareExists = Contact::find(30)->sharedWithUsers()->wherePivot('user_id', $user->id)->first();

            if ($shareExists) {
                return back()->withInput($request->all())->with('err', "This contact has already shared with user $user->name");
            }
            $contact->sharedWithUsers()->attach($user->id);
            return redirect()->back()->with('success', 'Contact successfully shared');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('err', $th->getMessage());
        }
    }
}
