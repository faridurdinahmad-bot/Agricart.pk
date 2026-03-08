@extends('layouts.app')

@section('title', __('app.payroll.salary_setup') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.payroll.salary_setup') }}</h1>
            <a href="{{ route('payroll.salaries.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d] transition-all">
                {{ __('app.payroll.add_salary') }}
            </a>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] text-sm">{{ session('success') }}</div>
        @endif

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/20 bg-white/5">
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.staff.name') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.payroll.basic_salary') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.payroll.allowances') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.payroll.deductions') }}</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.staff.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salaries as $s)
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $s->staff->name }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ number_format($s->basic_salary, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ number_format($s->allowances, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ number_format($s->deductions, 2) }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('payroll.salaries.edit', $s) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20">{{ __('app.roles.edit_role') }}</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-12 text-center text-white/60">{{ __('app.payroll.no_salaries') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($salaries->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $salaries->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
