<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('id', 'desc')->paginate(5);

        // dd($products);

        return inertia('Products/Index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Products/Create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'name' => 'required|string|max:255',
                'sku' => 'nullable|string|max:255',
                'price' => 'nullable|numeric',
                'stock' => 'nullable|numeric',
                'cost_price' => 'nullable|numeric',
                'special_price' => 'nullable|numeric',
                'category_id' => 'nullable|exists:categories,id',
                'category_name' => 'nullable|string|max:255',
                'status' => 'boolean',
                'tipe' => 'nullable|numeric|max:255',
                'varian' => 'nullable|numeric|max:255',
                'image' => 'nullable|image|max:2048',
            ],
            [
                'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            ]
        );

        // kalau user input kategori baru
        if (!$data['category_id'] && !empty($data['category_name'])) {
            $category = Category::firstOrCreate(['name' => $data['category_name']]);
            $data['category_id'] = $category->id;
        }

        // Handle image upload jika ada
        if ($request->hasFile('image')) {
            // Simpan gambar ke public/storage/products
            // Laravel akan secara otomatis memberikan nama unik (hash) pada file
            $imagePath = $request->file('image')->store('products', 'public');

            // Simpan path ke array data untuk disimpan di database
            $data['image'] = $imagePath;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Product $product)
    {
        $product->load('category');
        return inertia('Products/Edit', [
            'product' => $product,
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'varian' => 'nullable|string|max:100',
            'tipe' => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,id',
            'category_name' => 'required_without:category_id|string|max:255',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'special_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
        ]);

        if (empty($validated['category_id'])) {
            $category = Category::firstOrCreate([
                'name' => $validated['category_name']
            ]);
            $validated['category_id'] = $category->id;
        }

        unset($validated['category_name']);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        } else {
            unset($validated['image']);
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // delete image
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Toggle status (1 = aktif, 0 = nonaktif)
        $product->status = $product->status == 1 ? 0 : 1;
        $product->save();

        return back()->with('success', 'Status produk berhasil diubah.');
    }
}
