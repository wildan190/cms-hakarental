<?php

namespace App\Http\Controllers;

use App\Repositories\Interface\BlogRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BlogController extends Controller
{
    protected $blogRepository;

    public function __construct(BlogRepositoryInterface $blogRepository)
    {
        $this->middleware('auth:sanctum');
        $this->blogRepository = $blogRepository;
    }

    public function index()
    {
        return $this->blogRepository->index();
    }

    public function store(Request $request)
    {
        return $this->blogRepository->store($request);
    }

    public function show($id)
    {
        return $this->blogRepository->show($id);
    }

    public function update(Request $request, $id)
    {
        return $this->blogRepository->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->blogRepository->destroy($id);
    }
}
