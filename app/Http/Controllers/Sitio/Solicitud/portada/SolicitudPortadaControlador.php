<?php

namespace App\Http\Controllers\sitio\solicitud\portada;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use Illuminate\Http\Request;

class SolicitudPortadaControlador extends Controller
{
    public function create()
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $perfil = $sitio->perfil;

        return view('admin.solicitud.portada.create', compact('sitio', 'perfil'));
    }

    public function store(Request $request)
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio || !$sitio->perfil) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $request->validate([
            'foto_portada' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120', // Máximo 5MB
                'dimensions:min_width=800,min_height=300',
            ],
        ], [
            'foto_portada.required'   => 'Debes seleccionar una imagen para la portada.',
            'foto_portada.image'      => 'El archivo seleccionado debe ser una imagen válida.',
            'foto_portada.mimes'      => 'La imagen debe ser de formato JPG, JPEG, PNG o WEBP.',
            'foto_portada.max'        => 'La imagen de portada no debe pesar más de 5 MB.',
            'foto_portada.dimensions' => 'La imagen de portada debe tener una dimensión mínima de 800x300 píxeles para adaptarse al contenedor.',
        ]);

        $file = $request->file('foto_portada');
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . '_' . uniqid() . '.' . $extension;
        $destinationPath = public_path('uploads/portada');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Eliminar foto antigua si existe
        if ($sitio->perfil->foto_portada && file_exists(public_path($sitio->perfil->foto_portada))) {
            @unlink(public_path($sitio->perfil->foto_portada));
        }

        $file->move($destinationPath, $fileName);
        $path = 'uploads/portada/' . $fileName;

        $sitio->perfil->update([
            'foto_portada' => $path,
        ]);

        return redirect()->route('perfil.create')->with('success', 'Imagen de portada del sitio guardada correctamente.');
    }
}

