<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Picture;
use Illuminate\Support\Str;

class PicturesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['showActive']]);
    }

    public function index()
    {
        $pictures = Picture::orderBy('created_at', 'DESC')->paginate(10);

        return response()->json($pictures);
    }

    public function show(int $id)
    {
        $picture = Picture::find($id);

        return response()->json($picture);
    }

    public function showActive()
    {
        $picture = Picture::where('is_current', true)->first();

        return response()->json($picture);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'year' => 'required|integer',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            'description' => 'required|string',
            'link' => 'required|url'
        ]);

        if ($request->image) {
            $imageName = time() . Str::random(10) . '.'.$request->image->extension();  
       
            $request->image->move(public_path('images'), $imageName);

            $data['image'] = config('app:url') . '/images/' . $imageName;
        }

        $data['is_current'] = false;

        Picture::create($data);

        $pictures = Picture::orderBy('created_at', 'DESC')->paginate(10);

        return response()->json($pictures);
    }

    public function update(Request $request, int $id)
    {
        $picture = Picture::find($id);

        $data = $request->validate([
            'year' => 'integer',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
            'description' => 'string',
            'link' => 'url'
        ]);

        if ($request->image) {
            $imageName = time() . Str::random(10) . '.'.$request->image->extension();  
       
            $request->image->move(public_path('images'), $imageName);

            $data['image'] = config('app:url') . '/images/' . $imageName;
        }

        $picture->update($data);

        $pictures = Picture::orderBy('created_at', 'DESC')->paginate(10);

        return response()->json($pictures);
    }

    public function activate(int $id)
    {
        $picture = Picture::find($id);

        if (!$picture->is_current) {
            $currActivePic = Picture::where('is_current', true)->first();
            
            if ($currActivePic) {
                $currActivePic->is_current = false;
                $currActivePic->save();
            }
            
            $picture->is_current = true;
            $picture->save();
        } else {
            $picture->is_current = false;
            $picture->save();

            $newActivePic = Picture::whereNot('id', $picture->id)->first();
            
            if ($newActivePic) {
                $newActivePic->is_current = true;
                $newActivePic->save();
            }
        }

        $pictures = Picture::orderBy('created_at', 'DESC')->paginate(10);

        return response()->json($pictures);
    }

    public function destroy(int $id)
    {
        $picture = Picture::find($id);

        if ($picture) {
            $picture->delete();
        }

        $pictures = Picture::orderBy('created_at', 'DESC')->paginate(10);

        return response()->json($pictures);
    }
}
