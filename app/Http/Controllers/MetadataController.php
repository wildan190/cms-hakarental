<?php

namespace App\Http\Controllers;

use App\Repositories\Interface\MetadataRepositoryInterface;
use Illuminate\Http\Request;

class MetadataController extends Controller
{
    protected $metadataRepo;

    public function __construct(MetadataRepositoryInterface $metadataRepo)
    {
        $this->metadataRepo = $metadataRepo;
    }

    public function index()
    {
        return response()->json($this->metadataRepo->index());
    }

    public function store(Request $request)
    {
        // Kalau sudah ada, langsung kasih pesan error
        return response()->json($this->metadataRepo->store($request));
    }

    public function show($id)
    {
        return response()->json($this->metadataRepo->show($id));
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->metadataRepo->update($request, $id));
    }

    public function destroy($id)
    {
        return $this->metadataRepo->destroy($id);
    }
}
