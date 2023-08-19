<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductType;
use App\Models\RatingComment;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function Laravel\Prompts\error;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
//        $productList = array();
//        foreach (Product::all() as $product) {
//            $productList[] = [
//                $product,
//                $product->category(),
//                $product->attribute(),
//                $product->tag(),
//                $product->type()
//            ];
//        }
//        return response()->json($productList);
        return response()->json(ProductResource::collection(Product::all()));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Validate

        // Store the information in the database
        try {
            $newProduct = Product::create([
                'type_id' => ProductType::firstOrCreate(['name' => $request->type])->id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'summary' => $request->summary,
                'detail' => $request->detail,
                'category_id' => ProductCategory::firstOrCreate(['name' => $request->category])->id,
                'regular_price' => $request->regular_price,
                'sale_price' => $request->sale_price,
                'stock_quantity' => $request->stock_quantity,
                'total_sale' => $request->total_sale
            ]);
            ProductAttribute::create([
                'product_id' => $newProduct->id,
                'type' => $request->attribute_type,
                'name' => $request->attribute_type,
                'code' => $request->attribute_code
            ]);
            // Store the image
            if ($request->hasFile('images')){
//            $imagePath = $request->file('images')->store('images');
                $newProduct->addMediaFromRequest('images')->toMediaCollection('images');
            }
            return response()->json([
                'message' => 'Created'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified product.
     */
    public function show(int $id)
    {
        $product = Product::findOrFail($id);
        $cat_id = $product->category_id;
        $relatedProducts = ProductResource::collection(Product::where('category_id', '=', $cat_id)
            ->where('slug', '!=', $product->slug)
            ->inRandomOrder()->take(10)->get());
        $nonRelatedProducts = ProductResource::collection(Product::where('category_id', '!=', $cat_id)->take(10)->get());

        return [
            'product' => new ProductResource($product),
            'related_products' => $relatedProducts,
            'non_related_products' => $nonRelatedProducts,
        ];
    }


    /**
     * Display the specified product by slug
     */
    public function showBySlug(string $slug)
    {
        return $this->show(Product::where('slug', $slug)->first()->id);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->type_id = ProductType::where('name', $request->type)->first()->get()->id;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->summary = $request->summary;
        $product->detail = $request->detail;
        $product->category_id = ProductCategory::where('name', $request->category)->first()->get()->id;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->stock_quantity = $request->stock_quantity;
        $product->total_sale = $request->total_sale;
        $product->save();
        return response()->json([
            'message' => 'Updated type of products successfully.'
        ], 200);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();
        return response()->json([
            'message' => 'Delete products type successfully.'
        ], 200);
    }
}
