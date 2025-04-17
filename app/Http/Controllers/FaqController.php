<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interface\FaqRepositoryInterface;

class FaqController extends Controller
{
    protected $faqRepo;

    public function __construct(FaqRepositoryInterface $faqRepo)
    {
        $this->faqRepo = $faqRepo;
    }

    public function index()
    {
        return response()->json($this->faqRepo->index());
    }

    public function store(Request $request)
    {
        $faq = $this->faqRepo->store($request);
        return response()->json([
            'message' => 'FAQ berhasil disimpan',
            'data' => $faq
        ], 201);
    }

    public function show($id)
    {
        return response()->json($this->faqRepo->show($id));
    }

    public function update(Request $request, $id)
    {
        $faq = $this->faqRepo->update($request, $id);
        return response()->json([
            'message' => 'FAQ berhasil diperbarui',
            'data' => $faq
        ]);
    }

    public function destroy($id)
    {
        $this->faqRepo->destroy($id);
        return response()->json(['message' => 'FAQ berhasil dihapus']);
    }
}
