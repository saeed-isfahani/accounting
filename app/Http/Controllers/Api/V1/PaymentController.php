<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\Response;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use App\Repositories\PaymentRepository;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function __construct(
        public PaymentRepository $paymentRepository
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $payment = $this->paymentRepository->create($request->validated());

        return Response::data(['payment' => $payment])->message('payments.messages.payment_saved_successfully')->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }
}
