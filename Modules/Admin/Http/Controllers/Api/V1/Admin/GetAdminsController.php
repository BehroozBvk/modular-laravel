<?php

namespace Modules\Admin\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class GetAdminsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['message' => 'Admins!']);
    }
}
