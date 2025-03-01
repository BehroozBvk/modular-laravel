<?php

namespace Modules\Admin\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ListAdminsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['message' => 'Admins!']);
    }
}
