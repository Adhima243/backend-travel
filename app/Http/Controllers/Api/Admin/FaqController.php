<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\StoreFaqRequest;
use App\Http\Requests\Faq\UpdateFaqRequest;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $query = Faq::query();

        if ($request->has('active')) {
            $query->where('is_active', $request->boolean('active'));
        }

        $faqs = $query->orderBy('sort_order')->get();

        return FaqResource::collection($faqs);
    }

    public function show(Faq $faq)
    {
        return new FaqResource($faq);
    }

    public function store(StoreFaqRequest $request)
    {
        $faq = Faq::create($request->validated());

        return (new FaqResource($faq))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateFaqRequest $request, Faq $faq)
    {
        $faq->update($request->validated());

        return new FaqResource($faq);
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->json([
            'data' => [
                'message' => 'FAQ deleted.',
            ],
        ]);
    }
}
