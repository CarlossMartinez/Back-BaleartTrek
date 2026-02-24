<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Comment;
use Illuminate\Http\Request;
use Exception;

class MeetingController extends Controller
{
    // Busca el meeting concreto y lo devuelve con el paginado.
    public function FporTrek(Request $request, $id)
    {
        try {
            $meetings = Meeting::where('trek_id', $id)
                ->with(['users']) // para contar inscritos
                ->withCount('users as inscritos_count') // añade inscritos_count a cada meeting
                ->orderBy('day', 'asc')
                ->paginate(10);

            return response()->json($meetings);
        } catch (Exception $e) {
            return response()->json([
                'msg' => 'Error al obtener los meetings del trek',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Devuelve el detalle de un meeting concreto
     * Incluye: trek con sus interesting_places, comentarios aprobados con imágenes
     * y si el usuario logueado está inscrito (esta_inscrito)
     * GET /api/meetings/{id}
     */
    public function show(Request $request, $id)
    {
        try {
            $meeting = Meeting::with([
                'trek.interestingPlaces.placeType', // puntos de interés ordenados por 'order'
                'trek.municipality.island',
                'comments' => fn($q) => $q->where('status', 'y')->with(['user', 'images']), // solo comentarios aprobados
                'users', // para contar inscritos
            ])
            ->withCount('users as inscritos_count')
            ->findOrFail($id);

            // Añadimos si el usuario logueado está inscrito
            // Si no hay usuario logueado, esta_inscrito = false
            $meeting->esta_inscrito = false;
            if ($request->user()) {
                $meeting->esta_inscrito = $meeting->users()
                    ->where('user_id', $request->user()->id)
                    ->exists();
            }

            return response()->json($meeting);
        } catch (Exception $e) {
            return response()->json([
                'msg' => 'Error al obtener el meeting',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Devuelve los meetings en los que está inscrito el usuario logueado
     * GET /api/user/meetings
     */
    public function misMeetings(Request $request)
    {
        try {
            // Usamos la relación meetings() de User (belongsToMany por meeting_user)
            $meetings = $request->user()
                ->meetings()
                ->with(['trek.municipality.island'])
                ->orderBy('day', 'asc')
                ->get();

            return response()->json($meetings);
        } catch (Exception $e) {
            return response()->json([
                'msg' => 'Error al obtener tus meetings',
                'error' => $e->getMessage()
            ]);
        }
    }

    //Inscribe al usuario logueado en un meeting
     
    public function inscribirse(Request $request, $id)
    {
        try {
            $meeting = Meeting::findOrFail($id);
            $userId = $request->user()->id;

            // Comprobamos que las inscripciones estén abiertas
            // Comparamos con los campos appDateIni y appDateEnd de la tabla meetings
            $hoy = now()->toDateString();
            if ($hoy < $meeting->appDateIni || $hoy > $meeting->appDateEnd) {
                return response()->json([
                    'message' => 'Las inscripciones están cerradas.'
                ], 422);
            }

            // Comprobamos que no esté ya inscrito (tabla pivot meeting_user)
            $yaInscrito = $meeting->users()->where('user_id', $userId)->exists();
            if ($yaInscrito) {
                return response()->json([
                    'message' => 'Ya estás inscrito a este meeting.'
                ], 422);
            }

            // Insertamos en la tabla pivot meeting_user
            $meeting->users()->attach($userId);

            return response()->json([
                'message' => '¡Inscripción completada correctamente!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msg' => 'Error al inscribirse',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Cancela la inscripción del usuario logueado en un meeting
     * DELETE /api/meetings/{id}/desinscribirse
     */
    public function desinscribirse(Request $request, $id)
    {
        try {
            $meeting = Meeting::findOrFail($id);
            $userId = $request->user()->id;

            // Comprobamos que el periodo de inscripción siga abierto para poder cancelar
            $hoy = now()->toDateString();
            if ($hoy < $meeting->appDateIni || $hoy > $meeting->appDateEnd) {
                return response()->json([
                    'message' => 'No puedes cancelar fuera del periodo de inscripciones.'
                ], 422);
            }

            // Comprobamos que esté inscrito antes de intentar borrar
            $estaInscrito = $meeting->users()->where('user_id', $userId)->exists();
            if (!$estaInscrito) {
                return response()->json([
                    'message' => 'No estás inscrito a este meeting.'
                ], 422);
            }

            // Borramos de la tabla pivot meeting_user
            $meeting->users()->detach($userId);

            return response()->json([
                'message' => 'Inscripción cancelada correctamente.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msg' => 'Error al cancelar la inscripción',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Añade un comentario y puntuación a un meeting
     * Solo puede comentar si el usuario estuvo inscrito en el meeting
     * POST /api/meetings/{id}/comentarios
     */
    public function addComment(Request $request, $id)
    {
        try {
            $meeting = Meeting::findOrFail($id);
            $userId = $request->user()->id;

            // Validamos los datos del comentario
            // score va de 1 a 5 (las estrellas del frontend)
            $request->validate([
                'comment' => 'required|string|max:1000',
                'score'   => 'required|integer|min:1|max:5',
            ]);

            // Comprobamos que el usuario estuvo inscrito en este meeting
            $estabaInscrito = $meeting->users()->where('user_id', $userId)->exists();
            if (!$estabaInscrito) {
                return response()->json([
                    'message' => 'Solo pueden comentar los usuarios inscritos en este meeting.'
                ], 403);
            }

            // Comprobamos que no haya comentado ya
            $yaComento = Comment::where('meeting_id', $id)
                ->where('user_id', $userId)
                ->exists();
            if ($yaComento) {
                return response()->json([
                    'message' => 'Ya has dejado un comentario en este meeting.'
                ], 422);
            }

            // Creamos el comentario (status = 'n' por defecto, el admin lo aprueba)
            // El trigger de la BD actualizará totalScore y countScore en meetings
            // cuando el admin cambie el status a 'y'
            $comment = Comment::create([
                'comment'    => $request->comment,
                'score'      => $request->score,
                'user_id'    => $userId,
                'meeting_id' => $id,
                'status'     => 'n', // pendiente de aprobación
            ]);

            return response()->json([
                'message' => 'Comentario enviado. Será visible tras su aprobación.',
                'comment' => $comment
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'msg' => 'Error al guardar el comentario',
                'error' => $e->getMessage()
            ]);
        }
    }
}
