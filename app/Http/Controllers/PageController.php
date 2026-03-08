<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    /**
     * Display the privacy policy page.
     */
    public function privacy()
    {
        return view('pages.privacy');
    }

    /**
     * Display the terms and conditions page.
     */
    public function terms()
    {
        return view('pages.terms');
    }
}
