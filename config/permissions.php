<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Available Permissions (grouped by module)
    |--------------------------------------------------------------------------
    */
    'groups' => [
        'users_staff' => [
            'label' => 'Users & Staff',
            'permissions' => [
                'staff.view' => 'View Staff',
                'staff.create' => 'Add Staff',
                'staff.edit' => 'Edit Staff',
                'staff.delete' => 'Delete/Deactivate Staff',
                'roles.view' => 'View Roles',
                'roles.manage' => 'Manage Roles & Permissions',
            ],
        ],
        'contacts' => [
            'label' => 'Contacts',
            'permissions' => [
                'contacts.view' => 'View Contacts',
                'contacts.create' => 'Add Contacts',
                'contacts.edit' => 'Edit Contacts',
                'contacts.delete' => 'Delete Contacts',
            ],
        ],
        'inventory' => [
            'label' => 'Inventory',
            'permissions' => [
                'inventory.view' => 'View Inventory',
                'inventory.create' => 'Add Products',
                'inventory.edit' => 'Edit Inventory',
                'inventory.delete' => 'Delete Inventory',
            ],
        ],
        'purchase' => [
            'label' => 'Purchase',
            'permissions' => [
                'purchase.view' => 'View Purchase',
                'purchase.create' => 'Create Purchase',
                'purchase.edit' => 'Edit Purchase',
                'purchase.delete' => 'Delete Purchase',
            ],
        ],
        'sales' => [
            'label' => 'Sales',
            'permissions' => [
                'sales.view' => 'View Sales',
                'sales.create' => 'Create Sale',
                'sales.edit' => 'Edit Sales',
                'sales.delete' => 'Delete Sales',
            ],
        ],
        'finance' => [
            'label' => 'Finance',
            'permissions' => [
                'finance.view' => 'View Finance',
                'finance.create' => 'Manage Transactions',
                'finance.edit' => 'Edit Finance',
            ],
        ],
        'reports' => [
            'label' => 'Reports',
            'permissions' => [
                'reports.view' => 'View Reports',
                'reports.export' => 'Export Reports',
            ],
        ],
        'settings' => [
            'label' => 'Settings',
            'permissions' => [
                'settings.view' => 'View Settings',
                'settings.manage' => 'Manage Settings',
            ],
        ],
    ],

    'all' => [], // populated in service provider or we flatten in code
];
