<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
        /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Auction",
     *      description="Documentation Auction web ",
     *      @OA\Contact(
     *          email="rustamovvramziddin@gmail.com"
     *      ),
     * ),
     *
     * * @OA\SecurityScheme(
     *     type="http",
     *     description="Login with email and password to get the authentication token",
     *     name="Token based Based",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="jwt",
     *     securityScheme="jwt",
     * ),
     *
     *
     *  @OA\Tags(
     *  name="Auth",
     *  description="This is a Auth docs",
     * ),
     * *  @OA\Tags(
     *  name="Bidding-History",
     *  description="This is bidding history model ",
     * ),
     *   @OA\Tags(
     *  name="Current-Bid",
     *  description="This is Current Bid model ",
     * ),
     *  @OA\Tags(
     *  name="Products",
     *  description="This is Product model ",
     * ),
     *  @OA\Tags(
     *  name="Active User Products",
     *  description="This is Product model ",
     * ),
     *
     */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
