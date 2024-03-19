<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\v1\UserResource;

class AuthController extends Controller
{

    use VerifiesEmails;

    public $successStatus = 200;
    /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Post(
     * path="/v1/login",
     * summary="Post a new data",
     * description="Post new University  data",
     * tags={"Auth"},
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass Auth   credentials",
     *    @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *       type="object",
     *       required={"email","password"},
     *       @OA\Property(property="email", type="email", format="text", example="user@gmail.com"),
     *       @OA\Property(property="password", type="password", format="password", example="123456789aawwee"),
     *    ),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid.")
     *        )
     *     ),
     *    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *            @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        $token = Auth::guard('jwt')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        $user = Auth::guard('jwt')->user();

        if($user->email_verified_at == NULL){
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        }
        return response()->json(['error'=>'Please Verify Your Email , We should know that it is really working email ! '], 401);
    }

        /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Post(
     * path="/v1/register",
     * summary="Post a new data",
     * description="Post new user data",
     * tags={"Auth"},
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass Auth   credentials",
     *    @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *       type="object",
     *       required={"username","fullname","email","password"},
     *       @OA\Property(property="username", type="text", format="text", example="Doe"),
     *       @OA\Property(property="fullname", type="text", format="",example="Surname First name"),
     *       @OA\Property(property="email", type="email", format="text", example="user@gmail.com"),
     *       @OA\Property(property="password", type="password", format="password", example="123456789aawwee"),
     *       @OA\Property(property="confirmation_password", type="password", format="password", example="123456789aawwee"),
     *    ),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid.")
     *        )
     *     ),
     *    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *            @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function register(Request $request){
        $request->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // $user->sendApiEmailVerificationNotification();

        // $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';

        // return response()->json(['success'=>$success],200);
        $token = Auth::guard('jwt')->login($user,true);

         return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => new UserResource($user),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }


            /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Post(
     * path="/v1/logout",
     * summary="Post a new data",
     * security={ {"jwt": {}} },
     * description="Logout  data",
     * tags={"Auth"},
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Logout ",
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid.")
     *        )
     *     ),
     *    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *            @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function logout()
    {
        Auth::guard('jwt')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }


                /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Post(
     * path="/v1/refresh",
     * summary="Refresh",
     * security={ {"jwt": {}} },
     * description="Refresh",
     * tags={"Auth"},
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Refrsh Current user ",
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid.")
     *        )
     *     ),
     *    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *            @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */


    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::guard('jwt')->user(),
            'authorisation' => [
                'token' => Auth::guard('jwt')->refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function details()
    {

    $user = Auth::user();

    return response()->json(['success' => $user], $this-> successStatus);

    }
}
