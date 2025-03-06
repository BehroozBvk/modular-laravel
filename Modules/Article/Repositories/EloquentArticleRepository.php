<?php

declare(strict_types=1);

namespace Modules\Article\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Article\Interfaces\Repositories\ArticleRepositoryInterface;
use Modules\Article\Models\Article;

/**
 * Eloquent implementation of ArticleRepositoryInterface
 */
class EloquentArticleRepository implements ArticleRepositoryInterface
{
    /**
     * Get all articles paginated
     * 
     * @param int $perPage Number of items per page
     * @return LengthAwarePaginator<Article>
     */
    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Article::query()
            ->with(['category', 'author', 'seoSetting'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get all articles
     * 
     * @return Collection<int, Article>
     */
    public function getAll(): Collection
    {
        return Article::query()
            ->with(['category', 'author', 'seoSetting'])
            ->latest()
            ->get();
    }

    /**
     * Find an article by ID
     * 
     * @param int $id The article ID
     * @return Article|null
     */
    public function findById(int $id): ?Article
    {
        return Article::query()
            ->with(['category', 'author', 'seoSetting', 'comments'])
            ->find($id);
    }

    /**
     * Find an article by ID or fail
     * 
     * @param int $id The article ID
     * @return Article
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Article
    {
        return Article::query()
            ->with(['category', 'author', 'seoSetting', 'comments'])
            ->findOrFail($id);
    }

    /**
     * Find an article by slug
     * 
     * @param string $slug The article slug
     * @return Article|null
     */
    public function findBySlug(string $slug): ?Article
    {
        return Article::query()
            ->with(['category', 'author', 'seoSetting', 'comments' => function ($query) {
                $query->whereNull('parent_id')
                    ->with('replies');
            }])
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Find an article by slug or fail
     * 
     * @param string $slug The article slug
     * @return Article
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findBySlugOrFail(string $slug): Article
    {
        return Article::query()
            ->with(['category', 'author', 'seoSetting', 'comments' => function ($query) {
                $query->whereNull('parent_id')
                    ->with('replies');
            }])
            ->where('slug', $slug)
            ->firstOrFail();
    }
}
