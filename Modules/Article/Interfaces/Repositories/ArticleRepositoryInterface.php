<?php

declare(strict_types=1);

namespace Modules\Article\Interfaces\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Article\Models\Article;

/**
 * Interface for article repositories
 */
interface ArticleRepositoryInterface
{
    /**
     * Get all articles paginated
     * 
     * @param int $perPage Number of items per page
     * @return LengthAwarePaginator<Article>
     */
    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator;

    /**
     * Get all articles
     * 
     * @return Collection<int, Article>
     */
    public function getAll(): Collection;

    /**
     * Find an article by ID
     * 
     * @param int $id The article ID
     * @return Article|null
     */
    public function findById(int $id): ?Article;

    /**
     * Find an article by ID or fail
     * 
     * @param int $id The article ID
     * @return Article
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Article;

    /**
     * Find an article by slug
     * 
     * @param string $slug The article slug
     * @return Article|null
     */
    public function findBySlug(string $slug): ?Article;

    /**
     * Find an article by slug or fail
     * 
     * @param string $slug The article slug
     * @return Article
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findBySlugOrFail(string $slug): Article;
}
