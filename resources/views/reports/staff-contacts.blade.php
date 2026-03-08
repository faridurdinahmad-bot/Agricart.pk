@extends('layouts.app')

@section('title', __('app.reports.staff_contacts') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-6xl mx-auto">
        <x-page-back :href="route('dashboard')" :title="__('app.reports.staff_contacts')" />

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <x-metric-card :label="__('app.reports.staff')" :value="$staffCount" />
            <x-metric-card :label="__('app.reports.customers')" :value="$customersCount" />
            <x-metric-card :label="__('app.reports.vendors')" :value="$vendorsCount" />
        </div>

        <div class="flex flex-wrap gap-2">
            <x-button href="{{ route('staff.index') }}" variant="primary">{{ __('app.menu.reports_menu.view_staff') }}</x-button>
            <x-button href="{{ route('attendance.report') }}" variant="secondary">{{ __('app.menu.reports_menu.attendance_report') }}</x-button>
            <x-button href="{{ route('customers.index') }}" variant="secondary">{{ __('app.menu.reports_menu.view_customers') }}</x-button>
            <x-button href="{{ route('vendors.index') }}" variant="secondary">{{ __('app.menu.reports_menu.view_vendors') }}</x-button>
        </div>
    </div>
</div>
@endsection
