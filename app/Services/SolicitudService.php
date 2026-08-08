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

    public function tieneSolicitudPendiente(int $idSitio): bool
    {
        return Solicitud::where('id_sitio', $idSitio)
            ->where('estado', 'PENDIENTE')
            ->exists();
    }

    public function crearSolicitud(int $idUsuario, int $idSitio): Solicitud
    {        
    
        $solicitud = Solicitud::where('id_sitio', $idSitio)
            ->where('id_user', $idUsuario)
            ->where('estado', 'PENDIENTE')
            ->first();
            
        if ($solicitud) {                     
            return $solicitud;
        }

        return Solicitud::create([
            'id_sitio' => $idSitio,
            'id_user' => $idUsuario,
            'estado' => 'PENDIENTE',
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
                'cambios' => $cambios,
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
        ): SolicitudOperacion
    {

        if (! $modelo instanceof HasSitio) {
            throw new \InvalidArgumentException(
                'El modelo debe implementar HasSitio.'
            );
        }

        $sitio = $modelo->obtenerSitio();

        $solicitud = $this->crearSolicitud(            
            Auth::id(),
            $sitio->id
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
        ): SolicitudOperacion        
    {

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
            $sitio->id,
            Auth::id()
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

    public function aprobar(Solicitud $solicitud): void
    {
        DB::transaction(function () use ($solicitud) {

            foreach ($solicitud->operaciones as $operacion) {

                switch ($operacion->accion) {

                    case 'CREATE':
                        $this->aprobarCreate($operacion);
                        break;

                    case 'UPDATE':
                        $this->aprobarUpdate($operacion);
                        break;

                    case 'DELETE':
                        $this->aprobarDelete($operacion);
                        break;
                }
            }

            $solicitud->update([
                'estado' => 'APROBADA',
                'fecha_revision' => now(),
                'revisado_por' => Auth::user()->id(),
            ]);

        });
    }


    // Metodos
    private function aprobarCreate(SolicitudOperacion $operacion): void
    {
        $modelo = $operacion->modelo;
        $modelo::create($operacion->datos_nuevos);
    }

    private function aprobarUpdate(SolicitudOperacion $operacion): void
    {
        $modelo = $operacion->modelo;
        $registro = $modelo::find($operacion->registro_id);

        if (!$registro) {
            throw new \Exception(
                "No existe el registro {$operacion->registro_id} del modelo {$modelo}"
            );
        }

        $registro->update(
            $operacion->datos_nuevos
        );
    }

    private function aprobarDelete(SolicitudOperacion $operacion): void
    {
        $modelo = $operacion->modelo;
        $registro = $modelo::find($operacion->registro_id);

        if (!$registro) {
            return;
        }

        $registro->delete();
    }
}