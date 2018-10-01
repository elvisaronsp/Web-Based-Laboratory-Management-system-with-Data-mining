<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaymentController extends Controller
{
    public function __construct()
    {

        /** PayPal api context **/
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );

        $settings = array(
            'mode' => 'sandbox',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path() . '/logs/paypal.log',
            'log.LogLevel' => 'ERROR'
        );
        $this->_api_context->setConfig($settings);

    }

    public function payWithpaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Item 1') /** item name **/
        ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->amount); /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->amount);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('This will transfer to MediLab');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('paymentStatus')) /** Specify return URL **/
        ->setCancelUrl(route('paymentStatus'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return redirect()->route('home');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return redirect()->route('home');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        Session::put('error', 'Unknown error occurred');
        return redirect()->route('home');
    }
//    public function callPayments(Request $request)
//    {
//
//
//        $payer = new Payer();
//        $payer->setPaymentMethod('paypal');
//
//        $item_1 = new Item();
//
//        $item_1->setName('Lab Report Payment') /** item name **/
//            ->setCurrency('USD')
//            ->setQuantity(1)
//            ->setPrice(1); /** unit price **/
//
//        $item_list = new ItemList();
//        $item_list->setItems(array($item_1));
//
//        $amount = new Amount();
//        $amount->setCurrency('USD')
//            ->setTotal(1);
//
//        $transaction = new Transaction();
//        $transaction->setAmount(1)
//            ->setItemList($item_list)
//            ->setDescription('This will transfer to MediLab');
//
//        $redirect_urls = new RedirectUrls();
//        $redirect_urls->setReturnUrl( route('paymentStatus')) /** , ['milestone_id'=>$request->milestone_id] Specify return URL **/
//        ->setCancelUrl( route('paymentStatus') );
//
//        $payment = new Payment();
//        $payment->setIntent('Sale')
//            ->setPayer($payer)
//            ->setRedirectUrls($redirect_urls)
//            ->setTransactions(array($transaction));
//
//        try {
//
//            $payment->create($this->_api_context);
//            Log::info('before');
//        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
//
//            if (Config::get('app.debug')) {
//                Log::info($ex);
//                Session::put('error', 'Connection timeout');
//                return redirect()->route('home');
//
//            } else {
//
//                Session::put('error', 'Some error occur, sorry for inconvenient');
//                return redirect()->route('home');
//            }
//
//        }
//
//        foreach ($payment->getLinks() as $link) {
//
//            if ($link->getRel() == 'approval_url') {
//
//                $redirect_url = $link->getHref();
//                break;
//            }
//
//        }
//
//        /** add payment ID to session **/
//        Session::put('paypal_payment_id', $payment->getId());
//
//        if (isset($redirect_url)) {
//
//            /** redirect to paypal **/
//            return Redirect::away($redirect_url);
//
//        }
//
//        Session::put('error', 'Unknown error occurred');
//        return redirect()->route('home');
//
//    }

    /**
     * method to return payment status report
     * @return mixed
     */
    public function getStatusReport(Request $request)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {

            Session::put('error', 'Payment failed');
            return redirect()->route('home');

        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {

            Session::put('success', 'Payment success');

//            DB::table('milestones')
//                ->where('milestone_id', $request->milestone_id)
//                ->update(['payment_status' => 1]);

            return back();
        }

        Session::put('error', 'Payment failed');
        return redirect()->route('home');
    }

}
