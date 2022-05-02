<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 *  @OA\Info(
 *     version="1.0.0",
 *     title="Weather API Application",
 *     description="Weather API Application",
 *     @OA\Contact(
 *         email="savicsly@gmail.com",
 *         name="Victor Bala",
 *         url="http://www.github.com/savicsly"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     ),
 *     @OA\Server(
 *         description="Weather API Application",
 *         url=L5_SWAGGER_CONST_HOST
 *     ),
 *  )
 */

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
