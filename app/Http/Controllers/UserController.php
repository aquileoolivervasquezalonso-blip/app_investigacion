<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Investigador;
use App\Models\CuerpoAcademico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('investigador')->orderBy('name')->get();
        $cuerpos = CuerpoAcademico::orderBy('nombre')->get();
        return view('admin.users', compact('users', 'cuerpos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'rol' => 'required|in:admin,investigador',
            'password' => 'required|string|min:6',
            // campos de perfil (solo si es investigador)
            'grado_academico' => 'nullable|string|max:255',
            'especialidad' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'cuerpo_academico_id' => 'nullable|exists:cuerpos_academicos,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cv' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'rol' => $data['rol'],
            'password' => Hash::make($data['password']),
        ]);

        // Si es investigador, crear su perfil en el directorio
        if ($data['rol'] === 'investigador') {
            $perfil = [
                'user_id' => $user->id,
                'nombre_completo' => $data['name'],
                'email' => $data['email'],
                'grado_academico' => $data['grado_academico'] ?? null,
                'especialidad' => $data['especialidad'] ?? null,
                'telefono' => $data['telefono'] ?? null,
                'cuerpo_academico_id' => $data['cuerpo_academico_id'] ?? null,
                'cv' => $data['cv'] ?? null,
            ];
            if ($request->hasFile('foto')) {
                $perfil['foto'] = $request->file('foto')->store('investigadores', 'public');
            }
            Investigador::create($perfil);
        }

        return back()->with('ok', 'Usuario registrado correctamente.');
    }

    public function show(User $user)
    {
        $user->load('investigador');
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'rol' => 'required|in:admin,investigador',
            'password' => 'nullable|string|min:6',
            'grado_academico' => 'nullable|string|max:255',
            'especialidad' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'cuerpo_academico_id' => 'nullable|exists:cuerpos_academicos,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cv' => 'nullable|string',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->rol = $data['rol'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        if ($data['rol'] === 'investigador') {
            // crear o actualizar el perfil ligado
            $perfil = $user->investigador ?? new Investigador(['user_id' => $user->id]);
            $perfil->user_id = $user->id;
            $perfil->nombre_completo = $data['name'];
            $perfil->email = $data['email'];
            $perfil->grado_academico = $data['grado_academico'] ?? null;
            $perfil->especialidad = $data['especialidad'] ?? null;
            $perfil->telefono = $data['telefono'] ?? null;
            $perfil->cuerpo_academico_id = $data['cuerpo_academico_id'] ?? null;
            $perfil->cv = $data['cv'] ?? null;

            if ($request->hasFile('foto')) {
                if ($perfil->foto) {
                    Storage::disk('public')->delete($perfil->foto);
                }
                $perfil->foto = $request->file('foto')->store('investigadores', 'public');
            }
            $perfil->save();
        } else {
            // si pasó de investigador a admin, eliminar su perfil
            if ($user->investigador) {
                if ($user->investigador->foto) {
                    Storage::disk('public')->delete($user->investigador->foto);
                }
                $user->investigador->delete();
            }
        }

        return back()->with('ok', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        if ($user->investigador) {
            if ($user->investigador->foto) {
                Storage::disk('public')->delete($user->investigador->foto);
            }
            $user->investigador->delete();
        }
        $user->delete();
        return back()->with('ok', 'Usuario eliminado correctamente.');
    }
}