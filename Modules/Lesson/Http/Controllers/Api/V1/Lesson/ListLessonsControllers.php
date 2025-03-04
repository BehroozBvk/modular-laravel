<?php

declare(strict_types=1);

namespace Modules\Lesson\Http\Controllers\Api\V1\Lesson;

use Exception;
use Illuminate\Http\JsonResponse;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Http\Controllers\Api\V1\BaseApiV1Controller;
use Modules\Lesson\Http\Requests\Api\V1\ListLessonsRequest;
use Modules\Lesson\Services\LessonService;

final class ListLessonsController extends BaseApiV1Controller
{
    public function __construct(
        private readonly LessonService $lessonService
    ) {}

    public function __invoke(ListLessonsRequest $request): JsonResponse
    {
        try {

        } catch (Exception $e) {
            return $this->errorResponse(
                message: $e->getMessage(),
                statusCode: HttpStatusConstants::HTTP_500_INTERNAL_SERVER_ERROR
            );
        }
    }
}
