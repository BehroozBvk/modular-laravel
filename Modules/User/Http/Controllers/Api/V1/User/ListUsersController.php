<?php

namespace Modules\User\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ListUsersController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['message' => 'Users!']);
    }
}
