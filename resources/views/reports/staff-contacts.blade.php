@extends('layouts.app')

@section('title', __('app.reports.staff_contacts') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.reports.staff_contacts') }}</h1>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.staff') }}</p>
                <p class="text-2xl font-bold text-white/90">{{ $staffCount }}</p>
            </div>
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.customers') }}</p>
                <p class="text-2xl font-bold text-white/90">{{ $customersCount }}</p>
            </div>
            <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
                <p class="text-xs text-white/60 mb-1">{{ __('app.reports.vendors') }}</p>
                <p class="text-2xl font-bold text-white/90">{{ $vendorsCount }}</p>
            </div>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('staff.index') }}" class="px-4 py-2.5 rounded-xl bg-[#83b735] text-white text-sm hover:bg-[#6f9d2d]">{{ __('app.menu.reports_menu.view_staff') }}</a>
            <a href="{{ route('attendance.report') }}" class="px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.menu.reports_menu.attendance_report') }}</a>
            <a href="{{ route('customers.index') }}" class="px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.menu.reports_menu.view_customers') }}</a>
            <a href="{{ route('vendors.index') }}" class="px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.menu.reports_menu.view_vendors') }}</a>
        </div>
    </div>
</div>
@endsection
