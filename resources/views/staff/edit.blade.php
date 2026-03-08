@extends('layouts.app')

@section('title', __('app.staff.edit_staff') . ' - Agricart ERP')

@section('content')
<div class="px-3 sm:px-4 md:px-5 py-4 sm:py-5">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('staff.index') }}" class="p-2 rounded-xl glass-solid border border-white/20 text-white/90 hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h1 class="text-xl sm:text-2xl font-bold text-white">{{ __('app.staff.edit_staff') }}</h1>
        </div>

        <div class="backdrop-blur-xl glass-panel border border-white/25 rounded-2xl p-6 sm:p-8">
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-400/30">
                <ul class="text-sm text-red-200 space-y-1">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('staff.update', $staff) }}" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="block text-sm font-medium text-white/90 mb-2">{{ __('app.staff.name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $staff->name) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:ring-2 focus:ring-[#83b735] focus:border-transparent">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-white/90 mb-2">{{ __('app.staff.email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $staff->email) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:ring-2 focus:ring-[#83b735] focus:border-transparent">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-white/90 mb-2">{{ __('app.staff.phone') }}</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $staff->phone) }}" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:ring-2 focus:ring-[#83b735] focus:border-transparent">
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium text-white/90 mb-2">{{ __('app.staff.role') }}</label>
                    <input type="text" name="role" id="role" value="{{ old('role', $staff->role) }}" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:ring-2 focus:ring-[#83b735] focus:border-transparent">
                </div>
                <div>
                    <label for="department" class="block text-sm font-medium text-white/90 mb-2">{{ __('app.staff.department') }}</label>
                    <input type="text" name="department" id="department" value="{{ old('department', $staff->department) }}" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:ring-2 focus:ring-[#83b735] focus:border-transparent">
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#83b735] text-white font-semibold hover:bg-[#6f9d2d] transition-all">Update</button>
                    <a href="{{ route('staff.index') }}" class="px-6 py-2.5 rounded-xl glass-solid border border-white/20 text-white text-sm hover:bg-white/20 transition-all">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
