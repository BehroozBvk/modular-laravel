<?php

namespace Modules\StudentParent\Http\Controllers\Api\V1\StudentParent;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ListStudentParentsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['message' => 'Student Parents!']);
    }
}
