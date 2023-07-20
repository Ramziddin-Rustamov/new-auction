<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\ProductRequest;
use App\Http\Resources\API\V1\ProductResource;
use Exception;
use Illuminate\Http\Request;
use OpenApi\Examples\UsingRefs\ProductResponse;
use PhpParser\Node\Stmt\TryCatch;

class ProductController extends Controller
{

    public $error = [
        'message'=>'Not Found',
        'status'=>'error',
        'status_code'=>404
    ];
     
    /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/product",
     * summary="Return only fields ",
     * description="Get all data",
     * tags={"Product"},
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
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product  = Product::paginate(10);
        return ProductResource::collection($product);
    }


    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
    }

        /**
     *
     * @OA\Post(
     * path="/v1/product",
     * summary="Post a new data",
     * description="Post new user data",
     * tags={"Product"},
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
     *       @OA\Property(property="image", type="binary", format="binary", example="image"),
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

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, ProductRequest $productRequest)
    {
        $product =  Product::create($productRequest->validated());
        return new ProductResponse($product);
    }
    
           /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/product/{product}",
     * summary="Get one ",
     * description="Return all date related to  product id}",
     * tags={"Product"},
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


    /*
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
        $product = Product::find($product);
        if($product){
            return new ProductResource($product);
        }
        return $this->error;
    }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // 
    }

            /**
     *  @OA\Put (
     *      path="/v1/product/{id}",
     *      tags={"Product"},
     *      operationId="Update Product price of the product",
     *      summary="Update Product ",
     *      @OA\Parameter (description="bidding current update ",in="path",name="id",
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
    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $product,ProductRequest $productRequest)
    {
        $product = Product::find($product);
        if($product){
            $product->update($productRequest->validated());
            return new ProductResponse($product);
        }
        return $this->error;
    }

    /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Delete(
     * path="/v1/product/{product}",
     * summary="Get one and Delete related to product id",
     * description="Return  date related to ID of the Product",
     * tags={"Product"},
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
    /*
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        try{
        $product = Product::find($product);
        if($product){
            $product->delete();
            return response()->json([
                'message'=>'Deleted successfully !',
                 'status'=>200
            ]);
        }
        return $this->error;
        }catch(Exception $e){
            return response()->json([
                'message'=>'You can\'nt delete this ! '
            ]);
        }
    }
}
