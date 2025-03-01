<?php

declare(strict_types=1);

namespace Modules\Student\Http\Controllers\Api\V1\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ListStudentsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['message' => 'Students!']);
    }
}
