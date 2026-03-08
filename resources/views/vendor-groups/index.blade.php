@extends('layouts.app')

@section('title', __('app.contacts.vendor_groups') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.contacts.vendor_groups') }}</h1>
            <a href="{{ route('vendor-groups.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d] transition-all">
                {{ __('app.contacts.add_group') }}
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
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.contacts.name') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.contacts.description') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.contacts.supplier_type') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.contacts.vendors_count') }}</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.staff.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendorGroups as $g)
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $g->name }}</td>
                        <td class="px-4 py-3 text-sm text-white/80">{{ $g->description ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ $g->supplier_type ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-white/90">{{ $g->vendors_count }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('vendor-groups.edit', $g) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20">{{ __('app.contacts.edit') }}</a>
                            <form method="POST" action="{{ route('vendor-groups.destroy', $g) }}" class="inline" onsubmit="return confirm('{{ __('app.contacts.delete_confirm') }}');">@csrf @method('DELETE')<button type="submit" class="px-3 py-1.5 rounded-lg bg-white/10 text-red-400 text-sm hover:bg-red-500/20">{{ __('app.contacts.delete') }}</button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-12 text-center text-white/60">{{ __('app.contacts.no_vendor_groups') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($vendorGroups->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $vendorGroups->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
