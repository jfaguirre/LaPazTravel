<?php

namespace App\Http\Controllers\Categoria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Sitio;

class CategoriaControlador extends Controller
{
    public function create()
    {
        $categorias = Categoria::all();

        return view('usuarios.categoria.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'icono' => 'required_without:icono_file|nullable|string|max:100',
            'icono_file' => 'nullable|file|mimetypes:image/svg+xml,image/svg,text/xml|max:100',
            'color' => 'nullable|string|max:20',
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ]);

        $iconoPath = $request->icono;

        // Si se subió un archivo SVG
        if ($request->hasFile('icono_file')) {
            $file = $request->file('icono_file');
            if (strtolower($file->getClientOriginalExtension()) === 'svg') {
                $fileName = time() . '_' . uniqid() . '.svg';
                $file->move(public_path('uploads/icons/categorias'), $fileName);
                $iconoPath = 'uploads/icons/categorias/' . $fileName;
            } else {
                return back()->withErrors(['icono_file' => 'El archivo debe ser una imagen SVG válida.'])->withInput();
            }
        }

        // Crear la Categoría
        $categoria = Categoria::create([
            'nombre' => $request->nombre,
            'icono' => $iconoPath,
            'color' => $request->color,
            'estado' => $request->estado,
        ]);

        // Asociar la categoría con el perfil del sitio si existe
        $user = auth()->user();
        $sitio = Sitio::where('id_user', $user->id)->first();
        if ($sitio && $sitio->perfil) {
            $sitio->perfil->categorias()->attach($categoria->id);
        }

        return redirect()->route('dashboard')->with('success', 'Categoría registrada correctamente.');
    }
}
