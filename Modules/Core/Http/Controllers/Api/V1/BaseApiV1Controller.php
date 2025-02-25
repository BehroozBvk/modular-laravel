<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers\Api\V1;

use OpenApi\Annotations as OA;
use Modules\Core\Http\Controllers\Api\BaseApiController;

/**
 * @OA\Tag(
 *     name="API V1",
 *     description="API Version 1 Endpoints"
 * )
 */
abstract class BaseApiV1Controller extends BaseApiController {}
