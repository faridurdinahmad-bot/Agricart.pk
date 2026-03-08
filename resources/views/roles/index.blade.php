@extends('layouts.app')

@section('title', __('app.roles.title') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.roles.title') }}</h1>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('roles.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#83b735] text-white font-medium text-sm hover:bg-[#6f9d2d] transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('app.menu.roles_menu.add_role') }}
                </a>
                <a href="{{ route('roles.assign') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl glass-solid border border-white/20 text-white font-medium text-sm hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    {{ __('app.menu.roles_menu.assign_to_staff') }}
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-[#83b735]/20 border border-[#83b735]/40 text-[#83b735] text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="mb-4 p-4 rounded-xl bg-red-500/20 border border-red-400/40 text-red-300 text-sm">{{ session('error') }}</div>
        @endif

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/20 bg-white/5">
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.roles.name') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.roles.description') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-white/90 uppercase">{{ __('app.roles.staff_count') }}</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-white/90 uppercase">{{ __('app.roles.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                            <td class="px-4 py-3 text-sm font-medium text-white/90">{{ $role->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/80">{{ $role->description ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-white/90">{{ $role->staff_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('roles.edit', $role) }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20 hover:text-[#83b735] transition-all">{{ __('app.menu.roles_menu.edit_role') }}</a>
                                    <form method="POST" action="{{ route('roles.copy', $role) }}" class="inline">@csrf<button type="submit" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-[#83b735]/20 hover:text-[#83b735] transition-all">{{ __('app.menu.roles_menu.copy_role') }}</button></form>
                                    <form method="POST" action="{{ route('roles.destroy', $role) }}" class="inline" onsubmit="return confirm('{{ __('app.menu.roles_menu.delete_role') }}?');">@csrf @method('DELETE')<button type="submit" class="px-3 py-1.5 rounded-lg bg-white/10 text-white/90 text-sm hover:bg-red-500/20 hover:text-red-400 transition-all">{{ __('app.menu.roles_menu.delete_role') }}</button></form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-4 py-12 text-center text-white/60">{{ __('app.roles.no_roles') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($roles->hasPages())
            <div class="px-4 py-3 border-t border-white/10">{{ $roles->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
