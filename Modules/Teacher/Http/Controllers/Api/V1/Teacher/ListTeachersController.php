<?php

namespace Modules\Teacher\Http\Controllers\Api\V1\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

final class ListTeachersController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['message' => 'Teachers!']);
    }
}
