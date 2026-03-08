@extends('layouts.app')

@section('title', __('app.payroll.slip') . ' - ' . $item->staff->name . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('payroll.show', $payroll) }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.payroll.slip') }} - {{ $item->staff->name }}</h1>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-lg font-bold text-white">{{ config('app.name') }}</h2>
                    <p class="text-sm text-white/60">{{ __('app.payroll.slip') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-white/90">{{ $payroll->period }}</p>
                    <p class="text-xs text-white/60">{{ __('app.payroll.pay_date') }}: {{ now()->format('d M Y') }}</p>
                </div>
            </div>

            <div class="border-b border-white/20 pb-4 mb-4">
                <p class="text-sm text-white/70">{{ __('app.staff.name') }}</p>
                <p class="text-lg font-bold text-white">{{ $item->staff->name }}</p>
                @if($item->staff->department)
                <p class="text-sm text-white/60">{{ __('app.staff.department') }}: {{ $item->staff->department }}</p>
                @endif
            </div>

            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-white/80">{{ __('app.payroll.basic_salary') }}</span>
                    <span class="text-white font-medium">{{ number_format($item->basic_salary, 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-white/80">{{ __('app.payroll.allowances') }}</span>
                    <span class="text-white font-medium">{{ number_format($item->allowances, 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-white/80">{{ __('app.payroll.deductions') }}</span>
                    <span class="text-red-400">-{{ number_format($item->deductions, 2) }}</span>
                </div>
                <div class="flex justify-between items-center text-sm text-white/60">
                    <span>{{ __('app.payroll.attendance_days') }}</span>
                    <span>{{ $item->attendance_days }} / {{ $item->attendance_days + $item->absent_days }}</span>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-white/20 flex justify-between items-center">
                <span class="text-lg font-bold text-white">{{ __('app.payroll.net_salary') }}</span>
                <span class="text-xl font-bold text-[#83b735]">{{ number_format($item->net_salary, 2) }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
