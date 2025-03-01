<?php

namespace Modules\User\Http\Controllers\Api\V1\User;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ListUsersController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['message' => 'Users!']);
    }
}
