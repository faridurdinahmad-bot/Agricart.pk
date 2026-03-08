<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocaleController extends Controller
{
    public function switch(Request $request): RedirectResponse
    {
        $supported = array_keys(config('locales.supported', []));

        $locale = $request->validate([
            'locale' => ['required', 'string', Rule::in($supported)],
        ])['locale'];

        session()->put('locale', $locale);

        return redirect()->back();
    }
}
