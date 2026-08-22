<?php

namespace App\Http\Controllers\sitio\solicitud\fotoperfil;

use App\Http\Controllers\Controller;
use App\Http\Requests\FotoPerfilRequest;
use App\Models\Sitio;
use Illuminate\Http\Request;

class SolicitudFotoPerfilControlador extends Controller
{
    public function create()
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $perfil = $sitio->perfil;

        return view('admin.solicitud.fotoperfil.create', compact('sitio', 'perfil'));
    }

    public function store(FotoPerfilRequest $request)
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio || !$sitio->perfil) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $file = $request->file('foto_perfil');
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . '_' . uniqid() . '.' . $extension;
        $destinationPath = public_path('uploads/perfiles');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Eliminar foto antigua si existe y no es default
        if ($sitio->perfil->foto_perfil && file_exists(public_path($sitio->perfil->foto_perfil))) {
            @unlink(public_path($sitio->perfil->foto_perfil));
        }

        $file->move($destinationPath, $fileName);
        $path = 'uploads/perfiles/' . $fileName;

        $sitio->perfil->update([
            'foto_perfil' => $path,
        ]);

        return redirect()->route('perfil.create')->with('success', 'Foto de perfil guardada correctamente.');
    }
}
