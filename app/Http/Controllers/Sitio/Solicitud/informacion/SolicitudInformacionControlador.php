<?php

namespace App\Http\Controllers\sitio\solicitud\informacion;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use App\Models\SitioPerfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class SolicitudInformacionControlador extends Controller
{
    public function create()
    {
        // Obtener el sitio desde la sesión        
        $sitio = Sitio::find(session('id_sitio')); 

        return view('admin.solicitud.informacion.create', compact('sitio'));        
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $datos = $request->validate([
            'nombre'            => 'required|string|max:50',
            'slug'              => 'nullable|string|max:50',
            'descripcion_corta' => 'required|string|max:200',
            'telefono'          => 'nullable|string|max:9',
            'correo'            => 'nullable|email|max:100',
            'departamento'      => 'nullable|exists:departamentos,id',
            'municipio'         => 'nullable|exists:municipios,id',
            'distrito'          => 'nullable|exists:distritos,id',
            'direccion'         => 'nullable|string|max:150',
        ]);

        try {
            DB::transaction(function () use ($datos, $user) {
                $idSitio = session('id_sitio');
                $sitio = $idSitio ? Sitio::find($idSitio) : null;

                // Generar / Verificar slug único
                $slugSource = !empty($datos['slug']) ? $datos['slug'] : $datos['nombre'];
                $slugBase = Str::slug($slugSource);
                $slug = $slugBase;
                $contador = 2;

                $sitioId = $sitio?->id;
                while (Sitio::where('slug', $slug)->where('id', '!=', $sitioId)->exists()) {
                    $slug = "{$slugBase}-{$contador}";
                    $contador++;
                }

                // Guardar o actualizar Sitio
                if ($sitio) {
                    $sitio->update([
                        'nombre'            => $datos['nombre'],
                        'slug'              => $slug,
                        'descripcion_corta' => $datos['descripcion_corta'],
                    ]);
                } else {
                    $sitio = Sitio::create([
                        'nombre'            => $datos['nombre'],
                        'slug'              => $slug,
                        'descripcion_corta' => $datos['descripcion_corta'],
                        'id_user'           => $user->id,
                    ]);

                    session(['id_sitio' => $sitio->id]);
                }

                // Guardar o actualizar SitioPerfil
                $perfil = SitioPerfil::firstOrNew(['id_sitio' => $sitio->id]);

                if (!$perfil->exists) {
                    do {
                        $identificador = strtoupper(Str::random(10));
                    } while (SitioPerfil::where('identificador', $identificador)->exists());
                    $perfil->identificador = $identificador;
                }

                $perfil->telefono             = $datos['telefono'] ?? null;
                $perfil->correo_institucional = $datos['correo'] ?? null;
                $perfil->direccion            = $datos['direccion'] ?? null;

                if (!empty($datos['departamento'])) {
                    $perfil->id_departamento = $datos['departamento'];
                }
                if (!empty($datos['municipio'])) {
                    $perfil->id_municipio = $datos['municipio'];
                }
                if (!empty($datos['distrito'])) {
                    $perfil->id_distrito = $datos['distrito'];
                }

                $perfil->save();
            });

            return redirect()
                ->route('dashboard')
                ->with('success', 'Información del sitio guardada correctamente.');

        } catch (Throwable $e) {
            Log::error('Error al guardar la información del sitio', [
                'usuario_id' => Auth::id(),
                'error'      => $e->getMessage(),
                'archivo'    => $e->getFile(),
                'linea'      => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar la información. Inténtalo nuevamente.');
        }
    }
}

