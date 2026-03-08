@extends('layouts.app')

@section('title', __('app.roles.assign_title') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('roles.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.roles.assign_title') }}</h1>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] text-sm">{{ session('success') }}</div>
        @endif

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20 bg-white/5">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.staff.name') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.staff.email') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.staff.role') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.roles.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff as $s)
                        <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->email }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $s->role?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="{{ route('roles.assign.store') }}" class="inline-flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="staff_id" value="{{ $s->id }}">
                                    <select name="role_id" class="px-3 py-1.5 rounded-lg bg-white/10 border border-white/20 text-white text-sm focus:ring-2 focus:ring-[#83b735]">
                                        <option value="">— {{ __('app.staff.role') }} —</option>
                                        @foreach($roles as $r)
                                        <option value="{{ $r->id }}" {{ $s->role_id == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-[#83b735]/20 text-[#83b735] text-sm hover:bg-[#83b735]/30 transition-all">Assign</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4"><x-empty-state :message="__('app.staff.no_staff')" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($staff->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $staff->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
