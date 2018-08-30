<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotAllow;
use Illuminate\Http\Request;
use App\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth')->only('store');
    }

    public function index()
    {
        return response()->json([
            'code' => 1,
            'data' => ProductResource::collection(Product::paginate(15))
        ], 200);
    }


    public function create()
    {
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|min:5|unique:products,name',
            'description' => 'required|max:255',
            'price' => 'required|numeric'
        ]);

        $product = Product::create($request->all());

        return response()->json([
            'code' => 1,
            'data' => $product
        ]);

    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:5',
            'description' => 'required|max:255',
            'price' => 'required|numeric'
        ]);
        if($validator->fails()){
            throw new NotAllow($request);
//            return response()->json([
//                'code' => 2,
//                'error' => $validator->errors()
//            ], 422);
        }

        $product = Product::find($id);
        $update = $product->update($request->all());
        if ($update) {
            return response()->json([
                'code' => 1,
                'data' => new ProductResource($product)
            ]);
        }

    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return new ProductResource($product);
    }
}
