<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class OfferController extends Controller
{

    public function all()
    {
        $user = JWTAuth::toUser(JWTAuth::getToken());

        $offers = $user->offers()->select('id', 'issue_date', 'insurance_premium')->get();

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

    public function offerById($id)
    {
        $user = JWTAuth::toUser(JWTAuth::getToken());

        $offer = $user->offers()->findOrFail($id);

        return response()->json($offer);
    }

    public function edit($id, Request $request)
    {
        $user = JWTAuth::toUser(JWTAuth::getToken());

        $offer = $user->offers()->findOrFail($id);

        // TODO(radu): validate fields
        $offer->insurance_premium = $request->insurance_premium ?: $offer->insurance_premium;
        $offer->insured_name = $request->insured_name ?: $offer->insured_name;
        $offer->insured_cnp = $request->insured_cnp ?: $offer->insured_cnp;

        $user->offers()->save($offer);

        return response()->json(["message" => "Offer $offer->id edited."]);
    }

    public function cancel($id)
    {
        $user = JWTAuth::toUser(JWTAuth::getToken());

        $offer = $user->offers()->findOrFail($id);

        if (!$offer->available) {
            return response()->json(["message" => "Offer $offer->id already canceled."]);
        }

        $offer->available = 0;
        $user->offers()->save($offer);

        return response()->json(["message" => "Offer $offer->id canceled."]);
    }

}
