<?php

namespace App\Http\Controllers\sitio\dashboardsitio\precios;

use App\Http\Controllers\Controller;
use App\Models\Precio;
use App\Models\Sitio;
use App\Services\SolicitudService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrecioControlador extends Controller
{
    public function inicio(SolicitudService $solicitudService)
    {
        $idSitio = session('id_sitio');
        $sitio   = Sitio::find($idSitio);

        if (!$sitio) {
            return redirect()->route('dashboard');
        }

        $perfil  = $sitio->perfil;
        $precios = $perfil ? $perfil->precios : collect();

        $tieneSolicitudPendiente = false;
        if ($perfil) {
            $tieneSolicitudPendiente = $solicitudService->tieneSolicitudPendiente(
                $sitio->id,
                Precio::class
            );
        }

        return view('admin.dashboard.precio.inicio', compact('sitio', 'perfil', 'precios', 'tieneSolicitudPendiente'));
    }

    public function update(Request $request, SolicitudService $solicitudService)
    {
        $idSitio = session('id_sitio');
        $sitio   = Sitio::find($idSitio);

        if (!$sitio || !$sitio->perfil) {
            return redirect()->route('dashboard');
        }

        $perfil = $sitio->perfil;

        if ($solicitudService->tieneSolicitudPendiente($sitio->id, Precio::class)) {
            return redirect()->route('dashboard.sitio.inicio')
                ->with('error', 'Ya tienes una solicitud de actualización de precios pendiente de aprobación.');
        }

        $request->validate([
            'precios'                 => 'nullable|array',
            'precios.*.id'            => 'nullable|integer',
            'precios.*.categoria'     => 'nullable|string|max:50',
            'precios.*.precioEntrada' => 'nullable|numeric|min:0|max:999999.99',
            'precios.*.descripcion'   => 'nullable|string|max:100',
            'precios.*.eliminar'      => 'nullable|in:0,1,true,false',
        ]);

        $inputPrecios = $request->input('precios', []);
        $existingPrecios = $perfil->precios->keyBy('id');

        $cambiosProcesados = 0;

        $solicitud = $solicitudService->crearSolicitud(
            Auth::id(),
            $sitio->id,
            'Actualización de precios y tarifas del sitio'
        );

        $processedIds = [];

        foreach ($inputPrecios as $item) {
            $id = !empty($item['id']) ? (int)$item['id'] : null;
            $categoria = !empty($item['categoria']) ? trim($item['categoria']) : null;
            $precioEntrada = isset($item['precioEntrada']) && $item['precioEntrada'] !== '' ? (float)$item['precioEntrada'] : null;
            $descripcion = !empty($item['descripcion']) ? trim($item['descripcion']) : null;
            $eliminar = !empty($item['eliminar']) && ($item['eliminar'] == '1' || $item['eliminar'] === true);

            if ($id && $existingPrecios->has($id)) {
                $processedIds[] = $id;
                $precioModel = $existingPrecios->get($id);

                if ($eliminar) {
                    $solicitudService->registrarEliminacion($solicitud, $precioModel);
                    $cambiosProcesados++;
                } else if ($categoria !== null && $precioEntrada !== null) {
                    if (
                        $precioModel->categoria !== $categoria ||
                        (float)$precioModel->precioEntrada !== (float)$precioEntrada ||
                        $precioModel->descripcion !== $descripcion
                    ) {
                        $solicitudService->agregarOperacion(
                            $solicitud,
                            Precio::class,
                            $precioModel->id,
                            'UPDATE',
                            [
                                'antes' => [
                                    'categoria'     => $precioModel->categoria,
                                    'precioEntrada' => $precioModel->precioEntrada,
                                    'descripcion'   => $precioModel->descripcion,
                                ],
                                'despues' => [
                                    'categoria'     => $categoria,
                                    'precioEntrada' => $precioEntrada,
                                    'descripcion'   => $descripcion,
                                ],
                                'campos' => ['categoria', 'precioEntrada', 'descripcion'],
                            ],
                            "Actualización de tarifa: {$categoria}"
                        );
                        $cambiosProcesados++;
                    }
                }
            } else if (!$eliminar && $categoria !== null && $precioEntrada !== null) {
                $solicitudService->registrarCreacion(
                    $solicitud,
                    Precio::class,
                    [
                        'categoria'      => $categoria,
                        'precioEntrada'  => $precioEntrada,
                        'descripcion'    => $descripcion,
                        'id_sitioPerfil' => $perfil->id,
                    ]
                );
                $cambiosProcesados++;
            }
        }

        foreach ($existingPrecios as $existingId => $existingModel) {
            if (!in_array($existingId, $processedIds)) {
                $solicitudService->registrarEliminacion($solicitud, $existingModel);
                $cambiosProcesados++;
            }
        }

        if ($cambiosProcesados === 0) {
            $solicitud->delete();
            return redirect()->route('precio.inicio')
                ->with('info', 'No se realizaron modificaciones en la lista de precios.');
        }

        return redirect()->route('dashboard.sitio.inicio')
            ->with('success', 'Tu solicitud de actualización de precios fue enviada para aprobación.');
    }
}
