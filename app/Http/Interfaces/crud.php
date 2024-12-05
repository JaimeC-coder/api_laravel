<?php

namespace App\Http\Interfaces;

interface crud
{
    public function index();
    public function create(array $data);
    public function update(array $data, string $id);
    public function delete(string $id);
    public function show(string $id);
}
