<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\Image;
use App\Models\Resturant;
use App\Models\ResturantCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if (!$user->resturant) {
            return redirect()->route('resturant.profile')->with('failed', 'اطلاعات رستوران رو تکمیل کن.');
        }
        $foods = Food::where('resturant_id', Auth::user()->resturant->id)->paginate(5);
        return view('foods.index', compact('foods'));
    }


    public function show(Food $food)
    {
        Auth::user();
        return view('foods.show', compact('food'));
    }

    public function create()
    {
        $foodCategories = FoodCategory::all();
        return view('foods.create', compact('foodCategories'));
    }

// Store a new food item
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'raw_material' => 'required|string',
            'price' => 'required|numeric',
            'foodCategories' => 'required|array',
        ]);

        $user = Auth::user();

        if ($user) {
            $restaurant = $user->resturant; // Assuming a one-to-one relationship between user and restaurant

            if ($restaurant) {
                $food = new Food([
                    'name' => $request->input('name'),
                    'raw_material' => $request->input('raw_material'),
                    'price' => $request->input('price'),
                ]);
                $food->save();
                $food->foodCategories()->sync($request->input('foodCategories'));

                $food->resturant()->associate($restaurant); // Associate the food with the user's restaurant
                $food->save();

                if ($request->hasFile('food_image')) {
                    $image = $request->file('food_image');
                    $restaurantEmail = $restaurant->user->email;
                    $path = $image->store('restaurant_images/' . $restaurantEmail . '/foods', 'public');

                    // Create a new image record and associate it with the food
                    $imageModel = new Image(['url' => $path]);
                    $food->image()->save($imageModel);
                }



                return redirect()->route('foods.index')->with('success', 'غذا با موفقیت اضافه شد.');
            } else {
                return redirect()->route('foods.index')->with('failed', 'اطلاعات رستوران رو تکمیل کن.');
            }
        } else {
            return redirect()->route('auth.login');
        }
    }

    public function edit(Food $food)
    {
        return view('foods.edit', compact('food'));
    }

    public function update(Request $request, Food $food)
    {
        $request->validate([
            'name' => 'required|string',
            'raw_material' => 'required|string',
            'price' => 'required|numeric',
        ]);
        $food->update([
            'name' => $request->input('name'),
            'raw_material' => $request->input('raw_material'),
            'price' => $request->input('price'),
        ]);
        return redirect()->route('foods.index')->with('success', 'غذا با موفقیت آپدیت شد.');
    }

    public function destroy(Food $food)
    {
        DB::transaction(function () use ($food) {
            $food->delete();
        });

        return redirect()->route('foods.index')->with('success', 'غذا با موفقیت حذف شد.');
    }

    public function liveSearch(Request $request)
    {
        $search = $request->input('search');
        $user = auth()->user();

        $foods = $user->resturant->foods()
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('foodCategories', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->get();

        return response()->json(['data' => $foods]);
    }

}
