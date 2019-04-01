<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryContract;
use Illuminate\Support\Facades\Validator;

final class ProductRepository implements ProductRepositoryContract
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function show($id)
    {
        $product = $this->findProductById($id);

        if ($product) {

            return response()->json(['status' => 'success', 'data' => ['product' => $product]], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    public function all()
    {
        $products = $this->product->paginate(10);

        if ($products) {
            return response()->json(['status' => 'success', 'data' => ['products' => $products]], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    public function store($request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'product_name' => 'required',
            'product_price' => 'required',
        ]);

        if ($validator->fails()) {
            return
                response()->json([
                    'status' => 'fail',
                    'data' => [
                        'product_name' => 'required',
                        'product_price' => 'required',
                    ]
                ], 422);
        }

        $createProduct = $this
            ->product
            ->create($data);

        if ($createProduct) {
            return
                response()->json([
                    'status' => 'success'
                ], 201);
        }

        return
            response()->json([
                'status' => 'error'
            ], 500);
    }

    public function update($request, $id)
    {
        $product = $this->findProductById($id);

        if($product){

            $data = $request->all();

            $validator = Validator::make($data, [
                'product_name' => 'sometimes|required',
                'product_price' => 'sometimes|required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'data' => [
                        'product_name' => 'required',
                        'product_price' => 'required',
                    ]], 422);
            }

            $product->update($data);

            return response()->json(['status' => 'success'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    public function delete($id)
    {
        $product = $this->findProductById($id);

        if ($product) {
            $product->delete();
            return response()->json(['status' => 'success', 'data' => null], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    private function findProductById($id)
    {
        return
            $this->product
                ->where('product_id', $id)
                ->first();
    }
}