<?php

namespace App\Services;
use App\Models\Solicitud;
use App\Models\SolicitudOperacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Contracts\HasSitio;

class SolicitudService
{
    /* Verifica si existe una solicitud PENDIENTE para un sitio.
      Opcionalmente se puede filtrar por modelo, id de registro o nombre de relación. */
      
    public function tieneSolicitudPendiente(
        int $idSitio,
        ?string $modelo = null,
        ?int $registroId = null,
        ?string $relacion = null
    ): bool {
        $query = Solicitud::where('id_sitio', $idSitio)
            ->where('estado', 'PENDIENTE');

        if ($modelo !== null) {
            $query->whereHas('operaciones', function ($q) use ($modelo, $registroId, $relacion) {
                $q->where('modelo', $modelo);
                if ($registroId !== null) {
                    $q->where('id_registro', $registroId);
                }
                if ($relacion !== null) {
                    $q->whereJsonContains('cambios->relacion', $relacion);
                }
            });
        }

        return $query->exists();
    }

    /* Crea una nueva solicitud PENDIENTE para el usuario y sitio. */
    public function crearSolicitud(int $idUsuario, int $idSitio, ?string $comentarioUsuario = null): Solicitud
    {
        return Solicitud::create([
            'id_sitio' => $idSitio,
            'id_user'  => $idUsuario,
            'estado'   => 'PENDIENTE',
            'comentario_usuario' => $comentarioUsuario,
        ]);
    }

    public function agregarOperacion(
        Solicitud $solicitud,
        string $modelo,
        ?int $registroId,
        string $operacion,
        array $cambios,
        ?string $descripcion = null
    ): SolicitudOperacion {

        $operacionExistente = SolicitudOperacion::where('id_solicitud', $solicitud->id)
            ->where('modelo', $modelo)
            ->where('id_registro', $registroId)
            ->first();

        if ($operacionExistente) {
            $operacionExistente->update([
                'operacion'   => strtoupper($operacion),
                'descripcion' => $descripcion,
                'cambios'     => $cambios,
            ]);

            return $operacionExistente;
        }

        return SolicitudOperacion::create([
            'id_solicitud' => $solicitud->id,
            'modelo'       => $modelo,
            'id_registro'  => $registroId,
            'operacion'    => strtoupper($operacion),
            'descripcion'  => $descripcion,
            'cambios'      => $cambios,
        ]);
    }

    public function registrarCambio(
        Model $modelo,
        array $datosNuevos,
        ?string $descripcion = null
    ): SolicitudOperacion {

        if (! $modelo instanceof HasSitio) {
            throw new \InvalidArgumentException(
                'El modelo debe implementar HasSitio.'
            );
        }

        $sitio = $modelo->obtenerSitio();

        $solicitud = $this->crearSolicitud(
            Auth::id(),
            $sitio->id,
            $descripcion
        );

        return $this->agregarOperacion(
            $solicitud,
            get_class($modelo),
            $modelo->getKey(),
            'UPDATE',
            [
                'antes' => $modelo->toArray(),
                'despues' => array_merge(
                    $modelo->toArray(),
                    $datosNuevos
                ),
            ],
            $descripcion
        );
    }

