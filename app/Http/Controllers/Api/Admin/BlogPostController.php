<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StoreBlogPostRequest;
use App\Http\Requests\Blog\UpdateBlogPostRequest;
use App\Http\Resources\BlogPostResource;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::query();

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $posts = $query->latest()->paginate($request->integer('per_page', 10));

        return BlogPostResource::collection($posts);
    }

    public function show(BlogPost $blogPost)
    {
        return new BlogPostResource($blogPost);
    }

    public function store(StoreBlogPostRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['title']);

        $post = BlogPost::create($data);

        return (new BlogPostResource($post))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateBlogPostRequest $request, BlogPost $blogPost)
    {
        $data = $request->validated();

        if (!isset($data['slug']) && isset($data['title'])) {
            $data['slug'] = $this->resolveSlug(null, $data['title'], $blogPost->id);
        } elseif (isset($data['slug'])) {
            $data['slug'] = $this->resolveSlug($data['slug'], $data['title'] ?? $blogPost->title, $blogPost->id);
        }

        $blogPost->update($data);

        return new BlogPostResource($blogPost);
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return response()->json([
            'data' => [
                'message' => 'Blog post deleted.',
            ],
        ]);
    }

    private function resolveSlug(?string $slug, string $title, ?int $ignoreId = null): string
    {
        $base = $slug ? Str::slug($slug) : Str::slug($title);
        $candidate = $base;
        $counter = 1;

        while (
            BlogPost::where('slug', $candidate)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $candidate = "{$base}-{$counter}";
            $counter++;
        }

        return $candidate;
    }
}
