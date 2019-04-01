<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show(CartRepository $repository, $id)
    {
        return $repository->show($id);
    }

    public function all(CartRepository $repository)
    {
        return $repository->all();
    }

    public function store(CartRepository $repository, Request $request)
    {
        return $repository->store($request);
    }

    public function update(CartRepository $repository, Request $request, $id)
    {
        return $repository->update($request, $id);
    }

    public function delete(CartRepository $repository, $id)
    {
        return $repository->delete($id);
    }

    public function purchasesByCart(CartRepository $repository, $id)
    {
        return $repository->purchasesByCart($id);
    }
}