    public function registrarRelacion(
        Model $modelo,
        string $relacion,
        array $idsNuevos,
        ?string $descripcion = null
    ): SolicitudOperacion {

        if (!method_exists($modelo, $relacion)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "La relación '%s' no existe en el modelo %s.",
                    $relacion,
                    get_class($modelo)
                )
            );
        }

        $idsActuales = $modelo->{$relacion}()
            ->pluck('id')
            ->toArray();

        $sitio = $modelo->obtenerSitio();

        $solicitud = $this->crearSolicitud(
            Auth::id(),
            $sitio->id,
            $descripcion
        );

        return $this->agregarOperacion(
            $solicitud,
            get_class($modelo),
            $modelo->getKey(),
            'UPDATE',
            [
                'relacion' => $relacion,
                'antes'    => $idsActuales,
                'despues'  => $idsNuevos,
            ],
            $descripcion
        );
    }

    public function registrarCreacion(
            Solicitud $solicitud,
            string $modelo,
            array $datos
        ): SolicitudOperacion {

            return $this->agregarOperacion(
                $solicitud,
                $modelo,
                null,
                'CREATE',
                [
                    'despues' => $datos,
                ]
            );
        }


    public function registrarEliminacion(
        Solicitud $solicitud,
        Model $modelo
        ): SolicitudOperacion {

        return $this->agregarOperacion(
            $solicitud,
            get_class($modelo),
            $modelo->getKey(),
            'DELETE',
            $modelo->toArray(),
            null
        );
    }

    // Aprobar solicitud y aplicar todas sus operaciones
    public function aprobarSolicitud(Solicitud $solicitud): void
    {
        DB::transaction(function () use ($solicitud) {
            $operaciones = $solicitud->operaciones;

            foreach ($operaciones as $operacion) {
                $this->aprobarOperacion($operacion);
            }

            $solicitud->update([
                'estado'         => 'APROBADA',
                'revisado_por'   => Auth::id(),
                'fecha_revision' => now(),
            ]);
        });
    }

    // Alias para compatibilidad con código previo
    public function aprobar(Solicitud $solicitud): void
    {
        $this->aprobarSolicitud($solicitud);
    }

    // Rechazar solicitud con comentario opcional
    public function rechazarSolicitud(Solicitud $solicitud, ?string $comentarioAdmin = null): void
    {
        DB::transaction(function () use ($solicitud, $comentarioAdmin) {
            // Eliminar archivos creados en solicitudes rechazadas
            foreach ($solicitud->operaciones as $operacion) {
                $cambios = $operacion->cambios;
                if (isset($cambios['despues']['foto_portada'])) {
                    $this->eliminarArchivo($cambios['despues']['foto_portada']);
                }
            }

            $solicitud->update([
                'estado'           => 'RECHAZADA',
                'comentario_admin' => $comentarioAdmin,
                'revisado_por'     => Auth::id(),
                'fecha_revision'   => now(),
            ]);
        });
    }

    private function aprobarOperacion(SolicitudOperacion $operacion): void
    {
        $cambios = $operacion->cambios;
        $modeloClass = $operacion->modelo;

        if ($operacion->operacion === 'CREATE') {
            if (isset($cambios['despues'])) {
                $modeloClass::create($cambios['despues']);
            }
            return;
        }

        $registro = $operacion->id_registro ? $modeloClass::find($operacion->id_registro) : null;

        if (!$registro) {
            return;
        }

        if ($operacion->operacion === 'DELETE') {
            $registro->delete();
            return;
        }

        // Operación UPDATE
        if (isset($cambios['relacion'])) {
            $registro->{$cambios['relacion']}()->sync($cambios['despues']);
        } elseif (isset($cambios['despues'])) {
            // Si se actualiza foto_portada, eliminar la imagen anterior de disco
            if (isset($cambios['despues']['foto_portada'])) {
                $fotoAnterior = $registro->foto_portada;
                $fotoNueva = $cambios['despues']['foto_portada'];

                if ($fotoAnterior && $fotoAnterior !== $fotoNueva) {
                    $this->eliminarArchivo($fotoAnterior);
                }
            }

            $registro->update($cambios['despues']);
        }
    }

    private function eliminarArchivo(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        // Verificar en la carpeta public (ej. uploads/portada/file.jpg)
        $publicPath = public_path($path);
        if (file_exists($publicPath) && is_file($publicPath)) {
            @unlink($publicPath);
            return;
        }

        // Verificar en la carpeta storage/app/public/
        $storagePath = storage_path('app/public/' . ltrim($path, '/'));
        if (file_exists($storagePath) && is_file($storagePath)) {
            @unlink($storagePath);
        }
    }
}

