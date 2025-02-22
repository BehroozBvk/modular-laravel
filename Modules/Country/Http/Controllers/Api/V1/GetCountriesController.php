<?php

declare(strict_types=1);

declare(strict_types=1);

namespace Modules\Country\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class GetCountriesController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['message' => 'Hello, World!']);
    }
}
