@extends('layouts.app')

@section('title', 'Dashboard - Agricart ERP')

@section('content')
{{-- Welcome bar --}}
<div class="page-container pt-4 sm:pt-5">
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

{{-- Two panels: on mobile stack vertically, from md (768px) up side by side like desktop --}}
<div class="flex-1 flex min-h-0 w-full overflow-x-hidden p-3 sm:p-4 md:p-5">
    <div class="flex flex-col md:flex-row gap-3 sm:gap-4 md:gap-5 w-full max-w-7xl mx-auto min-h-0 flex-1">
        {{-- Panel 1 - Menus --}}
        <div class="flex-1 min-w-0 min-h-[280px] md:min-h-[calc(100vh-16rem)] max-h-[50vh] md:max-h-none backdrop-blur-2xl glass-panel border border-white/25 rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.25),0_0_0_1px_rgba(255,255,255,0.05)_inset] overflow-hidden flex flex-col">
            <div class="px-4 sm:px-5 md:px-6 pt-4 sm:pt-5 md:pt-6 pb-3 border-b border-white/20 bg-white/5">
                <h2 class="text-base sm:text-lg font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <span class="w-1 h-5 rounded-full bg-[#83b735]"></span>
                    {{ __('app.dashboard.menus') }}
                </h2>
            </div>
            {{-- Three sections: on mobile stack (flex-col), on md+ side by side (flex-row) --}}
            <div class="flex-1 flex flex-col md:flex-row min-h-0 overflow-hidden overflow-x-auto md:overflow-x-visible" x-data="{ selected: 'users_staff', selectedSub: '' }">
                {{-- MAIN --}}
                <div class="flex-1 min-w-0 flex flex-col md:border-r border-white/15 p-3 overflow-auto bg-white/[0.02] shrink-0 md:shrink">
                    <h3 class="text-[10px] font-bold text-white/70 uppercase tracking-widest mb-3 px-1">{{ __('app.menu.main') }}</h3>
                    <div class="space-y-1">
                        @foreach (['users_staff', 'contacts', 'inventory', 'purchase', 'sales', 'finance', 'logistics', 'reports', 'settings'] as $item)
                        <button type="button"
                            @click="selected = '{{ $item }}'; selectedSub = ''"
                            :class="selected === '{{ $item }}' ? 'bg-[#83b735]/25 border-[#83b735]/50 text-white shadow-lg shadow-[#83b735]/10' : 'bg-white/5 border-white/10 text-white/90 hover:bg-white/10 hover:border-[#83b735]/30'"
                            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl border transition-all duration-200 text-left text-sm font-medium group">
                            <span class="shrink-0 transition-colors" :class="selected === '{{ $item }}' ? 'text-[#83b735]' : 'text-[#83b735]/70 group-hover:text-[#83b735]'">@include('components.menu-icons.' . $item)</span>
                            <span>{{ __('app.menu.' . $item) }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
                {{-- SUB --}}
                <div class="flex-1 min-w-0 flex flex-col md:border-r border-white/15 p-3 overflow-auto shrink-0 md:shrink">
                    <h3 class="text-[10px] font-bold text-white/70 uppercase tracking-widest mb-3 px-1">{{ __('app.menu.sub') }}</h3>
                    <div class="flex-1" x-show="selected === 'users_staff'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['staff_list', 'roles_permissions', 'attendance_leave', 'payroll'] as $sub)
                            <button type="button" @click="selectedSub = '{{ $sub }}'" :class="selectedSub === '{{ $sub }}' ? 'bg-[#83b735]/15 border-[#83b735]/40' : ''" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_users_staff.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'contacts'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['customers', 'customer_groups', 'vendors', 'vendor_groups'] as $sub)
                            <button type="button" @click="selectedSub = '{{ $sub }}'" :class="selectedSub === '{{ $sub }}' ? 'bg-[#83b735]/15 border-[#83b735]/40' : ''" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_contacts.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'inventory'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['product_catalog', 'categories', 'brand', 'unit', 'warranty', 'return_policy'] as $sub)
                            <button type="button" @click="selectedSub = '{{ $sub }}'" :class="selectedSub === '{{ $sub }}' ? 'bg-[#83b735]/15 border-[#83b735]/40' : ''" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_inventory.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'purchase'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['purchase_quotations', 'purchase_orders', 'add_new_purchase', 'purchase_list', 'purchase_return'] as $sub)
                            <button type="button" @click="selectedSub = '{{ $sub }}'" :class="selectedSub === '{{ $sub }}' ? 'bg-[#83b735]/15 border-[#83b735]/40' : ''" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_purchase.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'sales'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['new_sale', 'hold_invoices', 'sales_list', 'sales_quotations', 'sales_returns'] as $sub)
                            <button type="button" @click="selectedSub = '{{ $sub }}'" :class="selectedSub === '{{ $sub }}' ? 'bg-[#83b735]/15 border-[#83b735]/40' : ''" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_sales.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'finance'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['accounts', 'income', 'expenses', 'transactions'] as $sub)
                            <button type="button" @click="selectedSub = '{{ $sub }}'" :class="selectedSub === '{{ $sub }}' ? 'bg-[#83b735]/15 border-[#83b735]/40' : ''" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_finance.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'logistics'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['shipping_carriers', 'shipment_tracking', 'delivery_vehicles', 'logistics_cost'] as $sub)
                            <button type="button" @click="selectedSub = '{{ $sub }}'" :class="selectedSub === '{{ $sub }}' ? 'bg-[#83b735]/15 border-[#83b735]/40' : ''" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_logistics.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'reports'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['sales_reports', 'purchase_reports', 'inventory_reports', 'finance_reports', 'logistics_reports', 'staff_contacts_reports'] as $sub)
                            <button type="button" @click="selectedSub = '{{ $sub }}'" :class="selectedSub === '{{ $sub }}' ? 'bg-[#83b735]/15 border-[#83b735]/40' : ''" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
                                <span>{{ __('app.menu.sub_reports.' . $sub) }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-1" x-show="selected === 'settings'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="space-y-1">
                            @foreach (['business_profile', 'user_management', 'synchronization', 'theme_settings', 'backup_restore', 'sms_email_settings'] as $sub)
                            <button type="button" @click="selectedSub = '{{ $sub }}'" :class="selectedSub === '{{ $sub }}' ? 'bg-[#83b735]/15 border-[#83b735]/40' : ''" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium">
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
                <div class="flex-1 min-w-0 flex flex-col p-3 overflow-auto bg-white/[0.02] shrink-0 md:shrink min-w-[140px]">
                    <h3 class="text-[10px] font-bold text-white/70 uppercase tracking-widest mb-3 px-1">{{ __('app.menu.actions') }}</h3>
                    {{-- Staff List actions --}}
                    <div class="flex-1" x-show="selectedSub === 'staff_list'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('staff.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.staff.view_all') }}</span>
                            </a>
                            <a href="{{ route('staff.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.staff.add_staff') }}</span>
                            </a>
                            <a href="{{ route('staff.index', ['import' => 1]) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.staff.import_staff') }}</span>
                            </a>
                            <a href="{{ route('staff.export') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.staff.export_staff') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Attendance & Leave actions --}}
                    <div class="flex-1" x-show="selectedSub === 'attendance_leave'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('attendance.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.attendance_leave.view_attendance') }}</span>
                            </a>
                            <a href="{{ route('attendance.mark') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.attendance_leave.mark_attendance') }}</span>
                            </a>
                            <a href="{{ route('attendance.report') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.attendance_leave.attendance_report') }}</span>
                            </a>
                            <a href="{{ route('leave-requests.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.attendance_leave.leave_requests') }}</span>
                            </a>
                            <a href="{{ route('leave-requests.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.attendance_leave.apply_leave') }}</span>
                            </a>
                            <a href="{{ route('leave-types.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.attendance_leave.leave_types') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Payroll actions --}}
                    <div class="flex-1" x-show="selectedSub === 'payroll'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('payroll.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.payroll_menu.view_payroll') }}</span>
                            </a>
                            <a href="{{ route('payroll.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.payroll_menu.generate_payroll') }}</span>
                            </a>
                            <a href="{{ route('payroll.salaries') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.payroll_menu.salary_setup') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Customers actions --}}
                    <div class="flex-1" x-show="selectedSub === 'customers'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('customers.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.contacts_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('customers.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.contacts_menu.add_customer') }}</span>
                            </a>
                            <a href="{{ route('customers.index', ['import' => 1]) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.contacts_menu.import_customers') }}</span>
                            </a>
                            <a href="{{ route('customers.export') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.contacts_menu.export_customers') }}</span>
                            </a>
                            <a href="{{ route('customer-groups.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.contacts_menu.customer_groups') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Customer Groups actions --}}
                    <div class="flex-1" x-show="selectedSub === 'customer_groups'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('customer-groups.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.contacts_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('customer-groups.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.contacts_menu.add_group') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Vendors actions --}}
                    <div class="flex-1" x-show="selectedSub === 'vendors'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('vendors.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.contacts_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('vendors.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.contacts_menu.add_vendor') }}</span>
                            </a>
                            <a href="{{ route('vendors.index', ['import' => 1]) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.contacts_menu.import_vendors') }}</span>
                            </a>
                            <a href="{{ route('vendors.export') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.contacts_menu.export_vendors') }}</span>
                            </a>
                            <a href="{{ route('vendor-groups.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.contacts_menu.vendor_groups') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Product Catalog actions --}}
                    <div class="flex-1" x-show="selectedSub === 'product_catalog'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('products.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('products.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.add_product') }}</span>
                            </a>
                            <a href="{{ route('products.index', ['import' => 1]) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.import_products') }}</span>
                            </a>
                            <a href="{{ route('products.export') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.export_products') }}</span>
                            </a>
                            <a href="{{ route('categories.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.categories') }}</span>
                            </a>
                            <a href="{{ route('units.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.units') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Categories actions --}}
                    <div class="flex-1" x-show="selectedSub === 'categories'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('categories.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('categories.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.add_category') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Brand actions --}}
                    <div class="flex-1" x-show="selectedSub === 'brand'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('brands.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('brands.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.add_brand') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Unit actions --}}
                    <div class="flex-1" x-show="selectedSub === 'unit'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('units.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('units.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.add_unit') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Warranty actions --}}
                    <div class="flex-1" x-show="selectedSub === 'warranty'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('warranties.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('warranties.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.add_warranty') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Return Policy actions --}}
                    <div class="flex-1" x-show="selectedSub === 'return_policy'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('return-policies.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('return-policies.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.inventory_menu.add_return_policy') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Vendor Groups actions --}}
                    <div class="flex-1" x-show="selectedSub === 'vendor_groups'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('vendor-groups.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.contacts_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('vendor-groups.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.contacts_menu.add_group') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Roles & Permissions actions --}}
                    <div class="flex-1" x-show="selectedSub === 'roles_permissions'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('roles.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.roles_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('roles.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.roles_menu.add_role') }}</span>
                            </a>
                            <a href="{{ route('roles.assign') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.roles_menu.assign_to_staff') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Purchase Quotations actions (placeholder) --}}
                    <div class="flex-1" x-show="selectedSub === 'purchase_quotations'" x-transition>
                        <div class="flex items-center justify-center p-4">
                            <p class="text-sm text-white/50 text-center">{{ __('app.menu.purchase_menu.coming_soon') }}</p>
                        </div>
                    </div>
                    {{-- Purchase Orders actions --}}
                    <div class="flex-1" x-show="selectedSub === 'purchase_orders'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('purchases.index', ['type' => 'order']) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.purchase_menu.view_all_orders') }}</span>
                            </a>
                            <a href="{{ route('purchases.create', ['type' => 'order']) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.purchase_menu.add_order') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Add New Purchase (Direct) actions --}}
                    <div class="flex-1" x-show="selectedSub === 'add_new_purchase'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('purchases.create', ['type' => 'direct']) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.purchase_menu.add_direct') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Purchase List actions --}}
                    <div class="flex-1" x-show="selectedSub === 'purchase_list'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('purchases.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.purchase_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('purchases.create', ['type' => 'order']) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.purchase_menu.add_order') }}</span>
                            </a>
                            <a href="{{ route('purchases.create', ['type' => 'direct']) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.purchase_menu.add_direct') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Purchase Return actions --}}
                    <div class="flex-1" x-show="selectedSub === 'purchase_return'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('purchase-returns.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.purchase_menu.view_all_returns') }}</span>
                            </a>
                            <a href="{{ route('purchase-returns.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.purchase_menu.add_return') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Sales Quotations (placeholder) --}}
                    <div class="flex-1" x-show="selectedSub === 'sales_quotations'" x-transition>
                        <div class="flex items-center justify-center p-4">
                            <p class="text-sm text-white/50 text-center">{{ __('app.menu.sales_menu.coming_soon') }}</p>
                        </div>
                    </div>
                    {{-- New Sale actions --}}
                    <div class="flex-1" x-show="selectedSub === 'new_sale'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('sales.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.sales_menu.new_sale') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Hold Invoices actions --}}
                    <div class="flex-1" x-show="selectedSub === 'hold_invoices'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('sales.hold') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.sales_menu.view_hold') }}</span>
                            </a>
                            <a href="{{ route('sales.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.sales_menu.new_sale') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Sales List actions --}}
                    <div class="flex-1" x-show="selectedSub === 'sales_list'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('sales.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.sales_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('sales.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.sales_menu.new_sale') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Sales Returns actions --}}
                    <div class="flex-1" x-show="selectedSub === 'sales_returns'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('sale-returns.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.sales_menu.view_all_returns') }}</span>
                            </a>
                            <a href="{{ route('sale-returns.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.sales_menu.add_return') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Accounts actions --}}
                    <div class="flex-1" x-show="selectedSub === 'accounts'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('accounts.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.finance_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('accounts.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.finance_menu.add_account') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Income actions --}}
                    <div class="flex-1" x-show="selectedSub === 'income'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('transactions.income') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.finance_menu.view_income') }}</span>
                            </a>
                            <a href="{{ route('transactions.create', ['type' => 'income']) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.finance_menu.add_income') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Expenses actions --}}
                    <div class="flex-1" x-show="selectedSub === 'expenses'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('transactions.expenses') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.finance_menu.view_expenses') }}</span>
                            </a>
                            <a href="{{ route('transactions.create', ['type' => 'expense']) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.finance_menu.add_expense') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Logistics: Shipping Carriers actions --}}
                    <div class="flex-1" x-show="selectedSub === 'shipping_carriers'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('shipping-carriers.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.logistics_menu.view_all_carriers') }}</span>
                            </a>
                            <a href="{{ route('shipping-carriers.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.logistics_menu.add_carrier') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Logistics: Shipment Tracking actions --}}
                    <div class="flex-1" x-show="selectedSub === 'shipment_tracking'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('shipments.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.logistics_menu.view_all_shipments') }}</span>
                            </a>
                            <a href="{{ route('shipments.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.logistics_menu.add_shipment') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Logistics: Delivery Vehicles actions --}}
                    <div class="flex-1" x-show="selectedSub === 'delivery_vehicles'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('delivery-vehicles.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.logistics_menu.view_all_vehicles') }}</span>
                            </a>
                            <a href="{{ route('delivery-vehicles.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.logistics_menu.add_vehicle') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Logistics: Logistics Cost actions --}}
                    <div class="flex-1" x-show="selectedSub === 'logistics_cost'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('logistics-costs.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.logistics_menu.view_all_costs') }}</span>
                            </a>
                            <a href="{{ route('logistics-costs.create') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.logistics_menu.add_cost') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Reports: Sales actions --}}
                    <div class="flex-1" x-show="selectedSub === 'sales_reports'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('reports.sales') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.sales_report') }}</span>
                            </a>
                            <a href="{{ route('sales.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_sales') }}</span>
                            </a>
                            <a href="{{ route('sale-returns.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_sale_returns') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Reports: Purchase actions --}}
                    <div class="flex-1" x-show="selectedSub === 'purchase_reports'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('reports.purchase') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.purchase_report') }}</span>
                            </a>
                            <a href="{{ route('purchases.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_purchases') }}</span>
                            </a>
                            <a href="{{ route('purchase-returns.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_purchase_returns') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Reports: Inventory actions --}}
                    <div class="flex-1" x-show="selectedSub === 'inventory_reports'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('reports.inventory') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.inventory_report') }}</span>
                            </a>
                            <a href="{{ route('products.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_products') }}</span>
                            </a>
                            <a href="{{ route('products.index', ['low_stock' => 1]) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.low_stock') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Reports: Finance actions --}}
                    <div class="flex-1" x-show="selectedSub === 'finance_reports'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('reports.finance') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.finance_report') }}</span>
                            </a>
                            <a href="{{ route('accounts.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_accounts') }}</span>
                            </a>
                            <a href="{{ route('transactions.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_transactions') }}</span>
                            </a>
                            <a href="{{ route('transactions.income') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_income') }}</span>
                            </a>
                            <a href="{{ route('transactions.expenses') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_expenses') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Reports: Logistics actions --}}
                    <div class="flex-1" x-show="selectedSub === 'logistics_reports'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('reports.logistics') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.logistics_report') }}</span>
                            </a>
                            <a href="{{ route('shipments.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_shipments') }}</span>
                            </a>
                            <a href="{{ route('shipping-carriers.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_carriers') }}</span>
                            </a>
                            <a href="{{ route('logistics-costs.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_logistics_costs') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Reports: Staff & Contacts actions --}}
                    <div class="flex-1" x-show="selectedSub === 'staff_contacts_reports'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('reports.staff-contacts') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.staff_contacts_report') }}</span>
                            </a>
                            <a href="{{ route('staff.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_staff') }}</span>
                            </a>
                            <a href="{{ route('attendance.report') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.attendance_report') }}</span>
                            </a>
                            <a href="{{ route('customers.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_customers') }}</span>
                            </a>
                            <a href="{{ route('vendors.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.reports_menu.view_vendors') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Settings: Business Profile actions --}}
                    <div class="flex-1" x-show="selectedSub === 'business_profile'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('settings.business') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.settings_menu.business_profile') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Settings: User Management actions --}}
                    <div class="flex-1" x-show="selectedSub === 'user_management'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('staff.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.settings_menu.view_staff') }}</span>
                            </a>
                            <a href="{{ route('roles.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.settings_menu.view_roles') }}</span>
                            </a>
                            <a href="{{ route('roles.assign') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.settings_menu.assign_roles') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Settings: Synchronization actions --}}
                    <div class="flex-1" x-show="selectedSub === 'synchronization'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('settings.sync') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.settings_menu.synchronization') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Settings: Theme Settings actions --}}
                    <div class="flex-1" x-show="selectedSub === 'theme_settings'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('settings.theme') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.settings_menu.theme_settings') }}</span>
                            </a>
                            <a href="{{ route('settings.theme') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.settings_menu.change_language') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Settings: Backup & Restore actions --}}
                    <div class="flex-1" x-show="selectedSub === 'backup_restore'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('settings.backup') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.settings_menu.backup_restore') }}</span>
                            </a>
                            <a href="{{ route('settings.backup') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.settings_menu.backup') }}</span>
                            </a>
                            <a href="{{ route('settings.backup') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.settings_menu.restore') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Settings: SMS/Email Settings actions --}}
                    <div class="flex-1" x-show="selectedSub === 'sms_email_settings'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('settings.sms-email') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.settings_menu.sms_email_settings') }}</span>
                            </a>
                            <a href="{{ route('settings.sms-email') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.settings_menu.sms_settings') }}</span>
                            </a>
                            <a href="{{ route('settings.sms-email') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.settings_menu.email_settings') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Transactions actions --}}
                    <div class="flex-1" x-show="selectedSub === 'transactions'" x-transition>
                        <div class="space-y-1.5">
                            <a href="{{ route('transactions.index') }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.finance_menu.view_all') }}</span>
                            </a>
                            <a href="{{ route('transactions.create', ['type' => 'income']) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.finance_menu.add_income') }}</span>
                            </a>
                            <a href="{{ route('transactions.create', ['type' => 'expense']) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.finance_menu.add_expense') }}</span>
                            </a>
                            <a href="{{ route('transactions.create', ['type' => 'transfer']) }}" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/90 hover:bg-[#83b735]/15 hover:border-[#83b735]/40 transition-all duration-200 text-left text-sm font-medium block">
                                <span>{{ __('app.menu.finance_menu.add_transfer') }}</span>
                            </a>
                        </div>
                    </div>
                    {{-- Default placeholder --}}
                    <div class="flex-1 flex items-center justify-center p-4" x-show="!['staff_list','roles_permissions','attendance_leave','payroll','customers','customer_groups','vendors','vendor_groups','product_catalog','categories','brand','unit','warranty','return_policy','purchase_quotations','purchase_orders','add_new_purchase','purchase_list','purchase_return','new_sale','hold_invoices','sales_list','sales_quotations','sales_returns','accounts','income','expenses','transactions','shipping_carriers','shipment_tracking','delivery_vehicles','logistics_cost','sales_reports','purchase_reports','inventory_reports','finance_reports','logistics_reports','staff_contacts_reports','business_profile','user_management','synchronization','theme_settings','backup_restore','sms_email_settings'].includes(selectedSub)" x-transition>
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
        {{-- Panel 2 - Key Metrics --}}
        <div class="flex-1 min-w-0 min-h-[240px] md:min-h-[calc(100vh-16rem)] backdrop-blur-2xl glass-panel border border-white/25 rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.25),0_0_0_1px_rgba(255,255,255,0.05)_inset] overflow-hidden flex flex-col">
            <div class="px-4 sm:px-5 md:px-6 pt-4 sm:pt-5 md:pt-6 pb-3 border-b border-white/20 bg-white/5 shrink-0">
                <h2 class="text-base sm:text-lg font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <span class="w-1 h-5 rounded-full bg-[#83b735]"></span>
                    {{ __('app.dashboard.key_metrics') }}
                </h2>
            </div>
            <div class="flex-1 p-3 sm:p-4 md:p-5 overflow-auto min-h-0">
                <div class="grid grid-cols-2 md:flex md:flex-row gap-2 sm:gap-3 md:gap-4 min-h-0">
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
