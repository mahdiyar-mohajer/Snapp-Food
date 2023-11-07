<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Resturant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function profile()
    {
        return view('seller.resturant-profile');
    }

    public function updateProfile(Request $request)
    {


        $user = auth()->user();
        $restaurant = $user->resturant;

        if (!$restaurant) {
            $restaurant = new Resturant();
            $restaurant->user_id = $user->id;
        }

        $restaurant->name = $request->input('name');
        $restaurant->phone_number = $request->input('phone_number');
        $restaurant->start_time = $request->input('start_time');
        $restaurant->end_time = $request->input('end_time');
        $restaurant->ship_price = $request->input('ship_price');
        $restaurant->status = $request->input('status');
        $restaurant->profile_complete = true;

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $restaurantEmail = $restaurant->user->email;

            $folderPath = 'restaurant_images/' . $restaurantEmail;

            $path = $image->store($folderPath, 'public');

            if ($restaurant->images->count() > 0) {

                $existingImage = $restaurant->images->first();
                Storage::disk('public')->delete($existingImage->url);
                $existingImage->url = $path;
                $existingImage->save();
            } else {
                $imageModel = new Image(['url' => $path]);
                $restaurant->images()->save($imageModel);
            }
        }

        $restaurant->save();

        return redirect()->route('seller.dashboard');
    }
}






