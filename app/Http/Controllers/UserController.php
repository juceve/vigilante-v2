<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:users.index')->only('index');
        // $this->middleware('can:users.create')->only('create', 'store');
        $this->middleware('can:users.edit')->only('edit', 'update', 'cambiaestado');
        // $this->middleware('can:users.destroy')->only('destroy');
    }
    public function index()
    {
        $users = User::all();

        return view('admin.user.index', compact('users'))
            ->with('i', 0);
    }

    public function create()
    {
        $user = new User();
        return view('admin.user.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3|confirmed',

        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                // 'status' => $request->status,
            ])->assignRole('Usuario');

            DB::commit();
            return redirect()->route('users.index')
                ->with('success', 'Usuario creado correctamente.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('users.index')
                ->with('error', 'Ha ocurrido un error.');
        }
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id
        ]);

        $user->update($request->all());

        return redirect()->route('users.index')
            ->with('success', 'Usuario editado correctamente');
    }

    public function destroy($id)
    {
        $user = User::find($id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado correctamente');
    }

    public function profile(User $user)
    {
        dd($user);
    }

    public function asinaRol(User $user)
    {
        $roles = Role::all();
        return view('user.asignaRol', compact('user', 'roles'));
    }


    public function updateRol(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);

        return redirect()->route('users.asignaRol', $user)
            ->with('success', 'Roles asignados correctamente');
    }

    public function cambiaestado($id)
    {
        $user = User::find($id);
        $user->update([
            'status' => !$user->status
        ]);

        return redirect()->route('users')->with('success', 'Usuario modificado correctamente');
    }
}
