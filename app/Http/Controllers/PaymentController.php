<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Requests\AddPaymentRequest;
use Illuminate\Support\Facades\DB;
use App\Traits\MediaUploader;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    use MediaUploader;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AddPaymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddPaymentRequest $request)
    {
        $this->authorize('create', Payment::class);
        $request->merge(['created_by' => Auth::id()]);
        $current = Payment::create($request->all());
        $media = $this->payment($request);
        if(!!$media && $media->save()) {
            $this->attach($current::class, $current->id, $media);
        }
        return response()->json(
            [
                'status' => 'success',
                'current' => Payment::with('attachments')->find($current->id)
            ], 200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $obj
     * @return \Illuminate\Http\Response
     */
    public function show($obj, $id)
    {
        $this->authorize('view', Payment::class);
        $object = sprintf('App\Models\%s', $obj);
        $allPayments = Payment::with('attachments')->where('payer_id', $id)->where('payer_type', $object)->get();
        return response()->json(
            [
                'status' => 'success',
                'payments' => $allPayments
            ], 200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $this->authorize('delete', $payment);
        Payment::destroy($payment->id);
        return response()->json(
            ['status' => 'success', 'deleted' => $payment->id ], 200
        );
    }
}
