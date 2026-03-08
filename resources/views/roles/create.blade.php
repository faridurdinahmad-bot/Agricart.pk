@extends('layouts.app')

@section('title', __('app.roles.add_new') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('roles.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.roles.add_new') }}</h1>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6 sm:p-8">
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-400/30">
                <ul class="text-sm text-red-200 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('roles.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-white/90 mb-2">{{ __('app.roles.name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:ring-2 focus:ring-[#83b735] focus:border-transparent">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-white/90 mb-2">{{ __('app.roles.description') }}</label>
                    <input type="text" name="description" id="description" value="{{ old('description') }}" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:ring-2 focus:ring-[#83b735] focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-3">{{ __('app.roles.permissions') }}</label>
                    <div class="space-y-4">
                        @foreach($permissionGroups as $groupKey => $group)
                        <div class="rounded-xl bg-white/5 border border-white/10 p-4">
                            <p class="text-sm font-medium text-[#83b735] mb-2">{{ $group['label'] }}</p>
                            <div class="flex flex-wrap gap-3">
                                @foreach($group['permissions'] as $permKey => $permLabel)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="permissions[]" value="{{ $permKey }}" {{ in_array($permKey, old('permissions', [])) ? 'checked' : '' }} class="w-4 h-4 rounded border-white/30 bg-white/20 text-[#83b735] focus:ring-[#83b735]">
                                    <span class="text-sm text-white/90">{{ $permLabel }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#83b735] text-white font-semibold hover:bg-[#6f9d2d] transition-all">{{ __('app.menu.roles_menu.add_role') }}</button>
                    <a href="{{ route('roles.index') }}" class="px-6 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20 transition-all">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
