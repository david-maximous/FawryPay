<?php

namespace DavidMaximous\Fawrypay\Classes;

use DavidMaximous\Fawrypay\Exceptions\MissingPaymentInfoException;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DavidMaximous\Fawrypay\Classes\BaseController;
use Illuminate\Support\Facades\Log;


class FawryVerify extends BaseController
{
    public $fawry_url;
    public $fawry_secret;
    public $fawry_merchant;
    public $verify_route_name;


    public function __construct()
    {
        $this->fawry_url = config('fawrypay.FAWRY_URL');
        $this->fawry_merchant = config('fawrypay.FAWRY_MERCHANT');
        $this->fawry_secret = config('fawrypay.FAWRY_SECRET');
        $this->verify_route_name = config('fawrypay.VERIFY_ROUTE_NAME');
    }

    /**
     * @param Request $request
     * @return array|void
     */
    public function verify(Request $request)
    {
        $reference_id = $request->offsetGet('merchantRefNumber');
        if($request->offsetGet('statusCode') == 200)
        {
            $hash = hash('sha256', $request->offsetGet('referenceNumber') . $request->offsetGet('merchantRefNumber') . number_format($request->offsetGet('paymentAmount'), 2, ".") . number_format($request->offsetGet('orderAmount'), 2, ".") . $request->offsetGet('orderStatus') . $request->offsetGet('paymentMethod') . number_format($request->offsetGet('fawryFees'), 2, ".") . $request->offsetGet('authNumber') . $request->offsetGet('customerMail') . $request->offsetGet('customerMobile') . $this->fawry_secret);
            if($hash == $request->offsetGet('signature'))
            {
                $status = $this->getPaymentStatus($reference_id);
                if($status['status'] == 'PAID')
                {
                    return [
                        'success' => true,
                        'payment_id'=>$reference_id,
                        'message' => __('fawrypay::messages.PAYMENT_SUCCESS'),
                        'process_data' => $status['process_data']
                    ];
                }
                else $this->failedResponse($reference_id, $status['status'], $status['process_data']);
            }
            else $this->securityResponse($reference_id, $request->all());
        }
        else $this->failedResponse($reference_id, $request->offsetGet('statusCode'), $request->all());
    }

    public function getPaymentStatus($reference_id)
    {
        $hash = hash('sha256', $this->fawry_merchant . $reference_id . $this->fawry_secret);
        $response = Http::get($this->fawry_url . 'ECommerceWeb/Fawry/payments/status/v2?merchantCode=' . $this->fawry_merchant . '&merchantRefNumber=' . $reference_id . '&signature=' . $hash)->json();
        $status = $response['orderStatus'] ?? $response['statusCode'];

        return [
            'status' => $status,
            'process_data' => $response,
        ];
    }

    public function securityResponse($reference_id, $process_data)
    {
        return [
            'success' => false,
            'payment_id'=>$reference_id,
            'message' => __('fawrypay::messages.Security_checks_are_not_passed_by_the_system'),
            'process_data' => $process_data
        ];
    }

    public function failedResponse($reference_id, $code, $process_data)
    {
        return [
            'success' => false,
            'payment_id'=>$reference_id,
            'message' => __('fawrypay::messages.PAYMENT_FAILED_WITH_CODE', ['CODE' => $code]),
            'process_data' => $process_data
        ];
    }
}
