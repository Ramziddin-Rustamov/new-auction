<?php

namespace App\Http\Controllers\API\v1;

use App\Models\CurrentBid;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\CurrentBidRequest;
use App\Http\Resources\API\V1\CurrentBidResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrentBidController extends Controller
{
    public $error = [
        'message'=>'Not Found',
        'status'=>'error',
        'status_code'=>404
    ];

    private $user;

    public function __construct()
    {
        $this->user = Auth::guard('jwt')->user();
    }
    
    /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/current-bid",
     * summary="Return only fields ",
     * description="Get all data",
     * tags={"Current-Bid"},
     * security={{"jwt": {}}},
     * 
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
        $currentBid = CurrentBid::where('user_id', $this->user->id)->all();
        return CurrentBidResource::collection($currentBid);
    }
        
    /**
     *
     * @OA\Post(
     * path="/v1/current-bid",
     * summary="Post a new data",
     * description="Post new user data",
     * tags={"Current-Bid"},
     * security={{"jwt": {}}},
     * 
     * 
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass CurrentBid   credentials",
     *    @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *       type="object",
     *       required={"user_id","product_id","price"},
     *       @OA\Property(property="user_id", type="number", format="text", example="1"),
     *       @OA\Property(property="product_id", type="number", format="",example="1"),
     *       @OA\Property(property="price", type="text", format="text", example="$12000")
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
    public function store(Request $request, CurrentBidRequest $currentBidRequest)
    {
        $currentBidRequest->validated();
        $currentBidRequest['user_id'] = $this->user->id;
        $bid = CurrentBid::create($currentBidRequest->all());
        return new CurrentBidResource($bid);
    }

    /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/current-bid/{current-bid}",
     * summary="Get one ",
     * description="Return all date related to ID{bid id}",
     * tags={"Current-Bid"},
     * security={{"jwt": {}}},
     * 
     *  @OA\Parameter(name="current-bid", in="path", description="ID", required=true,
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
    public function show($CurrentBid)
    {
        $CurrentBid = CurrentBid::where('user_id', $this->user->id)->find($CurrentBid);
        if($CurrentBid){
            return new CurrentBidResource($CurrentBid);
        }
        return $this->error;
    }



        /**
     *  @OA\Put (
     *      path="/v1/current-bid/{id}",
     *      tags={"Current-Bid"},
     *      operationId="Update current-bid price of the product",
     *      summary="Update current-bid ",
     *      security={{"jwt": {}}},
     *      @OA\Parameter (description="bidding current update ",in="path",name="id",
     *      required=true,example="1", 
     *       @OA\Schema(type="integer")),
     *      description="Returns updated Bid",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Update bid History",
     *          @OA\JsonContent(
     *          required={"user_id","product_id","price"},
     *          @OA\Property(property="user_id", type="number", format="text", example="5"),
     *          @OA\Property(property="product_id", type="number", format="text", example="4"),
     *          @OA\Property(property="price", type="string", format="text",example="$4000"),
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
     * @param  \App\Models\CurrentBid  $CurrentBid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $CurrentBid , CurrentBidRequest $currentBidRequest)
    {
        $currentBid = CurrentBid::where('user_id', $this->user->id)->find($CurrentBid);
        if($currentBid){
            $currentBid->update($currentBidRequest->validated());
            return new CurrentBidResource($currentBid);
        }
        return $this->error;
    }

               /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Delete(
     * path="/v1/current-bid/{current-bid}",
     * summary="Get one and Delete related to Bid id",
     * description="Return  date related to ID of the Bid",
     * tags={"Current-Bid"},
     * security={{"jwt": {}}},
     * 
     *  
     * *@OA\Parameter(name="current-bid", in="path", description="put bid id and try to delete ", required=true,
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
     * @param  \App\Models\CurrentBid  $CurrentBid
     * @return \Illuminate\Http\Response
     */
    public function destroy($CurrentBid)
    {
        try{
            $currentBid = CurrentBid::where('id', $this->user->id)->find($CurrentBid);
            if($currentBid){
                $currentBid->delete();
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
