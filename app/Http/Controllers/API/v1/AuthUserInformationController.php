<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\v1\AuthUserInformationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\v1\ProductRequest;
use App\Models\Product as ModelsProduct;
use App\Product;

class AuthUserInformationController extends Controller
{
    private $user;
   public function __construct()
    {
        $this->user = Auth::guard('jwt')->user();
    }

    /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/user/products",
     * summary="Return all fields ",
     * description="Get all data",
     * tags={"Active User Products"},
     * security={{"jwt": {}}},
     *       @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *           @OA\MediaType(
     *             mediaType="application/json",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     * )
     *
     */

     public function index()
     {
         $products = ModelsProduct::where('user_id', $this->user->id)->get();
         if ($products->isEmpty()) {
             return response()->json(['message' => 'There are no products found for this user'], 404);
         }
     
         return AuthUserInformationResource::collection($products);
    }


               /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/user/products/{product}",
     * summary="Get one ",
     * description="Return all date related to  product id}",
     * tags={"Active User Products"},
     * security={{"jwt": {}}},
     *  @OA\Parameter(name="product", in="path", description="ID", required=true,
     *        @OA\Schema(type="integer")
     *    ),
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




    public function show($id)
    {
        $product = ModelsProduct::where('user_id', $this->user->id)->find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return new AuthUserInformationResource($product);
    }


        /**
     *
     * @OA\Post(
     * path="/v1/user/products",
     * summary="Post a new data",
     * description="Post new user data",
     * tags={"Active User Products"},
     * security={{"jwt": {}}},
     *
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass Product   credentials",
     *    @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *       type="object",
     *       required={"user_id","name","image","bidmargin","description",},
     *       @OA\Property(property="user_id", type="number", format="text", example="1"),
     *       @OA\Property(property="name", type="text", format="text",example="Product name "),
     *       @OA\Property(property="image", type="string", format="binary", example="image"),
     *       @OA\Property(property="bidmargin", type="text", format="text", example="$8000"),
     *       @OA\Property(property="description", type="text", format="text", example="This is a product description !")
     *      )
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

    public function store(ProductRequest $request)
    {
        $request->validate([
            'name' => ['required'],
            'image' => ['required', 'mimes:png,jpg,jpeg'],
            'bidmargin' => ['required'],
            'description' => ['required']
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $product = new ModelsProduct([
            'user_id' => $this->user->id,
            'name' => $request->input('name'),
            'image' => $imagePath ?? null,
            'bidmargin' => $request->input('bidmargin'),
            'description' => $request->input('description'),
        ]);

        $product->save();

        return new AuthUserInformationResource($product);
    }



            /**
     *  @OA\Put (
     *      path="/v1/user/products/{product}",
     *      tags={"Active User Products"},
     *      security={{"jwt": {}}},
     *      operationId="Updat",
     *      summary="Update Product ",
     *      @OA\Parameter (description="bidding current update ",in="path",name="product",
     *      required=true,example="1",
     *       @OA\Schema(type="integer")),
     *      description="Returns updated Bid",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Update product",
     *          @OA\JsonContent(
     *          required={"user_id","product_id","price"},
     *        @OA\Property(property="user_id", type="number", format="text", example="1"),
     *       @OA\Property(property="name", type="text", format="text",example="Product name "),
     *       @OA\Property(property="image", type="binary", format="binary", example="image"),
     *       @OA\Property(property="bidmargin", type="text", format="text", example="$8000"),
     *       @OA\Property(property="description", type="text", format="text", example="This is a product description !")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="message", type="string", example="Bid Updated successfully"),
     *          ),
     *      ),

     * )
     *
     */



    public function update(ProductRequest $request, $id)
    {
        $product = ModelsProduct::where('user_id', $this->user->id)->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'name' => ['required'],
            'image' => ['sometimes', 'required', 'mimes:png,jpg,jpeg'],
            'bidmargin' => ['required'],
            'description' => ['required']
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $product->update([
            'name' => $request->input('name'),
            'image' => $imagePath ?? $product->image,
            'bidmargin' => $request->input('bidmargin'),
            'description' => $request->input('description'),
        ]);

        return new AuthUserInformationResource($product);
    }


    /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Delete(
     * path="/v1/user/product/{product}",
     * summary="Get one and Delete related to product id",
     * description="Return  date related to ID of the Product",
     * tags={"Active User Products"},
     * security={{"jwt": {}}},
     *
     * *@OA\Parameter(name="product", in="path", description="put product id and try to delete ", required=true,
     *       @OA\Schema(type="integer")
     *  ),
     *   @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */


    public function destroy($id)
    {
        $product = ModelsProduct::where('user_id', $this->user->id)->find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
