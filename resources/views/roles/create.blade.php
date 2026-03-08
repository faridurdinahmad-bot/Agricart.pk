@extends('layouts.app')

@section('title', __('app.roles.add_new') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-3xl mx-auto">
        <x-page-back :href="route('roles.index')" :title="__('app.roles.add_new')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('roles.store') }}" class="space-y-5">
                @csrf
                <x-input name="name" :label="__('app.roles.name')" required />
                <x-input name="description" :label="__('app.roles.description')" />
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
                    <x-button type="submit" variant="primary">{{ __('app.menu.roles_menu.add_role') }}</x-button>
                    <x-button :href="route('roles.index')" variant="secondary">{{ __('app.contacts.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
