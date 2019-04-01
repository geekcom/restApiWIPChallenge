<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\Contracts\CartRepositoryContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class CartRepository implements CartRepositoryContract
{
    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function show($id)
    {
        $cart = $this->findCartById($id);

        if ($cart) {
            return response()->json(['status' => 'success', 'data' => ['cart' => $cart]], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    public function all()
    {
        $carts = $this->cart->paginate(10);

        if ($carts) {
            return response()->json(['status' => 'success', 'data' => ['carts' => $carts]], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    public function purchasesByCart($id)
    {
        $purchasesByCart = $this->cart
            ->where('cart_id', $id)
            ->with('purchases')
            ->get();

        if ($purchasesByCart) {
            return response()->json(['status' => 'success', 'data' => ['purchasesByCart' => $purchasesByCart]], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    public function store($request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'product_id' => 'required',
            'cart_total_amount' => 'required',
        ]);

        if ($validator->fails()) {
            return
                response()->json([
                    'status' => 'fail',
                    'data' => [
                        'product_id' => 'required',
                        'cart_total_amount' => 'required',
                    ]
                ], 422);
        }

        $createCart = $this
            ->cart
            ->create($data);

        if ($createCart) {
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
        $cart = $this->findCartById($id);

        if($cart){

            $data = $request->all();

            $validator = Validator::make($data, [
                'product_id' => 'sometimes|required',
                'cart_total_amount' => 'sometimes|required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'data' => [
                        'product_id' => 'required',
                        'cart_total_amount' => 'required',
                    ]], 422);
            }

            $cart->update($data);

            return response()->json(['status' => 'success'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    public function delete($id)
    {
        $cart = $this->findCartById($id);

        if ($cart) {
            $cart->delete();
            return response()->json(['status' => 'success', 'data' => null], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    private function findCartById($id)
    {
        return
            $this->cart
                ->where('cart_id', $id)
                ->first();
    }
}