<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function business(): View
    {
        $business = [
            'name' => config('app.name', 'Agricart ERP'),
            'email' => config('mail.from.address', ''),
            'phone' => '',
            'address' => '',
            'tax_number' => '',
        ];

        return view('settings.business', compact('business'));
    }

    public function businessUpdate(Request $request): RedirectResponse
    {
        // Placeholder - in production would save to config/database
        return redirect()->route('settings.business')->with('success', __('app.settings.business_updated'));
    }

    public function theme(): View
    {
        return view('settings.theme');
    }

    public function sync(): View
    {
        return view('settings.placeholder', ['title' => __('app.menu.sub_settings.synchronization')]);
    }

    public function backup(): View
    {
        return view('settings.placeholder', ['title' => __('app.menu.sub_settings.backup_restore')]);
    }

    public function smsEmail(): View
    {
        return view('settings.placeholder', ['title' => __('app.menu.sub_settings.sms_email_settings')]);
    }
}
