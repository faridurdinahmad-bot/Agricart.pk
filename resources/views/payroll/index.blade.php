@extends('layouts.app')

@section('title', __('app.payroll.title') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.payroll.title') }}</h1>
            <a href="{{ route('payroll.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d] transition-all">
                {{ __('app.payroll.generate') }}
            </a>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="mb-4 p-4 rounded-xl bg-red-500/20 border border-red-400/40 text-red-300 text-sm">{{ session('error') }}</div>
        @endif

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/20 bg-white/5">
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.payroll.period') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.payroll.staff_count') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.payroll.total_amount') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.payroll.status') }}</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.staff.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrolls as $p)
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $p->period }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ $p->items_count }}</td>
                        <td class="px-4 py-3 text-sm text-[#83b735] font-medium">{{ number_format($p->total_amount, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs {{ $p->status === 'processed' ? 'bg-[#83b735]/20 text-[#83b735]' : 'bg-amber-500/20 text-amber-400' }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('payroll.show', $p) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20">{{ __('app.payroll.view') }}</a>
                            @if($p->status === 'draft')
                            <form method="POST" action="{{ route('payroll.process', $p) }}" class="inline">@csrf<button type="submit" class="px-3 py-1.5 rounded-lg bg-[#83b735]/20 text-[#83b735] text-sm hover:bg-[#83b735]/30">{{ __('app.payroll.process') }}</button></form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-12 text-center text-white/60">{{ __('app.payroll.no_records') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($payrolls->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $payrolls->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
