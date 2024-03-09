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
        // dd($request->productImage); 

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
            DB::commit();
            return redirect()->route('admin.products');
        } catch (Exception $e) {
            // DB::rollBack();
            // if (File::exists(public_path('/assets/img/products/' . $imageName))) {
            //     File::delete(public_path('/assets/img/products/' . $imageName));
            // }
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
            parent::writeToLog('info', 'Product ' . $id . ' deleted.');
            return redirect()->route('admin.products');
        } catch (Exception $e) {
            DB::rollBack();
            parent::writeToLog('error', $e->getMessage());
            return redirect()->back()->with('product-delete-error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
    }

    public function index()
    {
        $categories = Category::all();
        $products = Flower::with('currentPricing', 'image', 'categories')->paginate(6);

        return view('pages.products.products', compact('products', 'categories'));
    }

    public function filter($query = "0", $sortOrder = "0", $filters = [])
    {
        $categories = Category::all();
        // $upit = Flower::join('images', 'flowers.image_id', '=', 'images.id_image')
        //     ->join('category_flowers', 'flowers.id_flower', '=', 'category_flowers.flower_id')
        //     ->join('categories', 'categories.id_category', '=', 'category_flowers.category_id')
        //     ->join('prices', 'prices.flower_id', '=', 'flowers.id_flower')->where('prices.effective_date', '>', now());
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
             
            }
        }

        if (isset($filters) && $filters) {
            //$upit->orderBy('flower_name');
        }

        $products = $upit->paginate(6);

        $data = [
            'products' => $products,
            'categories' => $categories,
        ];
        return response()->json($data);
    }

    public function show($id)
    {
        $product = Flower::with('currentPricing', 'image', 'categories')->find($id);

        return view('pages.products.show', compact('product'));
    }
}
