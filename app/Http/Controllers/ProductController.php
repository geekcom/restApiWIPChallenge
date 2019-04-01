<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    public function show(ProductRepository $repository, $id)
    {
        return $repository->show($id);
    }

    public function all(ProductRepository $repository)
    {
        return $repository->all();
    }

    public function store(ProductRepository $repository, Request $request)
    {
        return $repository->store($request);
    }

    public function update(ProductRepository $repository, Request $request, $id)
    {
        return $repository->update($request, $id);
    }

    public function delete(ProductRepository $repository, $id)
    {
        return $repository->delete($id);
    }
}
