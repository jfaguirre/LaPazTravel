<?php

namespace App\Http\Controllers\sitio\dashboardsitio\portada;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use App\Models\SitioPerfil;
use App\Services\SolicitudService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortadaControlador extends Controller
{    
    public function update(Request $request, SolicitudService $solicitudService)
    {
        $idSitio = session('id_sitio');
        $sitio = Sitio::with('perfil')->find($idSitio);

        if (!$sitio) {
            return redirect()->route('dashboard')
                ->with('error', 'No se encontró el sitio turístico en la sesión.');
        }

        $perfil = $sitio->perfil;

        if (!$perfil) {
            return redirect()->back()
                ->with('error', 'El perfil del sitio aún no ha sido configurado.');
        }

        // Verificar si ya tiene una solicitud de actualización pendiente para la portada
        if ($solicitudService->tieneSolicitudPendiente($sitio->id, get_class($perfil), $perfil->id, null, ['foto_portada'])) {
            return redirect()->back()
                ->with('error', 'Ya tienes una solicitud de actualización de portada pendiente de aprobación.');
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

        // Guardar la imagen cargada en public/uploads/portada
        $file = $request->file('foto_portada');
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . '_' . uniqid() . '.' . $extension;
        $destinationPath = public_path('uploads/portada');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $file->move($destinationPath, $fileName);
        $path = 'uploads/portada/' . $fileName;

        // Registrar la solicitud a través de SolicitudService
        $solicitud = $solicitudService->crearSolicitud(
            Auth::id(),
            $sitio->id,
            'Solicitud de cambio de imagen de portada'
        );

        $solicitudService->agregarOperacion(
            $solicitud,
            get_class($perfil),
            $perfil->id,
            'UPDATE',
            [
                'antes'   => ['foto_portada' => $perfil->foto_portada],
                'despues' => ['foto_portada' => $path],
                'campos'  => ['foto_portada'],
            ],
            'Actualización de foto de portada del sitio'
        );

        return redirect()->back()
            ->with('success', 'Tu solicitud de actualización de foto de portada fue enviada para aprobación.');
    }
}

