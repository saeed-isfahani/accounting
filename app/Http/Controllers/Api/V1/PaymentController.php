<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\Response;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use App\Repositories\PaymentRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\PaymentCollection;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct(
        public PaymentRepository $paymentRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PaginateRequest $request)
    {
        $payments = Payment::paginate($request->validated('per_page') ?? 5);

        return Response::message('payments.messages.payment_list_found_successfully')
            ->data(new PaymentCollection($payments))
            ->send();
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
     * Display the currencies list.
     */
    public function currencies()
    {
        $currencies = DB::table('payments')
            ->select(DB::raw('currency, SUM(amount) as sum_amount, (SUM(amount_in_rate) / SUM(amount)) as avg_rate'))
            ->groupBy('currency')
            ->get();

        return Response::message('currencies.messages.currency_list_found_successfully')
            ->data($currencies)
            ->send();
    }
}
