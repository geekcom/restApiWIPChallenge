<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Repositories\Contracts\PurchaseRepositoryContract;
use Illuminate\Support\Facades\Validator;

final class PurchaseRepository implements PurchaseRepositoryContract
{
    private $purchase;

    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

    public function show($id)
    {
        $purchase = $this->findPurchaseById($id);

        if ($purchase) {
            return response()->json(['status' => 'success', 'data' => ['purchase' => $purchase]], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    public function all()
    {
        $purchases = $this->purchase->paginate(10);

        if ($purchases) {
            return response()->json(['status' => 'success', 'data' => ['purchases' => $purchases]], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    public function store($request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'cart_id' => 'required',
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return
                response()->json([
                    'status' => 'fail',
                    'data' => [
                        'cart_id' => 'required',
                        'product_id' => 'required',
                    ]
                ], 422);
        }

        $createPurchase = $this
            ->purchase
            ->create($data);

        if ($createPurchase) {
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
        $purchase = $this->findPurchaseById($id);

        if($purchase){

            $data = $request->all();

            $validator = Validator::make($data, [
                'cart_id' => 'sometimes|required',
                'product_id' => 'sometimes|required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'data' => [
                        'cart_id' => 'required',
                        'product_id' => 'required',
                    ]], 422);
            }

            $purchase->update($data);

            return response()->json(['status' => 'success'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    public function delete($id)
    {
        $purchase = $this->findPurchaseById($id);

        if ($purchase) {
            $purchase->delete();
            return response()->json(['status' => 'success', 'data' => null], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    private function findPurchaseById($id)
    {
        return
            $this->purchase
                ->where('purchase_id', $id)
                ->first();
    }
}