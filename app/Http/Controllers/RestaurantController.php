<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\ResturantCategory;
use Illuminate\Http\Request;
use App\Models\Resturant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function profile()
    {
        $resturantCategories = ResturantCategory::all();
        $user = auth()->user();
        $restaurants = $user->resturant;
        return view('seller.resturant-profile', compact('restaurants','resturantCategories'));
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
        $restaurant->save();
        if (!$restaurant->categoriesSet) {

            $request->validate([
                'resturantCategories' => 'required|array',
            ]);
            $restaurant->resturantCategories()->sync($request->input('resturantCategories'));

            $restaurant->categoriesSet = true;
        }
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $restaurantEmail = $restaurant->user->email;
            $randomNumber = rand(10000, 99999);

            $folderPath = 'restaurant_images/' . $restaurantEmail;

            $extension = $image->getClientOriginalExtension();
            $filename = $restaurantEmail . '_' . $randomNumber . '.' . $extension;
            $path = $image->storeAs($folderPath, $filename, 'public');


            if ($restaurant->image) {

                $existingImage = $restaurant->image;
                Storage::disk('public')->delete($existingImage->url);
                $existingImage->url = $path;
                $existingImage->save();
            } else {
                $imageModel = new Image(['url' => $path]);
                $restaurant->image()->save($imageModel);
            }

            return redirect()->route('seller.dashboard');
        }
    }


    public function toggleActivation(Request $request)
    {
        $restaurant = Resturant::find($request->input('restaurant_id'));

        if (!$restaurant) {
            return abort(404);
        }

        // Toggle the restaurant's status
        $restaurant->status = $restaurant->status == 1 ? 0 : 1;
        $restaurant->save();

        return redirect()->back();
    }



    public function index()
    {
        $restaurants = Resturant::all();
        $users = User::all();
        return view('admin.restaurants.index', compact('restaurants', 'users'));
    }

    public function edit(Resturant $restaurant)
    {
        return view('admin.restaurants.edit', compact('restaurant'));
    }

    public function update(Resturant $restaurant)
    {
        $validated = request()->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'ship_price' => 'required',// Adjust the image validation rules as needed
        ]);

        $restaurant->update($validated);

        return redirect()->route('restaurants.index');
    }

    public function destroy(Resturant $restaurant)
    {
        $restaurant->delete();

        return redirect()->route('restaurants.index');
    }
}






