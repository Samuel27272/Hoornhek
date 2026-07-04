<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function users()
    {
        $users = User::with('role')->orderBy('name')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        $roles = Role::orderBy('display_name')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|string|min:8|confirmed',
            'role_id'         => 'required|exists:roles,id',
            'geboortedatum'   => 'nullable|date',
            'straatnaam'      => 'nullable|string|max:255',
            'huisnummer'      => 'nullable|integer|min:1|max:99999',
            'postcode'        => 'nullable|string|max:7|regex:/^[1-9][0-9]{3}\s?[A-Za-z]{2}$/',
            'woonplaats'      => 'nullable|string|max:255',
            'telefoonnummer'  => 'nullable|string|max:20|regex:/^[0-9+\-\s()]{3,20}$/',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Gebruiker aangemaakt.');
    }

    public function editUser(User $user)
    {
        $roles = Role::orderBy('display_name')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id'  => 'required|exists:roles,id',
            'geboortedatum'   => 'nullable|date',
            'straatnaam'      => 'nullable|string|max:255',
            'huisnummer'      => 'nullable|integer|min:1|max:99999',
            'postcode'        => 'nullable|string|max:7|regex:/^[1-9][0-9]{3}\s?[A-Za-z]{2}$/',
            'woonplaats'      => 'nullable|string|max:255',
            'telefoonnummer'  => 'nullable|string|max:20|regex:/^[0-9+\-\s()]{3,20}$/',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Gebruiker bijgewerkt.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Je kunt jezelf niet verwijderen.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Gebruiker verwijderd.');
    }

    public function roles()
    {
        $roles = Role::with('permissions')->orderBy('display_name')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function editRole(Role $role)
    {
        $permissions = Permission::orderBy('group')->orderBy('display_name')->get();
        $permissionsPerGroep = $permissions->groupBy('group');
        return view('admin.roles.edit', compact('role', 'permissionsPerGroep'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $role->permissions()->sync($request->input('permissions', []));
        return redirect()->route('admin.roles.index')->with('success', 'Rechten opgeslagen.');
    }

    public function createRole()
    {
        $permissions = Permission::orderBy('group')->orderBy('display_name')->get();
        $permissionsPerGroep = $permissions->groupBy('group');
        return view('admin.roles.create', compact('permissionsPerGroep'));
    }

    public function storeRole(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:50|unique:roles,name',
            'display_name' => 'required|string|max:100',
        ]);

        $role = Role::create($data);
        $role->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.roles.index')->with('success', 'Rol aangemaakt.');
    }

    public function destroyRole(Role $role)
    {
        if ($role->users()->exists()) {
            return redirect()->route('admin.roles.index')->with('error', 'Deze rol is nog gekoppeld aan gebruikers en kan niet verwijderd worden.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Rol verwijderd.');
    }

    public function loginLogs()
    {
        $logs = \App\Models\LoginLog::with('user')->latest('created_at')->paginate(20);
        return view('admin.login-logs', compact('logs'));
    }
}
