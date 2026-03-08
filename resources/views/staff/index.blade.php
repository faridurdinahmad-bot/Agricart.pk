@extends('layouts.app')

@section('title', __('app.staff.title') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        {{-- Header with actions --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.staff.title') }}</h1>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('staff.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d] transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('app.menu.staff.add_staff') }}
                </a>
                <a href="{{ route('staff.index', array_filter(['import' => 1, 'status' => request('status')])) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white font-medium text-sm hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    {{ __('app.menu.staff.import_staff') }}
                </a>
                <a href="{{ route('staff.export') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white font-medium text-sm hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    {{ __('app.menu.staff.export_staff') }}
                </a>
            </div>
        </div>

        {{-- Import form (when ?import=1) --}}
        @if(request('import'))
        <div class="mb-6 backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
            <h2 class="text-lg font-bold text-white mb-4">{{ __('app.menu.staff.import_staff') }}</h2>
            <form method="POST" action="{{ route('staff.import') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">CSV File</label>
                    <input type="file" name="file" accept=".csv,.txt" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#83b735] file:text-white file:text-sm">
                    <p class="mt-1.5 text-xs text-white/60">Columns: name, email, phone, role, department</p>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d]">{{ __('app.menu.staff.import_staff') }}</button>
                    <a href="{{ route('staff.index', array_filter(['status' => request('status')])) }}" class="px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">Cancel</a>
                </div>
            </form>
        </div>
        @endif

        {{-- Status filter --}}
        <div class="flex gap-2 mb-4">
            <a href="{{ route('staff.index') }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ !request('status') ? 'bg-[#83b735]/20 text-[#83b735] border border-[#83b735]/40' : 'glass-solid border border-white/20 text-white/80 hover:bg-white/10' }}">Active</a>
            <a href="{{ route('staff.index', ['status' => 'inactive']) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ request('status') === 'inactive' ? 'bg-[#83b735]/20 text-[#83b735] border border-[#83b735]/40' : 'glass-solid border border-white/20 text-white/80 hover:bg-white/10' }}">Inactive</a>
        </div>

        {{-- Success message --}}
        @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] text-sm">
            {{ session('success') }}
        </div>
        @endif

        {{-- Staff table --}}
        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20 bg-white/5">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.staff.name') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.staff.email') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.staff.phone') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.staff.role') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.staff.status') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.staff.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff as $s)
                        <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->email }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->phone ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->role ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $s->status === 'active' ? 'bg-[#83b735]/20 text-[#83b735]' : 'bg-white/20 text-white/70' }}">
                                    {{ ucfirst($s->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('staff.edit', $s) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20 hover:text-[#83b735] transition-all">Edit</a>
                                    @if($s->isActive())
                                    <form method="POST" action="{{ route('staff.deactivate', $s) }}" class="inline" onsubmit="return confirm('{{ __('app.staff.deactivate_staff') }}?');">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-red-500/20 hover:text-red-400 transition-all">{{ __('app.staff.deactivate_staff') }}</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-white/60">{{ __('app.staff.no_staff') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($staff->hasPages())
            <div class="px-4 py-3 border-t border-white/10">
                {{ $staff->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
