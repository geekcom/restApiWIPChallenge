<?php

namespace App\Repositories\Contracts;

interface CartRepositoryContract
{
    public function show($id);

    public function all();

    public function store($request);

    public function update($request, $id);

    public function delete($id);

    public function purchasesByCart($id);
}