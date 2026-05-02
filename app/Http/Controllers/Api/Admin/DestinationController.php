<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Destination\StoreDestinationRequest;
use App\Http\Requests\Destination\UpdateDestinationRequest;
use App\Http\Resources\DestinationResource;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $query = Destination::query();

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $destinations = $query->latest()->paginate($request->integer('per_page', 10));

        return DestinationResource::collection($destinations);
    }

    public function show(Destination $destination)
    {
        return new DestinationResource($destination);
    }

    public function store(StoreDestinationRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['name']);

        $destination = Destination::create($data);

        return (new DestinationResource($destination))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateDestinationRequest $request, Destination $destination)
    {
        $data = $request->validated();

        if (!isset($data['slug']) && isset($data['name'])) {
            $data['slug'] = $this->resolveSlug(null, $data['name'], $destination->id);
        } elseif (isset($data['slug'])) {
            $data['slug'] = $this->resolveSlug($data['slug'], $data['name'] ?? $destination->name, $destination->id);
        }

        $destination->update($data);

        return new DestinationResource($destination);
    }

    public function destroy(Destination $destination)
    {
        $destination->delete();

        return response()->json([
            'data' => [
                'message' => 'Destination deleted.',
            ],
        ]);
    }

    private function resolveSlug(?string $slug, string $name, ?int $ignoreId = null): string
    {
        $base = $slug ? Str::slug($slug) : Str::slug($name);
        $candidate = $base;
        $counter = 1;

        while (
            Destination::where('slug', $candidate)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $candidate = "{$base}-{$counter}";
            $counter++;
        }

        return $candidate;
    }
}
