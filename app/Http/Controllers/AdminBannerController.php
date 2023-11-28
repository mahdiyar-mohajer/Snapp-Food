<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(BannerRequest $request)
    {

        $imagePath = $request->file('image')->store('banners', 'public');

        $banner = Banner::create([
            'title' => $request->input('title'),
            'text' => $request->input('text'),
        ]);

        $banner->image()->create([
            'url' => $imagePath,
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner added successfully');
    }
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(BannerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);

        if ($request->hasFile('image')) {

            if ($banner->image) {
                Storage::disk('public')->delete($banner->image->url);
            }

            $imagePath = $request->file('image')->store('banners', 'public');
            $banner->image()->update([
                'url' => $imagePath,
            ]);
        }

        // Update the banner details
        $banner->update([
            'title' => $request->input('title'),
            'text' => $request->input('text'),
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully');
    }
}
