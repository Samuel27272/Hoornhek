<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
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
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id'  => 'required|exists:roles,id',
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
}
