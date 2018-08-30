<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ProductResource;
class ProductController extends Controller
{

    public function index()
    {
        return ProductResource::collection(Product::paginate(15));
    }


    public function create()
    {
    }

    public function store(Request $request)
    {
        $product = Product::create(
              $request->all());
        return new ProductResource($product);
    }

    public function show($id)
    {
        $product = Product::find($id);
        return new ProductResource($product);
    }
    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return new ProductResource($product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return new ProductResource($product);
    }
}
