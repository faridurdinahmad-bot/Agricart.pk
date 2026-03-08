@extends('layouts.app')

@section('title', __('app.staff.edit_staff') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('staff.index')" :title="__('app.staff.edit_staff')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('staff.update', $staff) }}" class="space-y-5">
                @csrf
                @method('PUT')
                <x-input name="name" :label="__('app.staff.name')" :value="old('name', $staff->name)" required />
                <x-input type="email" name="email" :label="__('app.staff.email')" :value="old('email', $staff->email)" required />
                <x-input name="phone" :label="__('app.staff.phone')" :value="old('phone', $staff->phone)" />
                <x-input name="role" :label="__('app.staff.role')" :value="old('role', $staff->role)" />
                <x-input name="department" :label="__('app.staff.department')" :value="old('department', $staff->department)" />
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.contacts.update') }}</x-button>
                    <x-button :href="route('staff.index')" variant="secondary">{{ __('app.contacts.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
