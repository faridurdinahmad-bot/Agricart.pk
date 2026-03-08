@extends('layouts.app')

@section('title', 'Dashboard - Agricart ERP')

@section('content')
{{-- Welcome bar --}}
<div class="px-3 sm:px-4 md:px-5 pt-4 sm:pt-5">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-white">
                    {{ __('app.dashboard.welcome') }}, <span class="text-[#83b735]">{{ $user?->name ?? __('app.dashboard.default_user') }}</span>
                </h1>
                <p class="text-sm text-white/70 mt-0.5">{{ __('app.dashboard.subtitle') }}</p>
            </div>
            <div class="flex items-center gap-2 text-sm text-white/60">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>{{ now()->translatedFormat('l, F j, Y') }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Two crystal forms: Menus (left) | Key Metrics (right) --}}
<div class="flex-1 flex min-h-[calc(100vh-16rem)] p-3 sm:p-4 md:p-5">
    <div class="flex-1 flex flex-row gap-3 sm:gap-4 md:gap-5 w-full max-w-7xl mx-auto h-full min-h-0">
        {{-- Crystal Form 1 (Left) - Menus --}}
        <div class="flex-1 min-w-0 min-h-full backdrop-blur-2xl glass-panel border border-white/25 rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.25),0_0_0_1px_rgba(255,255,255,0.05)_inset] overflow-hidden flex flex-col">
            <div class="px-4 sm:px-5 md:px-6 pt-4 sm:pt-5 md:pt-6 pb-3 border-b border-white/20 bg-white/5">
                <h2 class="text-base sm:text-lg font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <span class="w-1 h-5 rounded-full bg-[#83b735]"></span>
                    {{ __('app.dashboard.menus') }}
                </h2>
            </div>
            {{-- Three sections: MAIN | SUB | ACTIONS --}}
            <div class="flex-1 flex flex-row min-h-0 overflow-hidden" x-data="{ selected: 'users_staff' }">
                {{-- MAIN --}}
                <div class="flex-1 min-w-0 flex flex-col border-r border-white/15 p-3 overflow-auto bg-white/[0.02]">
                    <h3 class="text-[10px] font-bold text-white/70 uppercase tracking-widest mb-3 px-1">{{ __('app.menu.main') }}</h3>
                    <div class="space-y-1">
                        @foreach (['users_staff', 'contacts', 'inventory', 'purchase', 'sales', 'finance', 'logistics', 'reports', 'settings'] as $item)
                        <button type="button"
                            @click="selected = '{{ $item }}'"
                            :class="selected === '{{ $item }}' ? 'bg-[#83b735]/25 border-[#83b735]/50 text-white shadow-lg shadow-[#83b735]/10' : 'bg-white/5 border-white/10 text-white/90 hover:bg-white/10 hover:border-[#83b735]/30'"
                            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl border transition-all duration-200 text-left text-sm font-medium group">
                            <span class="shrink-0 transition-colors" :class="selected === '{{ $item }}' ? 'text-[#83b735]' : 'text-[#83b735]/70 group-hover:text-[#83b735]'">@include('components.menu-icons.' . $item)</span>
                            <span>{{ __('app.menu.' . $item) }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
                {{-- SUB --}}
                <div class="flex-1 min-w-0 flex flex-col border-r border-white/15 p-3 overflow-auto">
                    <h3 class="text-[10px] font-bold text-white/70 uppercase tracking-widest mb-3 px-1">{{ __('app.menu.sub') }}</h3>
                    <div class="flex-1" x-show="selected === 'users_staff'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['staff_list', 'roles_permissions', 'attendance_leave', 'payroll'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_users_staff.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'contacts'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['customers', 'customer_groups', 'vendors', 'vendor_groups'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_contacts.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'inventory'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['product_catalog', 'categories', 'brand', 'unit', 'warranty', 'return_policy'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_inventory.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'purchase'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['purchase_quotations', 'purchase_orders', 'add_new_purchase', 'purchase_list', 'purchase_return'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_purchase.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'sales'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['new_sale', 'hold_invoices', 'sales_list', 'sales_quotations', 'sales_returns'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_sales.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'finance'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['accounts', 'income', 'expenses', 'transactions'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_finance.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'logistics'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['shipping_carriers', 'shipment_tracking', 'delivery_vehicles', 'logistics_cost'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_logistics.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'reports'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['sales_reports', 'purchase_reports', 'inventory_reports', 'finance_reports', 'staff_contacts_reports'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_reports.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'settings'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['business_profile', 'user_management', 'synchronization', 'theme_settings', 'backup_restore', 'sms_email_settings'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_settings.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1 flex items-center justify-center p-4 min-h-[120px]" x-show="!['users_staff','contacts','inventory','purchase','sales','finance','logistics','reports','settings'].includes(selected)" x-transition style="display: none;">
                        <p class="text-sm text-white/50 text-center">{{ __('app.menu.sub_placeholder') }}</p>
                    </div>
                </div>
                {{-- ACTIONS --}}
                <div class="flex-1 min-w-0 flex flex-col p-3 overflow-auto bg-white/[0.02]">
                    <h3 class="text-[10px] font-bold text-white/70 uppercase tracking-widest mb-3 px-1">{{ __('app.menu.actions') }}</h3>
                    <div class="flex-1 flex items-center justify-center p-4">
                        <div class="text-center">
                            <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                                </svg>
                            </div>
                            <p class="text-sm text-white/50">{{ __('app.menu.actions_placeholder') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Crystal Form 2 (Right) - Key Metrics --}}
        <div class="flex-1 min-w-0 min-h-full backdrop-blur-2xl glass-panel border border-white/25 rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.25),0_0_0_1px_rgba(255,255,255,0.05)_inset] overflow-hidden flex flex-col">
            <div class="px-4 sm:px-5 md:px-6 pt-4 sm:pt-5 md:pt-6 pb-3 border-b border-white/20 bg-white/5">
                <h2 class="text-base sm:text-lg font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <span class="w-1 h-5 rounded-full bg-[#83b735]"></span>
                    {{ __('app.dashboard.key_metrics') }}
                </h2>
            </div>
            <div class="flex-1 p-3 sm:p-4 md:p-5 overflow-auto min-h-0">
                <div class="flex flex-row gap-2 sm:gap-3 md:gap-4 h-full min-h-0">
                    @foreach (['sales_cash', 'inventory_health', 'purchase_flow', 'customers_service'] as $group)
                    <div class="flex-1 min-w-0 flex flex-col gap-1.5 sm:gap-2">
                        <h3 class="text-[10px] sm:text-xs font-bold text-white/80 uppercase tracking-widest shrink-0 px-1 flex items-center gap-1.5">
                            <span class="w-1 h-3 rounded-full bg-[#83b735]/60"></span>
                            {{ __('app.metrics.' . $group . '_title') }}
                        </h3>
                        <div class="flex flex-col gap-1.5 sm:gap-2 flex-1 min-h-0 overflow-auto">
                            @foreach (config('metrics.' . $group) as $key)
                            <div class="group rounded-xl bg-white/5 border border-white/10 p-3 shadow-sm hover:bg-white/10 hover:border-[#83b735]/30 transition-all duration-200 shrink-0 flex items-start gap-3">
                                <div class="shrink-0 w-8 h-8 rounded-lg bg-[#83b735]/10 border border-[#83b735]/20 flex items-center justify-center group-hover:bg-[#83b735]/20">
                                    <x-metric-icon :name="$key" class="!w-4 !h-4" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs sm:text-sm font-medium text-white/90 truncate">{{ __('app.metrics.' . $key) }}</p>
                                    <div class="mt-1.5 h-6 flex items-center">
                                        <span class="text-sm font-bold text-[#83b735]">0</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
