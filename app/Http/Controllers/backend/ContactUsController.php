<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    public function index()
    {
        $contacts = ContactUs::all();
        return view('contactus.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = ContactUs::findOrFail($id);
        return view('contactus.show', compact('contact'));
    }

    public function create()
    {
        return view('contactus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'society_name' => 'required',
            'country' => 'required',
            'city' => 'required',
            'full_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'comments' => 'required',
        ]);

        ContactUs::create($request->all());

        return redirect()->route('contactus.index')
            ->with('success', 'Contact message created successfully.');
    }

    public function edit($id)
    {
        $contact = ContactUs::findOrFail($id);
        return view('contactus.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'society_name' => 'required',
            'country' => 'required',
            'city' => 'required',
            'full_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'comments' => 'required',
        ]);

        $contact = ContactUs::findOrFail($id);
        $contact->update($request->all());

        return redirect()->route('contactus.index')
            ->with('success', 'Contact message updated successfully.');
    }

    public function destroy($id)
    {
        $contact = ContactUs::findOrFail($id);
        $contact->delete();

        return redirect()->route('contactus.index')
            ->with('success', 'Contact message deleted successfully.');
    }
}
