<?php

namespace App\Http\Controllers\API\v1;

use App\Models\BiddingHistory;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\BiddingHistoryRequest;
use App\Http\Resources\API\V1\BiddingHistoryResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiddingHistoryController extends Controller
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
     * path="/v1/bidding-history",
     * summary="Return only fields ",
     * description="Get all data",
     * tags={"Bidding-History"},
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
    public function index()
    {
        $biddingHistory = BiddingHistory::where('user_id',$this->user->id)->with('product')->paginate(10);
        return BiddingHistoryResource::collection($biddingHistory);
    }


    /**
     *
     * @OA\Post(
     * path="/v1/bidding-history",
     * summary="Post a new data",
     * description="Post new user data",
     * tags={"Bidding-History"},
     * security={{"jwt": {}}},
     * 
     * 
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass Bid history   credentials",
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

    public function store(BiddingHistoryRequest $biddingHistoryRequest)
    {
        $data = $biddingHistoryRequest->validated();
        $data['user_id'] = $this->user->id;
        $biddingHistory = BiddingHistory::create($data);
        return new BiddingHistoryResource($biddingHistory);
    }

       /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/bidding-history/{bidding-history}",
     * summary="Get one ",
     * description="Return all date related to ID{bid id}",
     * tags={"Bidding-History"},
     * security={{"jwt": {}}},
     * 
     *  @OA\Parameter(name="bidding-history", in="path", description="ID", required=true,
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

    public function show($biddingHistory)
    {
        $bid = BiddingHistory::where('user_id',$this->user->id)->with('product')->find($biddingHistory);
        if($bid){
            return new BiddingHistoryResource($bid);
        }
        return $this->error;
    }

    /**
     *  @OA\Put (
     *      path="/v1/bidding-history/{id}",
     *      tags={"Bidding-History"},
     *      security={{"jwt": {}}},
     *      operationId="Update",
     *      summary="Update ",
     *      @OA\Parameter (description="bidding history update ",in="path",name="id",
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
    public function update(Request $request,  $biddingHistory, BiddingHistoryRequest $biddingHistoryRequest)
    {
        $updated = BiddingHistory::where('user_id',$this->user->id)->with('product')->find($biddingHistory);
        if($updated){
        if($biddingHistoryRequest->validated()){
            $updated->user_id = $request->user_id;
            $updated->product_id = $request->product_id;
            $updated->price = $request->price;
            $updated->save();
            return new BiddingHistoryResource($updated);
            }
            return response()->json([
                'message'=>'Validation error'
            ]);
        }
        return $this->error;
    }

     /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Delete(
     * path="/v1/bidding-history/{bidding-history}",
     * summary="Get one and Delete related to Bid id",
     * description="Return  date related to ID of the Bid",
     * tags={"Bidding-History"},
     * security={{"jwt": {}}},
     * 
     * 
     * *@OA\Parameter(name="bidding-history", in="path", description="put bid id and try to delete ", required=true,
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
    public function destroy($biddingHistory)
    {
      try{
        $delete = BiddingHistory::where('user_id',$this->user->id)->with('product')->find($biddingHistory);
        if($delete){
            $delete->delete();
            return response()->json([
                'message'=>'Deleted successfully',
                'status'=>200
            ]);
        }
        return $this->error;
      }catch(Exception $e){
        return response()->json(
            [
                'message'=>'you can not delete this ! '
            ]
        );
      }
    }
}
