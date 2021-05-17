<?php

  

namespace App\Http\Controllers;

  

use Illuminate\Http\Request;
use Srmklive\PayPal\Facades\Paypal;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;  

class PayPalController extends Controller

{

    /**

     * Responds with a welcome message with instructions

     *

     * @return \Illuminate\Http\Response

     */

    public function payment(Request $request)

    {
        $user_auth = Auth::guard('user')->user();
        // dd($user_auth);
        $userId = $user_auth->id;
        $userName = $user_auth->name;
        $userEmail = $user_auth->email;
        $title = $request->input('Title');
        $amount = $request->input('Amount');
        $qty = $request->input('Qty');
        $desc = $request->input('Desc');
        $invoiceId = uniqid();
        $invoiceDesc = "Offer #{$invoiceId} Invoice";
        
        $insertedData = [
            'user_id'        => $userId,
            'user_name'      => $userName,
            'user_email'     => $userEmail,
            'offer_name'     => $title,
            'offer_amount'   => $amount,
            'offer_qty'      => $qty,
            'offer_desc'     => $desc,
            'invoice_id'     => $invoiceId,
            'invoice_desc'   => $invoiceDesc
        ];

        $id = DB::table('offer_payemnt_tbl')->insertGetId($insertedData);
        
        $data = [];
        $data['items'] = [
            [
                'name' => $title,
                'price' => $amount,
                'desc'  => $desc,
                'qty' => $qty
            ]
        ];
        $data['invoice_id'] = $invoiceId;
        $data['invoice_description'] = $invoiceDesc;
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');
        $data['total'] = $amount * $qty;
        
        // dd($data);
        $provider = new ExpressCheckout;
        $response = $provider->setExpressCheckout($data);
        $response = $provider->setExpressCheckout($data, true);
        // dd($response);
        return response()->json($response['paypal_link']);

    }

    

    /**

     * Responds with a welcome message with instructions

     *

     * @return \Illuminate\Http\Response

     */

    public function cancel()
    {
        dd('Your payment is canceled.');
    }

  

    /**

     * Responds with a welcome message with instructions

     *

     * @return \Illuminate\Http\Response

     */

    public function success(Request $request)

    {
        $offerData = DB::table('offer_payemnt_tbl')->orderBy('id', 'DESC')->first();
        
        $offerId = $offerData->id;
        $title = $offerData->offer_name;
        $amount = $offerData->offer_amount;
        $qty = $offerData->offer_qty;
        $desc = $offerData->offer_desc;
        $invoiceId = $offerData->invoice_id;
        $invoiceDesc = $offerData->invoice_desc;

        $data = [];
        $data['items'] = [
            [
                'name' => $title,
                'price' => $amount,
                'desc'  => $desc,
                'qty' => $qty
            ]
        ];
        $data['invoice_id'] = $invoiceId;
        $data['invoice_description'] = $invoiceDesc;
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');
        $data['total'] = $amount * $qty;
        // dd($data);
        $provider = new ExpressCheckout;
        $token = $request->get('token');
        $PayerID = $request->get('PayerID');
        $cart = $data;
        $response = $provider->getExpressCheckoutDetails($request->token);
        $payment_status = $provider->doExpressCheckoutPayment($cart, $token, $PayerID);
        // dd($cart);
        
        // echo"<pre>";
        // print_r($payment_status);die;
        
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            //dd('Your payment was successfully. You can create success page here.');
            $updateData = [
                'transaction_id'     => $payment_status['PAYMENTINFO_0_TRANSACTIONID'],
                'payment_status'     => $payment_status['PAYMENTINFO_0_PAYMENTSTATUS']
            ];
            //print_r($data);die;
            DB::table('offer_payemnt_tbl')
                    ->where('id', $offerId)
                    ->update($updateData);
            // dd($payment_status);        
            return  redirect('/quiz');        
        }
        dd('Something is wrong.');

    }

}