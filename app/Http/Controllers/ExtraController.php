<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ExtraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $extras = Extra::query()
            ->orderBy('created_at', 'DESC')
            ->where('type', $request->type)
            ->paginate(8)
            ->withQueryString();

        return Inertia::render('Extra/Index', [
            'extras' => $extras,
            'filters' => $request->all('filter'),
            'message' => session('message'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Extra/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'type' => 'required|string',
            'price' => 'integer|min:0',
            'image' => 'nullable|sometimes|image|mimes:jpeg,png,jpg'
        ]);
        $data = $request->all();
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file(key: 'image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $request->file('image')->storeAs('images', $imageName);
            $data['image'] = $imageName;
        }
        Extra::create($data);

        return redirect()->route('extras.index', ['type' => $data['type']])->with('message', 'extra Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Extra $extra)
    {
        return Inertia::render(
            'Extra/View',
            [
                'extra' => $extra
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Extra $extra)
    {
        return Inertia::render(
            'Extra/Edit',
            [
                'extra' => $extra
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Extra $extra)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'type' => 'required|string',
            'price' => 'integer|min:0'
        ]);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'type' => $request->type
        ];

        $imageName = $extra->image;
        if ($request->hasFile('image')) {
            $image = $request->file(key: 'image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $request->file('image')->storeAs('images', $imageName);
            if ($extra->image && Storage::exists('images/' . $extra->image)) {
                Storage::delete('images/' . $extra->image);
            }
        }
        $data['image'] = $imageName;
        $extra->update($data);

        return redirect()->route('extras.index', ['type' => $data['type']])->with('message', 'extra Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Extra $extra)
    {
        $type = $extra->type;
        if ($extra->image && Storage::exists(storage_path('images/' . $extra->image))) {
            Storage::delete(storage_path('images/' . $extra->image));
        }
        $extra->delete();
        return redirect()->route('extras.index', ['type' => $type])->with('message', 'Extra Deleted Successfully');
    }


    public function getByType(Request $request)
    {
        $extras = Extra::query()->where('type', $request->type)->get();
        return response()->json(['extras' => $extras]);
    }
}
