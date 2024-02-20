<?php

namespace App\Contracts\Repositories;

use App\Http\Requests\PaginateRequest;
use App\Http\Requests\StorePaymentRequest;

interface PaymentControllerInterface
{
    /**
     * Get a list of payments which details
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/v1/payments",
     *     operationId="paymentsList",
     *     tags={"Payments"},
     *     summary="Payments list",
     *     description="Get payments list with details",
     *      @OA\Response(response=200,description="Successful operation"),
     *      @OA\Response(response=404,description="Resource not found")
     * )
     */
    public function index(PaginateRequest $request);

    /**
     * Store payment
     *
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *     path="/api/v1/payments",
     *     operationId="storePayment",
     *     tags={"Payments"},
     *     summary="ContactUs",
     *     description="store payment",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *                  type="object",
     *                  required={"currency","amount","rate"},
     *                  @OA\Property(property="currency", type="text"),
     *                  @OA\Property(property="amount", type="text"),
     *                  @OA\Property(property="rate", type="text"),
     *            ),
     *        ),
     *    ),
     *
     *      @OA\Response(response=201,description="Successful operation"),
     *      @OA\Response(response=422,description="Unprocessable Content"),
     *      @OA\Response(response=404,description="Resource Not Found")
     * )
     */
    public function store(StorePaymentRequest $request);

    /**
     * Get a list of currencies which details and avg
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/v1/currencies",
     *     operationId="currenciesList",
     *     tags={"Currencies"},
     *     summary="currencies list",
     *     description="Get currencies list with details",
     *      @OA\Response(response=200,description="Successful operation"),
     *      @OA\Response(response=404,description="Resource not found")
     * )
     */
    public function currencies();
}
