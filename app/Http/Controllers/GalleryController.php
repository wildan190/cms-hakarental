<?php

namespace App\Http\Controllers;

use App\Repositories\Interface\GalleryRepositoryInterface;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    protected $galleryRepo;

    public function __construct(GalleryRepositoryInterface $galleryRepo)
    {
        $this->galleryRepo = $galleryRepo;
    }

    public function index()
    {
        return response()->json($this->galleryRepo->index());
    }

    public function store(Request $request)
    {
        return response()->json($this->galleryRepo->store($request), 201);
    }

    public function show($id)
    {
        return response()->json($this->galleryRepo->show($id));
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->galleryRepo->update($request, $id));
    }

    public function destroy($id)
    {
        return $this->galleryRepo->destroy($id);
    }
}
