<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\v1\UserResource;

class AuthController extends Controller
{

    protected  $guard = 'jwt';
    
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

        $token = Auth::guard($this->guard)->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::guard($this->guard)->user();
        return response()->json([
                'status' => 'success',
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

        $token = Auth::guard($this->guard)->login($user,true);

        //   $user->sendEmailVerificationNotification();

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
        Auth::guard($this->guard)->logout();
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
            'user' => Auth::guard($this->guard)->user(),
            'authorisation' => [
                'token' => Auth::guard($this->guard)->refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
