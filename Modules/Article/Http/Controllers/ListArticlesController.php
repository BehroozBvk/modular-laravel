<?php

declare(strict_types=1);

namespace Modules\Article\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Article\Http\Requests\ListArticlesRequest;
use Modules\Article\Http\Resources\ArticleResource;
use Modules\Article\Services\ArticleService;

/**
 * Controller for listing articles
 */
class ListArticlesController
{
    /**
     * @param ArticleService $articleService
     */
    public function __construct(
        private readonly ArticleService $articleService,
    ) {}

    /**
     * Handle the incoming request to list articles
     * 
     * @param ListArticlesRequest $request
     * @return AnonymousResourceCollection<ArticleResource>
     */
    public function __invoke(ListArticlesRequest $request): AnonymousResourceCollection
    {
        $dto = $request->toDto();

        $articles = $this->articleService->getAllPaginated($dto->perPage);

        return ArticleResource::collection($articles);
    }
}
