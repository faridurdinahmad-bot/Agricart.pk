@extends('layouts.app')

@section('title', __('app.payroll.generate') . ' - Agricart ERP')

@section('content')
<div class="page-container">
    <div class="max-w-2xl mx-auto">
        <x-page-back :href="route('payroll.index')" :title="__('app.payroll.generate')" />

        @if($exists)
        <x-alert type="warning" class="mb-6">{{ __('app.payroll.already_exists') }}</x-alert>
        @endif

        <x-card>
            @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <ul class="space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </x-alert>
            @endif

            <form method="POST" action="{{ route('payroll.store') }}" class="space-y-5">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <x-select name="month" :label="__('app.payroll.month')" required>
                        @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ old('month', $month) == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endforeach
                    </x-select>
                    <x-input type="number" name="year" :label="__('app.payroll.year')" :value="old('year', $year)" min="2020" max="2100" required />
                </div>
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">{{ __('app.payroll.generate') }}</x-button>
                    <x-button :href="route('payroll.index')" variant="secondary">{{ __('app.payroll.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
