<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Student Management System API",
 *         description="API Documentation for Student Management System",
 *
 *         @OA\Contact(
 *             email="support@example.com",
 *             name="API Support"
 *         )
 *     ),
 *
 *     @OA\Server(
 *         url="/api/v1",
 *         description="API V1 Server"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;
}
