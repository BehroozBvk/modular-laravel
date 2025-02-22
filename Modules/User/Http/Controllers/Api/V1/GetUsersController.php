<?php

namespace Modules\User\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class GetUsersController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['message' => 'Users!']);
    }
}
