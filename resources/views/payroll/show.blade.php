@extends('layouts.app')

@section('title', __('app.payroll.title') . ' - ' . $payroll->period . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('payroll.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-white">{{ $payroll->period }}</h1>
                    <p class="text-sm text-white/60">{{ __('app.payroll.total_amount') }}: <span class="text-[#83b735] font-medium">{{ number_format($payroll->total_amount, 2) }}</span></p>
                </div>
            </div>
            @if($payroll->status === 'draft')
            <form method="POST" action="{{ route('payroll.process', $payroll) }}" class="inline">@csrf<button type="submit" class="px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d]">{{ __('app.payroll.process') }}</button></form>
            @endif
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/20 bg-white/5">
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.staff.name') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.payroll.basic_salary') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.payroll.allowances') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.payroll.deductions') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.payroll.attendance_days') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.payroll.net_salary') }}</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.staff.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payroll->items as $item)
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $item->staff->name }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ number_format($item->basic_salary, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ number_format($item->allowances, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ number_format($item->deductions, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ $item->attendance_days }} / {{ $item->attendance_days + $item->absent_days }}</td>
                        <td class="px-4 py-3 text-sm text-[#83b735] font-medium">{{ number_format($item->net_salary, 2) }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('payroll.slip', [$payroll, $item->staff]) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20">{{ __('app.payroll.slip') }}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
