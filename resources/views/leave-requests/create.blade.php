@extends('layouts.app')

@section('title', __('app.leave.apply_leave') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('leave-requests.index')" :title="__('app.leave.apply_leave')" />

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('leave-requests.store') }}" class="space-y-5">
                @csrf
                <x-select name="staff_id" :label="__('app.leave.staff') ?? 'Staff'" required>
                    <option value="">Select Staff</option>
                    @foreach($staff as $s)
                    <option value="{{ $s->id }}" {{ old('staff_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </x-select>
                <x-select name="leave_type_id" :label="__('app.leave.leave_type') ?? 'Leave Type'" required>
                    <option value="">Select Type</option>
                    @foreach($leaveTypes as $lt)
                    <option value="{{ $lt->id }}" {{ old('leave_type_id') == $lt->id ? 'selected' : '' }}>{{ $lt->name }} ({{ $lt->days_per_year }}/year)</option>
                    @endforeach
                </x-select>
                <div class="grid grid-cols-2 gap-4">
                    <x-input type="date" name="start_date" :label="__('app.leave.start_date')" required />
                    <x-input type="date" name="end_date" :label="__('app.leave.end_date')" required />
                </div>
                <x-input type="textarea" name="reason" :label="__('app.leave.reason')" :rows="3">{{ old('reason') }}</x-input>
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.leave.apply') ?? 'Apply' }}</x-button>
                    <x-button :href="route('leave-requests.index')" variant="secondary">{{ __('app.inventory.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
