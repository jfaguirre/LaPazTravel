<?php

namespace App\Http\Controllers\Regla;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Regla;
use App\Models\Sitio;

class ReglaControlador extends Controller
{
    public function create()
    {
        $reglas = Regla::all();

        return view('usuarios.regla.create', compact('reglas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'regla' => 'required|string|max:20|unique:reglas,regla',
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
                $file->move(public_path('uploads/icons/reglas'), $fileName);
                $iconoPath = 'uploads/icons/reglas/' . $fileName;
            } else {
                return back()->withErrors(['icono_file' => 'El archivo debe ser una imagen SVG válida.'])->withInput();
            }
        }

        // Crear la Regla
        $regla = Regla::create([
            'regla' => $request->regla,
            'icono' => $iconoPath,
            'estado' => $request->estado,
        ]);

        // Asociar la regla con el perfil del sitio si existe
        $user = auth()->user();
        $sitio = Sitio::where('id_user', $user->id)->first();
        if ($sitio && $sitio->perfil) {
            $sitio->perfil->reglas()->attach($regla->id);
        }

        return redirect()->route('dashboard')->with('success', 'Regla registrada correctamente.');
    }
}
