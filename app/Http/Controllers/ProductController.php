<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->orderBy('created_at', 'DESC')
            ->paginate(8)
            ->withQueryString();

        return Inertia::render('Product/Index', [
            'products' => $products,
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
            'Product/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'string|max:255',
            'price' => 'integer|min:0',
            'image' => 'nullable|sometimes|image|mimes:jpeg,png,jpg'
        ]);


        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file(key: 'image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $request->file('image')->storeAs('images', $imageName);
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imageName
        ]);

        return redirect()->route('products.index')->with('message', 'Product Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return Inertia::render(
            'Product/View',
            [
                'product' => $product
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return Inertia::render(
            'Product/Edit',
            [
                'product' => $product
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'string|max:50',
            'description' => 'string|max:255',
            'price' => 'integer|min:0'
        ]);

        Log::info(json_encode($request->all()));
        $data = [

            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price

        ]
        ;

        Log::info(json_encode($data));


        $imageName = $product->image;
        if ($request->hasFile('image')) {
            $image = $request->file(key: 'image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $request->file('image')->storeAs('images', $imageName);
            if ($product->image && Storage::exists('images/' . $product->image)) {
                Storage::delete('images/' . $product->image);
            }
        }
        $data['image'] = $imageName;

        Log::info("This Data : " . json_encode($data));

        $product->update($data);

        return redirect()->route('products.index')->with('message', 'Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image && Storage::exists(storage_path('images/' . $product->image))) {
            Storage::delete(storage_path('images/' . $product->image));
        }
        $product->delete();
        return redirect()->route('products.index')->with('message', 'Product Deleted Successfully');
    }
}
