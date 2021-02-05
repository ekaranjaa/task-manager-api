<?php

namespace App\Http\Controllers;

use App\Http\Resources\AvailabilityResource;
use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilitiesController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'from' => 'required',
            'to' => 'required'
        ]);

        $availability = new Availability([
            'user_id' => $request->user()->id,
            'from' => $request->from,
            'to' => $request->to,
            'weekend' => $request->weekend ? 1 : 0
        ]);

        if ($availability->save()) {
            return response()->json(['message' => 'Availability created.']);
        }
    }

    public function update(Request $request, Availability $availability)
    {
        $request->validate([
            'from' => 'required',
            'to' => 'required'
        ]);

        $availability = $availability::findOrFail(
            $request->user()->availability->id
        );

        $availability->update([
            'from' => $request->from,
            'to' => $request->to,
            'weekend' => $request->weekend ? 1 : 0
        ]);

        if ($availability->save()) {
            return response()->json(['message' => 'Availability updated.']);
        }
    }
}
