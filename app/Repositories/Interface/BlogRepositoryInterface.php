<?php

namespace App\Repositories\Interface;

use Illuminate\Http\Request;

interface BlogRepositoryInterface
{
    public function index();
    public function store(Request $request);
    public function show($id);
    public function update(Request $request, $id);
    public function destroy($id);
}
