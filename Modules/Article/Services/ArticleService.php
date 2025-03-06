<?php

declare(strict_types=1);

namespace Modules\Article\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Article\Interfaces\Repositories\ArticleRepositoryInterface;
use Modules\Article\Models\Article;

/**
 * Service for handling article operations
 */
class ArticleService
{
    /**
     * @param ArticleRepositoryInterface $articleRepository
     */
    public function __construct(
        private readonly ArticleRepositoryInterface $articleRepository
    ) {}

    /**
     * Get all articles paginated
     * 
     * @param int $perPage Number of items per page
     * @return LengthAwarePaginator<Article>
     */
    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->articleRepository->getAllPaginated($perPage);
    }

    /**
     * Get all articles
     * 
     * @return Collection<int, Article>
     */
    public function getAll(): Collection
    {
        return $this->articleRepository->getAll();
    }

    /**
     * Find an article by ID
     * 
     * @param int $id The article ID
     * @return Article|null
     */
    public function findById(int $id): ?Article
    {
        return $this->articleRepository->findById($id);
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
        return $this->articleRepository->findOrFail($id);
    }

    /**
     * Find an article by slug
     * 
     * @param string $slug The article slug
     * @return Article|null
     */
    public function findBySlug(string $slug): ?Article
    {
        return $this->articleRepository->findBySlug($slug);
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
        return $this->articleRepository->findBySlugOrFail($slug);
    }
}
