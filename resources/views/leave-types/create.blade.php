@extends('layouts.app')

@section('title', (__('app.leave.add_leave_type') ?? 'Add Leave Type') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('leave-types.index')" :title="__('app.leave.add_leave_type') ?? 'Add Leave Type'" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('leave-types.store') }}" class="space-y-5">
                @csrf
                <x-input name="name" :label="__('app.leave.name') ?? 'Name'" required placeholder="e.g. Annual, Sick" />
                <x-input type="number" name="days_per_year" :label="__('app.leave.days_per_year') ?? 'Days Per Year'" :value="old('days_per_year', 0)" min="0" required />
                <x-input name="description" :label="__('app.leave.description') ?? 'Description'" />
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.inventory.save') }}</x-button>
                    <x-button :href="route('leave-types.index')" variant="secondary">{{ __('app.inventory.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
