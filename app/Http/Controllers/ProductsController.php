<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Flower;
use App\Models\Image;
use App\Models\Price;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductsController extends BaseController
{

    public function adminIndex(?Request $request)
    {
        $flowers = Flower::with('currentPricing', 'image', 'categories')->paginate(10);
        $categories = Category::all();

        if ($request->ajax()) {
            $flowers->withPath('/admin/products');
            $links = (string)$flowers->links();
            $data = [
                'flowers' => $flowers,
                'categories' => $categories,
                'links' => $links
            ];

            return response()->json($data);
        }

        return view('pages.admin.products', compact('flowers', 'categories'));
    }

    public function store(ProductRequest $request)
    {
        $imageName = time() . '.' . $request->productImage->extension();

        try {
            DB::beginTransaction();
            $request->productImage->move(public_path('assets/img'), $imageName);

            $newImage = Image::create([
                'img_name' => $imageName,
                'path' => 'assets/img/' . $imageName,
            ]);

            $newProduct = Flower::create([
                'flower_name' => $request->productName,
                'active' => 1,
                'image_id' => $newImage->id_image,
            ]);

            Price::create([
                'flower_id' => $newProduct->id_flower,
                'price' => $request->productPrice,
                'currency_code' => "EUR",
                'effective_date' => '2024-12-12',
            ]);

            $newProduct->categories()->sync($request->productCategories);
            parent::writeToLog('info', Auth::user()->first_name . " added new product { " . $newProduct->id_flower . " }");
            DB::commit();
            return redirect()->route('admin.products');
        } catch (Exception $e) {
            parent::writeToLog('error', $e->getMessage());
            return redirect()->back()->with('error-msg', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $product = Flower::find($id);
            $imageId = $product->image_id;
            $image = Image::find($imageId);
            $product->categories()->detach($id);
            $product->delete();
            $image->delete();
            File::delete($image->path);
            DB::commit();
            parent::writeToLog('info', 'Product { ' . $id . ' } deleted');
            return redirect()->route('admin.products');
        } catch (Exception $e) {
            DB::rollBack();
            parent::writeToLog('error', $e->getMessage());
            return redirect()->back()->with('product-delete-error', $e->getMessage());
        }
    }


    public function update(ProductRequest $request, $id)
    {
        function newProductImage($request)
        {
            $imageName = time() . '.' . $request->productImage->extension();
            $request->productImage->move(public_path('assets/img'), $imageName);
            $newImage = Image::create([
                'img_name' => $imageName,
                'path' => 'assets/img/' . $imageName,
            ]);

            return $newImage;
        }

        try {
            DB::beginTransaction();
            $productToEdit = Flower::find($id);
            if (isset($request->productImage)) {

                $oldImg = Image::find($productToEdit->image_id);
                File::delete($oldImg->path);
                $productToEdit->image()->dissociate();
                $productToEdit->image()->associate(newProductImage($request, $productToEdit->image_id));
            }

            $price = Price::create([
                'price' => $request->productPrice,
                'flower_id' => $productToEdit->id_flower,
                'currency_code' => "EUR",
                'effective_date' => '2025-01-01',
            ]);

            $productToEdit->flower_name = $request->productName;
            $productToEdit->prices()->save($price);

            $productToEdit->save();

            parent::writeToLog('info', Auth::user()->first_name . " edited poduct { " . $productToEdit->id_flower . " }");
            DB::commit();
            return redirect()->back()->with('edit-success-msg', "Product edited successfully.");
        } catch (Exception $e) {
            //parent::writeToLog('error', $e->getMessage());
            return redirect()->back()->with('error-msg', $e->getMessage());
        }
    }

    public function index()
    {
        $categories = Category::all();
        $products = Flower::query()->with('currentPricing', 'image', 'categories')->paginate(6);

        return view('pages.products.products', compact('products', 'categories'));
    }

    public function filter($query = "0", $sortOrder = "0", $filters = array())
    {
        $categories = Category::all();
        $upit = Flower::with('currentPricing', 'image', 'categories');

        if (isset($query) && $query != "0") {
            $upit->where(strtolower('flower_name'), 'like', "%" . strtolower($query) . "%");
        }
        if (isset($sortOrder) && $sortOrder != "0") {

            if ($sortOrder == 'name-asc') {
                $upit->orderBy('flower_name');
            }
            if ($sortOrder == 'name-desc') {
                $upit->orderBy('flower_name', 'desc');
            }
            if ($sortOrder == 'price-asc') {
                $upit->orderBy(Price::select('price')->whereColumn('prices.flower_id', 'flowers.id_flower')->latest());
            }
            if ($sortOrder == 'price-desc') {
                $upit->orderByDesc(Price::select('price')->whereColumn('prices.flower_id', 'flowers.id_flower')->latest());
            }
        }

        if (isset($filters) && $filters != "[]") {
            // dd(json_decode($filters));
            $filters = json_decode($filters);
            $upit->whereHas('categories', function ($q) use ($filters) {
                $q->whereIn('category_flowers.category_id', $filters);
            });
        }

        $data = [
            'products' => $upit->paginate(6),
            'categories' => $categories,
            'links' => $upit->paginate(6)->links(),
        ];
        return $data;
    }

    public function show(?Request $request, $id)
    {
        $product = Flower::with('currentPricing', 'image', 'categories')->find($id);

        if ($request->ajax()) {
            $categories = Category::all();

            $data = [
                'product' => $product,
                'categories' => $categories,
            ];
            return response()->json($data);
        }

        return view('pages.products.show', compact('product'));
    }
}
