<?php

namespace App\Http\Controllers;

use App\Repositories\PurchaseRepository;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function show(PurchaseRepository $repository, $id)
    {
        return $repository->show($id);
    }

    public function all(PurchaseRepository $repository)
    {
        return $repository->all();
    }

    public function store(PurchaseRepository $repository, Request $request)
    {
        return $repository->store($request);
    }

    public function update(PurchaseRepository $repository, Request $request, $id)
    {
        return $repository->update($request, $id);
    }

    public function delete(PurchaseRepository $repository, $id)
    {
        return $repository->delete($id);
    }
}
