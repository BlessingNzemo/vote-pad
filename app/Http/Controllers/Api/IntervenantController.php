<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IntervenantPhaseResource;
use App\Models\Evenement;
use App\Models\Intervenant;
use App\Models\IntervenantPhase;
use App\Models\Phase;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IntervenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *      path="/intervenants",
     *      operationId="getIntervenantsList",
     *      tags={"Intervenants"},
     *      summary="Afficher la liste des intervenants",
     *      description="Api qui nous retourne la liste des intervenants",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found"
     *      )
     *     )
     */
    public function index()
    {
        $intervenants = Intervenant::all();
        return response()->json($intervenants);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Intervenant $intervenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Intervenant $intervenant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Intervenant $intervenant)
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/intervenants-authenticate",
     *      operationId="getIntervenantPhase",
     *      tags={"Intervenants"},
     *      summary="Récuperer la phase liée à l'intervenant",
     *      description="Api qui nous retourne la phase liée à l'intervenant",
     *      security={{"bearerAuth":{}}},
     *      * @OA\Parameter(
     *          name="email",
     *          in="query",
     *          description="L'email de l'intervenant",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="coupon",
     *          in="query",
     *          description="Le coupon de l'intervenant",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function authenticate(Request $request)
    {
        $email = $request->email;
        $coupon = $request->coupon;
        $intervenant = Intervenant::where('email', $email)->first();

        Log::info('email ' . $email . '--' . !$intervenant);

        if ($intervenant == null) {
            return response()->json('L\'adresse email inseree est invalide.', 400);
        } else {
            $intervenantId = $intervenant->id;
            $intervenantPhase = IntervenantPhase::where('intervenant_id', $intervenantId)->where('coupon', $coupon)->first();
            if ($intervenantPhase == null) {
                return response()->json('Le coupon inséré est invalide.', 400);
            } else {
                $intervenantToken = $intervenantPhase->token;
                if ($intervenantToken != 0) {

                    $intervenantPhase = IntervenantPhase::where('token', $intervenantToken)->first();
                    $phase = Phase::find($intervenantPhase->phase_id);
                    $evenement = Evenement::find($phase->evenement_id);
                    $intervenant = Intervenant::find($intervenantPhase->intervenant_id);
                    $intervenant->intervenantPhaseId = $intervenantPhase->id;
                    $intervenant->phaseId = $intervenantPhase->phase_id;
                    $intervenant->phase_nom = $phase->nom;
                    $intervenant->evenement_nom = $evenement->nom;
                    $intervenant->intervenantToken = $intervenantPhase->token;
                    $intervenant->finEvaluation = $intervenantPhase->fin_evaluation;

                    $now = Carbon::now();
                    $finEvaluation = Carbon::create($intervenantPhase->fin_evaluation); 
                    $dateActuelle = Carbon::create($now->format('Y-m-d H:i:s')); 

                    if ($dateActuelle >= $finEvaluation) {
                        $dureeRestante = 0;
                    } else {
                        $reste = $dateActuelle->diff($finEvaluation);
                        $dureeRestante = ($reste->days * 24 * 60 * 60) + ($reste->h * 60 * 60) + ($reste->i * 60) + $reste->s;
                    }

                    $intervenant->dureeRestante = $dureeRestante;

                    return new IntervenantPhaseResource($intervenant);
                } else {
                    $intervenantPhaseCoupon = $intervenantPhase->coupon;
                    $token = $intervenantPhase->createToken($intervenantPhaseCoupon)->plainTextToken;
                    $intervenantPhase->token = $token;
                    $intervenantPhase->save();
                    $intervenantToken = $intervenantPhase->token;
                    $phaseSlug = substr($intervenantPhaseCoupon, 0, 3);
                    $phase = Phase::where('slug', $phaseSlug)->first();
                    $evenement = Evenement::find($phase->evenement_id);
                    $phase->token = $intervenantToken;
                    $intervenantPhase = IntervenantPhase::where('token', $intervenantToken)->first();
                    $phase = Phase::find($intervenantPhase->phase_id);
                    $intervenant = Intervenant::find($intervenantPhase->intervenant_id);
                    $intervenant->intervenantPhaseId = $intervenantPhase->id;
                    $intervenant->phaseId = $intervenantPhase->phase_id;
                    $intervenant->phase_nom = $phase->nom;
                    $intervenant->evenement_nom = $evenement->nom;
                    $intervenant->intervenantToken = $intervenantPhase->token;
                    $intervenant->finEvaluation = $intervenantPhase->fin_evaluation;

                    $now = Carbon::now();
                    $finEvaluation = Carbon::create($intervenantPhase->fin_evaluation); 
                    $dateActuelle = Carbon::create($now->format('Y-m-d H:i:s')); 

                    if ($dateActuelle >= $finEvaluation) {
                        $dureeRestante = 0;
                    } else {
                        $reste = $dateActuelle->diff($finEvaluation);
                        $dureeRestante = ($reste->days * 24 * 60 * 60) + ($reste->h * 60 * 60) + ($reste->i * 60) + $reste->s;
                    }

                    $intervenant->dureeRestante = $dureeRestante;


                    return new IntervenantPhaseResource($intervenant);
                }
            }
        }
    }
}
