<?php

declare(strict_types=1);

namespace Modules\Country\Http\Controllers\Api\V1\Country;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ListCountriesController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['message' => 'Hello, World!']);
    }
}
