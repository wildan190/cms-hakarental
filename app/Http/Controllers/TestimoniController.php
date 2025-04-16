<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interface\TestimoniRepositoryInterface;

class TestimoniController extends Controller
{
    protected $testimoniRepo;

    public function __construct(TestimoniRepositoryInterface $testimoniRepo)
    {
        $this->testimoniRepo = $testimoniRepo;
    }

    public function index()
    {
        return response()->json($this->testimoniRepo->index());
    }

    public function store(Request $request)
    {
        return response()->json($this->testimoniRepo->store($request));
    }

    public function show($id)
    {
        return response()->json($this->testimoniRepo->show($id));
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->testimoniRepo->update($request, $id));
    }

    public function destroy($id)
    {
        return $this->testimoniRepo->destroy($id);
    }
}
