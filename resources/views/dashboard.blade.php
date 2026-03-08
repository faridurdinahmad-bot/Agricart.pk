@extends('layouts.app')

@section('title', 'Dashboard - Agricart ERP')

@section('content')
{{-- Two crystal forms: Menus (left) | Key Metrics (right) --}}
<div class="flex-1 flex min-h-[calc(100vh-12rem)] p-3 sm:p-4 md:p-5">
    <div class="flex-1 flex flex-row gap-3 sm:gap-4 md:gap-5 w-full max-w-7xl mx-auto h-full min-h-0">
        {{-- Crystal Form 1 (Left) - Menus --}}
        <div class="flex-1 min-w-0 min-h-full backdrop-blur-2xl bg-white/10 border border-white/25 rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.2)] overflow-hidden flex flex-col ring-1 ring-white/10">
            <div class="px-4 sm:px-5 md:px-6 pt-4 sm:pt-5 md:pt-6 pb-3 border-b border-white/20">
                <h2 class="text-base sm:text-lg font-bold text-white uppercase tracking-wider">{{ __('app.dashboard.menus') }}</h2>
            </div>
            {{-- Three sections: MAIN | SUB | ACTIONS --}}
            <div class="flex-1 flex flex-row min-h-0 overflow-hidden" x-data="{ selected: 'users_staff' }">
                {{-- MAIN --}}
                <div class="flex-1 min-w-0 flex flex-col border-r border-white/20 p-3 overflow-auto">
                    <h3 class="text-xs font-bold text-white/90 uppercase tracking-wider mb-3">{{ __('app.menu.main') }}</h3>
                    <div class="space-y-1.5">
                        @foreach (['users_staff', 'contacts', 'inventory', 'purchase', 'sales', 'finance', 'logistics', 'reports', 'settings'] as $item)
                        <button type="button"
                            @click="selected = '{{ $item }}'"
                            :class="selected === '{{ $item }}' ? 'bg-[#83b735]/20 border-[#83b735]/40 text-[#83b735]' : 'bg-white/5 border-white/10 text-white hover:bg-[#83b735]/20 hover:border-[#83b735]/40'"
                            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl border transition-all text-left text-sm font-medium">
                            <span class="text-[#83b735] shrink-0">@include('components.menu-icons.' . $item)</span>
                            <span>{{ __('app.menu.' . $item) }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
                {{-- SUB --}}
                <div class="flex-1 min-w-0 flex flex-col border-r border-white/20 p-3 overflow-auto">
                    <h3 class="text-xs font-bold text-white/90 uppercase tracking-wider mb-3">{{ __('app.menu.sub') }}</h3>
                    <div class="flex-1" x-show="selected === 'users_staff'" x-transition>
                        <div class="space-y-1.5">
                            @foreach (['staff_list', 'roles_permissions', 'attendance_leave', 'payroll'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white hover:bg-[#83b735]/20 hover:border-[#83b735]/40 transition-all text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_users_staff.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'contacts'" x-transition>
                        <div class="space-y-1.5">
                            @foreach (['customers', 'customer_groups', 'vendors', 'vendor_groups'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white hover:bg-[#83b735]/20 hover:border-[#83b735]/40 transition-all text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_contacts.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'inventory'" x-transition>
                        <div class="space-y-1.5">
                            @foreach (['product_catalog', 'categories', 'brand', 'unit', 'warranty', 'return_policy'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white hover:bg-[#83b735]/20 hover:border-[#83b735]/40 transition-all text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_inventory.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'purchase'" x-transition>
                        <div class="space-y-1.5">
                            @foreach (['purchase_quotations', 'purchase_orders', 'add_new_purchase', 'purchase_list', 'purchase_return'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white hover:bg-[#83b735]/20 hover:border-[#83b735]/40 transition-all text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_purchase.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'sales'" x-transition>
                        <div class="space-y-1.5">
                            @foreach (['new_sale', 'hold_invoices', 'sales_list', 'sales_quotations', 'sales_returns'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white hover:bg-[#83b735]/20 hover:border-[#83b735]/40 transition-all text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_sales.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'finance'" x-transition>
                        <div class="space-y-1.5">
                            @foreach (['accounts', 'income', 'expenses', 'transactions'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white hover:bg-[#83b735]/20 hover:border-[#83b735]/40 transition-all text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_finance.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'logistics'" x-transition>
                        <div class="space-y-1.5">
                            @foreach (['shipping_carriers', 'shipment_tracking', 'delivery_vehicles', 'logistics_cost'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white hover:bg-[#83b735]/20 hover:border-[#83b735]/40 transition-all text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_logistics.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'reports'" x-transition>
                        <div class="space-y-1.5">
                            @foreach (['sales_reports', 'purchase_reports', 'inventory_reports', 'finance_reports', 'staff_contacts_reports'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white hover:bg-[#83b735]/20 hover:border-[#83b735]/40 transition-all text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_reports.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'settings'" x-transition>
                        <div class="space-y-1.5">
                            @foreach (['business_profile', 'user_management', 'synchronization', 'theme_settings', 'backup_restore', 'sms_email_settings'] as $sub)
                            <button type="button" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white hover:bg-[#83b735]/20 hover:border-[#83b735]/40 transition-all text-left text-sm font-medium">
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
                <div class="flex-1 min-w-0 flex flex-col p-3 overflow-auto">
                    <h3 class="text-xs font-bold text-white/90 uppercase tracking-wider mb-3">{{ __('app.menu.actions') }}</h3>
                    <div class="flex-1 flex items-center justify-center p-4">
                        <p class="text-sm text-white/50 text-center">{{ __('app.menu.actions_placeholder') }}</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- Crystal Form 2 (Right) - Key Metrics - 4 columns side by side --}}
        <div class="flex-1 min-w-0 min-h-full backdrop-blur-2xl bg-white/10 border border-white/25 rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.2)] overflow-hidden flex flex-col ring-1 ring-white/10">
            <div class="px-4 sm:px-5 md:px-6 pt-4 sm:pt-5 md:pt-6 pb-3 border-b border-white/20">
                <h2 class="text-base sm:text-lg font-bold text-white uppercase tracking-wider">{{ __('app.dashboard.key_metrics') }}</h2>
            </div>
            <div class="flex-1 p-3 sm:p-4 md:p-5 overflow-auto min-h-0">
                <div class="flex flex-row gap-2 sm:gap-3 md:gap-4 h-full min-h-0">
                    @foreach (['sales_cash', 'inventory_health', 'purchase_flow', 'customers_service'] as $group)
                    <div class="flex-1 min-w-0 flex flex-col gap-1.5 sm:gap-2">
                        <h3 class="text-[10px] sm:text-xs font-bold text-white/90 uppercase tracking-wider shrink-0">{{ __('app.metrics.' . $group . '_title') }}</h3>
                        <div class="flex flex-col gap-1.5 sm:gap-2 flex-1 min-h-0 overflow-auto">
                            @foreach (config('metrics.' . $group) as $key)
                            <div class="rounded-xl bg-white/5 border border-white/15 p-3 shadow-sm hover:bg-white/10 hover:border-white/25 transition-all shrink-0 ring-1 ring-white/5">
                                <p class="text-xs sm:text-sm font-medium text-white/90">{{ __('app.metrics.' . $key) }}</p>
                                <div class="mt-2 h-6 flex items-center">
                                    <span class="text-sm font-semibold text-[#83b735]">0</span>
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
