<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::withCount('staff')->latest()->paginate(15);

        return view('roles.index', compact('roles'));
    }

    public function create(): View
    {
        return view('roles.create', ['role' => new Role, 'permissionGroups' => config('permissions.groups')]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'max:100'],
        ]);

        Role::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'permissions' => $validated['permissions'] ?? [],
            'status' => 'active',
        ]);

        return redirect()->route('roles.index')->with('success', __('app.roles.created'));
    }

    public function edit(Role $role): View
    {
        return view('roles.edit', ['role' => $role, 'permissionGroups' => config('permissions.groups')]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name,' . $role->id],
            'description' => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'max:100'],
        ]);

        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'permissions' => $validated['permissions'] ?? [],
        ]);

        return redirect()->route('roles.index')->with('success', __('app.roles.updated'));
    }

    public function copy(Role $role): RedirectResponse
    {
        $newName = $role->name . ' (Copy)';
        $counter = 1;
        while (Role::where('name', $newName)->exists()) {
            $newName = $role->name . ' (Copy ' . $counter . ')';
            $counter++;
        }

        Role::copyFrom($role, $newName);

        return redirect()->route('roles.index')->with('success', __('app.roles.copied'));
    }

    public function assign(Request $request): View|RedirectResponse
    {
        $roles = Role::where('status', 'active')->orderBy('name')->get();
        $staff = Staff::with('role')->where('status', 'active')->orderBy('name')->paginate(20);

        return view('roles.assign', compact('roles', 'staff'));
    }

    public function assignStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'staff_id' => ['required', 'exists:staff,id'],
            'role_id' => ['nullable', 'exists:roles,id'],
        ]);

        Staff::findOrFail($validated['staff_id'])->update([
            'role_id' => $validated['role_id'] ?: null,
        ]);

        return redirect()->route('roles.assign')->with('success', __('app.roles.assigned'));
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->staff()->exists()) {
            return redirect()->route('roles.index')->with('error', __('app.roles.cannot_delete'));
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', __('app.roles.deleted'));
    }
}
