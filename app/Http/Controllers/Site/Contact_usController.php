<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class Contact_usController extends Controller
{
    public function index()
    {
        return view('site.pages.contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'required|string|max:20',
            'city'      => 'nullable|string|max:100',
            'type'      => 'nullable|in:general,support,sales', 
            'title'     => 'nullable|string|max:255',
            'message'   => 'nullable|string',
        ]);

        
        ContactUs::create($data + ['status' => 0]);

        return redirect()
            ->route('site.contact-us.index')
            ->with('success', 'شكراً لتواصلك معنا، سنعاود الاتصال بك قريباً.');
    }
}
