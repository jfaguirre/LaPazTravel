<?php

namespace App\Http\Controllers\Sitio\Sitio;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use App\Models\SitioPerfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class SitioControlador extends Controller
{
    public function create()
    {              
        return view('usuarios.sitio.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion_corta' => 'required|string|max:200',
        ]);

        try {

            $user = Auth::user();

            $sitio = DB::transaction(function () use ($datos, $user) {

                /* Generar slug único */

                $slugBase = Str::slug($datos['nombre']);

                $slug = $slugBase;
                $contador = 2;

                while (Sitio::where('slug', $slug)->exists()) {

                    $slug = "{$slugBase}-{$contador}";

                    $contador++;
                }

                /* Crear sitio */

                $sitio = Sitio::create([
                    'nombre' => $datos['nombre'],
                    'slug' => $slug,
                    'descripcion_corta' => $datos['descripcion_corta'],
                    'id_user' => $user->id,
                ]);

                // Agregamos el id del sitio a la session
                session([
                    'id_sitio' => $sitio->id,
                ]);

                /* Generar identificador único */

                do {

                    $identificador = strtoupper(
                        Str::random(10)
                    );

                } while (SitioPerfil::where('identificador', $identificador)->exists());

                /* Crear perfil del sitio */                
                SitioPerfil::create([
                    'id_sitio' => $sitio->id,
                    'identificador' => $identificador,
                ]);                

                return $sitio;
            });

            return redirect()
                ->route('dashboard')
                ->with(
                    'success',
                    'Ficha del sitio iniciada correctamente.'
                );

        } catch (Throwable $e) {

            Log::error(
                'Error al crear la ficha del sitio',
                [
                    'usuario_id' => Auth::id(),
                    'error' => $e->getMessage(),
                    'archivo' => $e->getFile(),
                    'linea' => $e->getLine(),
                ]
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Ocurrió un error al crear la ficha del sitio. Inténtalo nuevamente.'
                );
        }
    }

    public function edit()
    {
        $user = Auth::user();
        $sitio = Sitio::where('id_user', $user->id)->first();

        if (!$sitio) {
            return redirect()
                ->route('sitio.create')
                ->with('error', 'Aún no has creado un Sitio Turístico.');
        }

        return view('usuarios.sitio.edit', compact('sitio'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $sitio = Sitio::where('id_user', $user->id)->first();

        if (!$sitio) {
            return redirect()
                ->route('sitio.create')
                ->with('error', 'Aún no has creado un Sitio Turístico.');
        }

        $datos = $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion_corta' => 'required|string|max:200',
        ]);

        try {
            $slug = $sitio->slug;
            if ($sitio->nombre !== $datos['nombre']) {
                $slugBase = Str::slug($datos['nombre']);
                $slug = $slugBase;
                $contador = 2;
                while (Sitio::where('slug', $slug)->where('id', '!=', $sitio->id)->exists()) {
                    $slug = "{$slugBase}-{$contador}";
                    $contador++;
                }
            }

            $sitio->update([
                'nombre' => $datos['nombre'],
                'slug' => $slug,
                'descripcion_corta' => $datos['descripcion_corta'],
            ]);

            return redirect()
                ->route('perfil.create')
                ->with('success', 'Ficha del sitio actualizada correctamente.');

        } catch (Throwable $e) {
            Log::error(
                'Error al actualizar la ficha del sitio',
                [
                    'usuario_id' => Auth::id(),
                    'error' => $e->getMessage(),
                    'archivo' => $e->getFile(),
                    'linea' => $e->getLine(),
                ]
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Ocurrió un error al actualizar la ficha del sitio. Inténtalo nuevamente.'
                );
        }
    }
}