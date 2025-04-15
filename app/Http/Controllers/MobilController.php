<?php

namespace App\Http\Controllers;

use App\Repositories\Interface\MobilRepositoryInterface;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    protected $mobilRepo;

    public function __construct(MobilRepositoryInterface $mobilRepo)
    {
        $this->mobilRepo = $mobilRepo;
    }

    public function index()
    {
        return response()->json($this->mobilRepo->index());
    }

    public function store(Request $request)
    {
        return response()->json($this->mobilRepo->store($request), 201);
    }

    public function show($id)
    {
        return response()->json($this->mobilRepo->show($id));
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->mobilRepo->update($request, $id));
    }

    public function destroy($id)
    {
        return $this->mobilRepo->destroy($id);
    }
}
