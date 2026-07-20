<?php

namespace App\Http\Controllers\Servicio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Sitio;

class ServicioControlador extends Controller
{
    public function create()
    {
        $servicios = Servicio::all();

        return view('usuarios.servicio.create', compact('servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'servicio' => 'required|string|max:50|unique:servicios,servicio',
            'icono' => 'required_without:icono_file|nullable|string|max:100',
            'icono_file' => 'nullable|file|mimetypes:image/svg+xml,image/svg,text/xml|max:100',
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ]);

        $iconoPath = $request->icono;

        // Si se subió un archivo SVG
        if ($request->hasFile('icono_file')) {
            $file = $request->file('icono_file');
            if (strtolower($file->getClientOriginalExtension()) === 'svg') {
                $fileName = time() . '_' . uniqid() . '.svg';
                $file->move(public_path('uploads/icons/servicios'), $fileName);
                $iconoPath = 'uploads/icons/servicios/' . $fileName;
            } else {
                return back()->withErrors(['icono_file' => 'El archivo debe ser una imagen SVG válida.'])->withInput();
            }
        }

        // Crear el Servicio
        $servicio = Servicio::create([
            'servicio' => $request->servicio,
            'icono' => $iconoPath,
            'estado' => $request->estado,
        ]);

        // Asociar el servicio con el perfil del sitio si existe
        $user = auth()->user();
        $sitio = Sitio::where('id_user', $user->id)->first();
        if ($sitio && $sitio->perfil) {
            $sitio->perfil->servicios()->attach($servicio->id);
        }

        return redirect()->route('dashboard')->with('success', 'Servicio registrado correctamente.');
    }
}
