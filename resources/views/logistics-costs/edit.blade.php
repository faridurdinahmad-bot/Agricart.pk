@extends('layouts.app')

@section('title', __('app.logistics.edit_cost') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('logistics-costs.show', $logisticsCost) }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.logistics.edit_cost') }} #{{ $logisticsCost->id }}</h1>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6 sm:p-8">
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-400/30">
                <ul class="text-sm text-red-200 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('logistics-costs.update', $logisticsCost) }}" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.logistics.shipment') }}</label>
                    <select name="shipment_id" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                        <option value="">—</option>
                        @foreach($shipments as $s)
                        <option value="{{ $s->id }}" {{ old('shipment_id', $logisticsCost->shipment_id) == $s->id ? 'selected' : '' }}>#{{ $s->id }} {{ $s->tracking_number ? '- ' . $s->tracking_number : '' }} {{ $s->sale ? '(Sale #' . $s->sale->id . ')' : '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.logistics.carrier') }}</label>
                    <select name="carrier_id" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                        <option value="">—</option>
                        @foreach($carriers as $c)
                        <option value="{{ $c->id }}" {{ old('carrier_id', $logisticsCost->carrier_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.logistics.category') }}</label>
                    <input type="text" name="category" value="{{ old('category', $logisticsCost->category) }}" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.logistics.amount') }} *</label>
                    <input type="number" name="amount" value="{{ old('amount', $logisticsCost->amount) }}" step="0.01" min="0.01" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.logistics.date') }} *</label>
                    <input type="date" name="date" value="{{ old('date', $logisticsCost->date->format('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.logistics.description') }}</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50">{{ old('description', $logisticsCost->description) }}</textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#83b735] text-white font-semibold hover:bg-[#6f9d2d] transition-all">{{ __('app.logistics.update') }}</button>
                    <a href="{{ route('logistics-costs.show', $logisticsCost) }}" class="px-6 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20 transition-all">{{ __('app.logistics.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
