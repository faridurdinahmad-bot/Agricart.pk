@extends('layouts.app')

@section('title', __('app.payroll.add_salary') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('payroll.salaries') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.payroll.add_salary') }}</h1>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6">
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-400/30">
                <ul class="text-sm text-red-200 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('payroll.salaries.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.staff.name') }}</label>
                    <select name="staff_id" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                        <option value="">{{ __('app.payroll.select_staff') }}</option>
                        @foreach($staff as $s)
                        @if(!in_array($s->id, $staffWithSalary))
                        <option value="{{ $s->id }}" {{ old('staff_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endif
                        @endforeach
                    </select>
                    @if(count($staff) === count($staffWithSalary))
                    <p class="mt-1 text-sm text-white/60">{{ __('app.payroll.all_staff_have_salary') }}</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.payroll.basic_salary') }}</label>
                    <input type="number" name="basic_salary" value="{{ old('basic_salary') }}" step="0.01" min="0" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.payroll.allowances') }}</label>
                    <input type="number" name="allowances" value="{{ old('allowances', 0) }}" step="0.01" min="0" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-2">{{ __('app.payroll.deductions') }}</label>
                    <input type="number" name="deductions" value="{{ old('deductions', 0) }}" step="0.01" min="0" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white">
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#83b735] text-white font-semibold hover:bg-[#6f9d2d]">{{ __('app.payroll.save') }}</button>
                    <a href="{{ route('payroll.salaries') }}" class="px-6 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20">{{ __('app.payroll.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
