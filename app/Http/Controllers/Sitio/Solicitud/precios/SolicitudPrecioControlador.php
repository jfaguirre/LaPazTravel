<?php

namespace App\Http\Controllers\sitio\solicitud\precios;

use App\Http\Controllers\Controller;
use App\Models\Precio;
use App\Models\Sitio;
use Illuminate\Http\Request;

class SolicitudPrecioControlador extends Controller
{
    public function create()
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $perfil  = $sitio->perfil;
        $precios = $perfil ? $perfil->precios : collect();

        return view('admin.solicitud.precios.create', compact('sitio', 'perfil', 'precios'));
    }

    public function store(Request $request)
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio || !$sitio->perfil) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $perfil = $sitio->perfil;

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
        $processedIds = [];

        foreach ($inputPrecios as $item) {
            $id = !empty($item['id']) ? (int)$item['id'] : null;
            $categoria = !empty($item['categoria']) ? trim($item['categoria']) : null;
            $precioEntrada = isset($item['precioEntrada']) && $item['precioEntrada'] !== '' ? (float)$item['precioEntrada'] : null;
            $descripcion = !empty($item['descripcion']) ? trim($item['descripcion']) : null;
            $eliminar = !empty($item['eliminar']) && ($item['eliminar'] == '1' || $item['eliminar'] === true);

            if ($id && $existingPrecios->has($id)) {
                $precioModel = $existingPrecios->get($id);

                if ($eliminar) {
                    $precioModel->delete();
                } else if ($categoria !== null && $precioEntrada !== null) {
                    $processedIds[] = $id;
                    $precioModel->update([
                        'categoria'     => $categoria,
                        'precioEntrada' => $precioEntrada,
                        'descripcion'   => $descripcion,
                    ]);
                }
            } else if (!$eliminar && $categoria !== null && $precioEntrada !== null) {
                $newPrecio = Precio::create([
                    'categoria'      => $categoria,
                    'precioEntrada'  => $precioEntrada,
                    'descripcion'    => $descripcion,
                    'id_sitioPerfil' => $perfil->id,
                ]);
                $processedIds[] = $newPrecio->id;
            }
        }

        foreach ($existingPrecios as $existingId => $existingModel) {
            if (!in_array($existingId, $processedIds)) {
                $existingModel->delete();
            }
        }

        return redirect()->route('perfil.create')->with('success', 'Precios y tarifas guardados correctamente.');
    }
}

