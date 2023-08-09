<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class OfferController extends Controller
{

    public function offers()
    {
        $user = JWTAuth::toUser(JWTAuth::getToken());

        $offers = $user->offers()->get();

        return response()->json($offers);
    }

    public function create(Request $request)
    {
        $user = auth()->user();

        // TODO(radu): add input validation

        $offer = new Offer();
        $offer->issue_date = new \DateTime();
        $offer->insurance_premium = $request->insurance_premium;
        $offer->insured_name = $request->insured_name;
        $offer->insured_cnp = $request->insured_cnp;

        $user->offers()->save($offer);

        return response()->json(["message" => "Offer added."]);
    }
}
