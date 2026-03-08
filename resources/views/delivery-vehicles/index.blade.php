@extends('layouts.app')

@section('title', __('app.logistics.vehicles') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.logistics.vehicles') }}</h1>
            <a href="{{ route('delivery-vehicles.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d] transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                {{ __('app.logistics.add_vehicle') }}
            </a>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] text-sm">{{ session('success') }}</div>
        @endif

        <div class="flex gap-2 mb-4">
            <a href="{{ route('delivery-vehicles.index') }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ !request('status') ? 'bg-[#83b735]/20 text-[#83b735] border border-[#83b735]/40' : 'glass-solid border border-white/20 text-white/80 hover:bg-white/10' }}">{{ __('app.logistics.active') }}</a>
            <a href="{{ route('delivery-vehicles.index', ['status' => 'inactive']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('status') === 'inactive' ? 'bg-[#83b735]/20 text-[#83b735] border border-[#83b735]/40' : 'glass-solid border border-white/20 text-white/80 hover:bg-white/10' }}">{{ __('app.logistics.inactive') }}</a>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20 bg-white/5">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.logistics.name') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.logistics.number_plate') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.logistics.driver_name') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.logistics.driver_phone') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.logistics.status') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.logistics.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicles as $v)
                        <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $v->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $v->number_plate ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $v->driver_name ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $v->driver_phone ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $v->status === 'active' ? 'bg-[#83b735]/20 text-[#83b735]' : 'bg-white/20 text-white/70' }}">{{ __('app.logistics.' . $v->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('delivery-vehicles.show', $v) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20">{{ __('app.logistics.view') }}</a>
                                    <a href="{{ route('delivery-vehicles.edit', $v) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20">{{ __('app.contacts.edit') }}</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-4 py-12 text-center text-white/60">{{ __('app.logistics.no_vehicles') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($vehicles->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $vehicles->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
