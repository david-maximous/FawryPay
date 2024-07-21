<?php

namespace DavidMaximous\Fawrypay\Classes;

use DavidMaximous\Fawrypay\Exceptions\MissingPaymentInfoException;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DavidMaximous\Fawrypay\Classes\BaseController;
use Illuminate\Support\Facades\Log;


class FawryPayment extends BaseController
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
     * @param $amount
     * @param null $user_id
     * @param null $user_name
     * @param null $user_email
     * @param null $user_phone
     * @param null $language
     * @param null $method
     * @param null $item
     * @param null $quantity
     * @param null $description
     * @param null $itemImage
     * @throws MissingPaymentInfoException
     */
    public function pay($amount = null, $user_id = null, $user_name = null, $user_email = null, $user_phone = null, $language = null, $method = null, $item = null, $quantity = null, $description = null, $itemImage = null): array
    {
        $this->setPassedVariablesToGlobal($amount, $user_id, $user_name, $user_email, $user_phone, $language, $method, $item, $quantity, $description, $itemImage);
        $required_fields = ['amount', 'user_id', 'user_name', 'user_email', 'user_phone'];
        $this->checkRequiredFields($required_fields);

        //Set defaults if not set
        $this->item ?? $this->item = '1';
        $this->quantity ?? $this->quantity = '1';
        $this->language ?? $this->language = 'en-gb';

        $this->amount = number_format($this->amount, 2, ".");
        $unique_id = uniqid();
        $returnUrl = route($this->verify_route_name);

        $secret = hash('sha256', $this->fawry_merchant . $unique_id . $this->user_id . $returnUrl . $this->item . $this->quantity . $this->amount . $this->fawry_secret);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->fawry_url.'fawrypay-api/api/payments/init', [
            'merchantCode' => $this->fawry_merchant,
            'merchantRefNum' => $unique_id,
            'customerMobile' => $this->user_phone,
            'customerEmail' => $this->user_email,
            'customerName' => $this->user_name,
            'customerProfileId' => $this->user_id,
            'language' => $this->language,
            'paymentMethod' => $this->method,
            'chargeItems' => [
                [
                    'itemId' => $this->item,
                    'description' => $this->description,
                    'price' => $this->amount,
                    'quantity' => $this->quantity,
                    'imageUrl' => $this->itemImage,
                ],
            ],
            'returnUrl' => $returnUrl,
            'authCaptureModePayment' => false,
            'signature' => $secret,
        ]);

        return [
            'payment_id' => $unique_id,
            'redirect_url'=> $response->body(),
        ];
    }
}
