<?php

namespace Modules\StudentParent\Http\Controllers\Api\V1\StudentParent;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ListStudentParentsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['message' => 'Student Parents!']);
    }
}
