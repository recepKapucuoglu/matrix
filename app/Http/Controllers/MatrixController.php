<?php

namespace App\Http\Controllers;

use App\Repositories\MatrixRepository;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

/**
 * Class MatrixController
 * @package App\Http\Controllers
 *
 * @OA\Info(
 *     title="Matrix API For Map Elektronik Ticaret ve Veri Hizmetleri A.Ş.",
 *     version="1.0",
 *     description="API documentation for the Matrix application.",
 *     @OA\Contact(
 *         email="recepkapucuoglu@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Recep Kapucuoğlu",
 *         url="https://github.com/recepKapucuoglu"
 *     )
 * )
 */

class MatrixController extends Controller
{

    use ApiResponser;
    private MatrixRepository $matrixRepository;
    public function __construct(MatrixRepository $matrixRepository)
    {
        $this->matrixRepository = $matrixRepository;
    }
   /**
 * @OA\Post(
 *     path="/api/layout/create",
 *     tags={"Matrix"},
 *     summary="Create layout",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="input", type="object",
 *                     @OA\Property(property="xParameter", type="integer", description="The value for xParameter", minimum=1),
 *                     @OA\Property(property="yParameter", type="integer", description="The value for yParameter", minimum=1),
 *                 ),
 *                 example={"xParameter": 3, "yParameter": 4}
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Layout created successfully"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error"
 *     )
 * )
 */

    function createLayout(Request $request)
    {
        $data = $request->only('xParameter', 'yParameter');
        $validator = Validator::make($data, [
            'xParameter' => 'required',
            'yParameter' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $result = $this->matrixRepository->createLayout($request->xParameter, $request->yParameter);
        if ($result) {
            return $this->successResponse($result, Response::HTTP_CREATED);
        }
        return $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR);


    }
    /**
 * @OA\Get(
 *     path="/api/layout/getall",
 *     tags={"Matrix"},
 *     summary="Get all layout list",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="OK"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer"),
 *                     @OA\Property(property="created_at", type="string"),
 *  *                     @OA\Property(property="updated_at", type="string"),
 *                     @OA\Property(
 *                         property="layoutTable",
 *                         type="array",
 *                         @OA\Items(type="string")
 *                     ),
 *                 ),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Layouts not found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Not Found"),
 *         ),
 *     ),
 * )
 *
 * @return mixed
 */
public function getAllListLayout()
{
    $result = $this->matrixRepository->getAllListLayout();
    if ($result) {
        return $this->successResponse($result, Response::HTTP_OK);
    }
    return $this->errorResponse(Response::HTTP_NOT_FOUND);
}
/**
 * @OA\Post(
 *     path="/api/layout/get-value",
 *     tags={"Matrix"},
 *     summary="Get layout coordinate value",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 @OA\Property(property="x", type="integer", format="int32", description="The value for x", example=1),
 *                 @OA\Property(property="y", type="integer", format="int32", description="The value for y", example=2),
 *                 @OA\Property(property="layoutId", type="integer", format="int32", description="The layout ID", example=3),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="OK"),
 *             @OA\Property(property="data", type="array", @OA\Items(type="string")),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Layout value not found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Not Found"),
 *         ),
 *     ),
 * )
 *
 * @param Request $request
 * @return mixed
 */
public function getLayoutValue(Request $request)
{
    $data = $request->only('x', 'y','layoutId');
    $validator = Validator::make($data, [
        'x' => 'required',
        'y' => 'required',
        'layoutId'=> 'required'
    ]);
    if ($validator->fails()) {
        return $this->errorResponse($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    $result = $this->matrixRepository->getLayoutValue($request->input('x'), $request->input('y'), $request->input('layoutId'));
    if ($result) {
        return $this->successResponse($result, Response::HTTP_OK);
    }
    return $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
}

}
