@extends('layouts.app')

@section('title', __('app.staff.add_new') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('staff.index')" :title="__('app.staff.add_new')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('staff.store') }}" class="space-y-5">
                @csrf
                <x-input name="name" :label="__('app.staff.name')" required />
                <x-input type="email" name="email" :label="__('app.staff.email')" required />
                <x-input name="phone" :label="__('app.staff.phone')" />
                <x-input name="role" :label="__('app.staff.role')" />
                <x-input name="department" :label="__('app.staff.department')" />
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.menu.staff.add_staff') }}</x-button>
                    <x-button :href="route('staff.index')" variant="secondary">{{ __('app.contacts.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
