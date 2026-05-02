<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trip\StoreTripRequest;
use App\Http\Requests\Trip\UpdateTripRequest;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $query = Trip::query()->with('destination');

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $trips = $query->latest()->paginate($request->integer('per_page', 10));

        return TripResource::collection($trips);
    }

    public function show(Trip $trip)
    {
        return new TripResource($trip->load('destination'));
    }

    public function store(StoreTripRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['name']);

        $trip = Trip::create($data);

        return (new TripResource($trip->load('destination')))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateTripRequest $request, Trip $trip)
    {
        $data = $request->validated();

        if (!isset($data['slug']) && isset($data['name'])) {
            $data['slug'] = $this->resolveSlug(null, $data['name'], $trip->id);
        } elseif (isset($data['slug'])) {
            $data['slug'] = $this->resolveSlug($data['slug'], $data['name'] ?? $trip->name, $trip->id);
        }

        $trip->update($data);

        return new TripResource($trip->load('destination'));
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();

        return response()->json([
            'data' => [
                'message' => 'Trip deleted.',
            ],
        ]);
    }

    private function resolveSlug(?string $slug, string $name, ?int $ignoreId = null): string
    {
        $base = $slug ? Str::slug($slug) : Str::slug($name);
        $candidate = $base;
        $counter = 1;

        while (
            Trip::where('slug', $candidate)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $candidate = "{$base}-{$counter}";
            $counter++;
        }

        return $candidate;
    }
}
