<?php

declare(strict_types=1);

namespace Modules\Article\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Article\Http\Requests\GetArticleBySlugRequest;
use Modules\Article\Http\Resources\ArticleResource;
use Modules\Article\Services\ArticleService;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for retrieving an article by slug
 */
class GetArticleBySlugController
{
    /**
     * @param ArticleService $articleService
     */
    public function __construct(
        private readonly ArticleService $articleService,
    ) {}

    /**
     * Handle the incoming request to get an article by slug
     * 
     * @param GetArticleBySlugRequest $request
     * @return ArticleResource|JsonResponse
     */
    public function __invoke(GetArticleBySlugRequest $request): ArticleResource|JsonResponse
    {
        $slug = $request->getSlug();

        $article = $this->articleService->findBySlug($slug);

        if (!$article) {
            return new JsonResponse(
                ['message' => 'Article not found'],
                Response::HTTP_NOT_FOUND
            );
        }

        return new ArticleResource($article);
    }
}
