<?php

namespace App\Http\Controllers\Api\V1\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use Illuminate\Support\Facades\Validator;

class BusinessSettingsController extends Controller
{

    public function update_restaurant_setup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'contact_number' => 'required',
            'opening_time' => 'required',
            'closeing_time' => 'required',
            'delivery' => 'required|boolean',
            'take_away' => 'required|boolean',
            'schedule_order' => 'required|boolean',
            'minimum_order' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        if(!$request->take_away && !$request->delivery)
        {
            return response()->json([
                'error'=>[
                    ['code'=>'delivery_or_take_way', 'message'=>trans('messages.can_not_disable_both_take_away_and_delivery')]
                ]
            ],403);
        }
        $restaurant = $request['vendor']->restaurants[0];
        $restaurant->delivery = $request->delivery;
        $restaurant->take_away = $request->take_away;
        $restaurant->schedule_order = $request->schedule_order;
        $restaurant->minimum_order = $request->minimum_order;
        $restaurant->opening_time = $request->opening_time;
        $restaurant->closeing_time = $request->closeing_time;

        $restaurant->name = $request->name;
        $restaurant->address = $request->address;
        $restaurant->phone = $request->contact_number;
    
        $restaurant->logo = $request->has('logo') ? Helpers::update('restaurant/', $restaurant->logo, 'png', $request->file('logo')) : $restaurant->logo;
        
        $restaurant->cover_photo = $request->has('cover_photo') ? Helpers::update('restaurant/cover/', $restaurant->cover_photo, 'png', $request->file('cover_photo')) : $restaurant->cover_photo;

        $restaurant->save();

        return response()->json(['message'=>trans('messages.restaurant_settings_updated')], 200);
    }
}
