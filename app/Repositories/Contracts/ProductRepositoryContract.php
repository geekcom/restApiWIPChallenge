<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryContract
{
    public function show($id);

    public function all();

    public function store($request);

    public function update($request, $id);

    public function delete($id);
}