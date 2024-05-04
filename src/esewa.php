<?php

namespace Nujan\Esewa;

use Illuminate\Support\Facades\Http;

class esewa
{
    protected $merchantCode;
    protected $secretKey;
    protected $apiEndpoint;

    public function __construct()
    {
        $this->merchantCode = config('esewa.merchant_code');
        $this->secretKey = config('esewa.secret_key');
        $this->apiEndpoint = config('esewa.api_endpoint');
    }

    public function generateSignature($data)
    {
        // Prepare the string using the required parameters in the correct order
        $dataString = "total_amount={$data['total_amount']},transaction_uuid={$data['transaction_uuid']},product_code={$data['product_code']}";

        // Generate the HMAC signature
        $hash = hash_hmac('sha256', $dataString, $this->secretKey, true);

        // Convert the hash to base64
        $signature = base64_encode($hash);

        return $signature;
    }

    public function sendPaymentRequest($data)
    {
        // Generate the signature
        $signature = $this->generateSignature($data);

        // Add the signature to the data
        $data['signature'] = $signature;

        // Create the form
        $form = '<form id="esewa_form" action="' . $this->apiEndpoint . '/main/v2/form" method="post">';

        foreach ($data as $key => $value) {
            $form .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
        }

        $form .= '</form>';

        // Add JavaScript to auto-submit the form
        $form .= '<script type="text/javascript">document.getElementById("esewa_form").submit();</script>';

        // Return the form
        return response($form);
    }

    public function verifyTransaction($transactionId)
    {
        $decodeData = json_decode(base64_decode($transactionId), true);

        $data = [
            'product_code' => $decodeData['product_code'],
            'total_amount' => $decodeData['total_amount'],
            'transaction_uuid' => $decodeData['transaction_uuid'],
        ];

        // Send a GET request to the eSewa API endpoint to verify the transaction
        $response = Http::get($this->apiEndpoint . '/transaction/status', $data);


        return $response->json();
    }
}
