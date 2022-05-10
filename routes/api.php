<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/










Route::post('/payu-payment-test', function (Request $request) {
    $month = (((int) $request->month) < 10) ? '0' . $request->month : $request->month;
    $data = [
        "credit_card_number" => (int)$request->credit_card_number,
        "date" => $request->years1 . $request->years2 . $request->years3 . $request->years4 . '/' . $month,
        "credit_card_security_code" => (int)$request->credit_card_security_code,
        "payment_method" => $request->payment_method ?? "VISA"
    ];


    if ($data["credit_card_number"] == 0) return $data["error"] = "el numero de la tarjeta de credito no puede ser 0";
    if ($data["credit_card_security_code"] == 0) return $data["error"] = "el numero de seguridad no puede ser 0";

    try {
        PayU::$apiKey = env('PAYU_API_KEY'); // Enter your API key here
        PayU::$apiLogin = env('PAYU_API_LOGIN'); // Enter your API Login here
        PayU::$merchantId = env('PAYU_MERCANT_ID'); // Enter your Merchant Id here
        PayU::$language = SupportedLanguages::ES; // Enter the language here
        PayU::$isTest = true; // assign true if you are in test mode



        Environment::setPaymentsCustomUrl("https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi");
        // Reports URL
        Environment::setReportsCustomUrl("https://sandbox.api.payulatam.com/reports-api/4.0/service.cgi");



        $reference = 'payment_test_' . strtotime("now");
        // $reference = "payment_test_00000431";
        $value = 3746.50;

        $parameters = array(
            // Enter the account’s identifier here
            PayUParameters::ACCOUNT_ID => env('PAYU_ACCOUNT_ID'),
            // Enter the reference code here.
            PayUParameters::REFERENCE_CODE => $reference,
            // Enter the description here.
            PayUParameters::DESCRIPTION => "payment test",

            // -- Values --
            // Enter the value here.
            PayUParameters::VALUE => $value,
            // Enter the value of the IVA (Value Added Tax only valid for Colombia) of the transaction,
            // if no IVA is sent, the system applies 19% automatically. It can contain two decimal digits.
            // Example 19000.00. In case you don't have IVA, set 0.
            PayUParameters::TAX_VALUE => "0",
            // Enter the value of the base value on which VAT (only valid for Colombia) is calculated.
            // In case you don't have IVA, set 0.
            PayUParameters::TAX_RETURN_BASE => "0",
            // Enter the currency here.
            PayUParameters::CURRENCY => "COP",

            // -- Buyer --
            // Enter the buyer Id here.
            PayUParameters::BUYER_ID => "1",
            // Enter the buyer's name here.
            PayUParameters::BUYER_NAME => "Test comprador Persona",
            // Enter the buyer's e-mail here.
            PayUParameters::BUYER_EMAIL => "buyer_test@test.com",
            // Enter the buyer's contact phone here.
            PayUParameters::BUYER_CONTACT_PHONE => "1111111",
            // Enter the buyer's contact document here.
            PayUParameters::BUYER_DNI => "1111111111111",
            // Enter the buyer's address here.
            PayUParameters::BUYER_STREET => "Cr 23 No. 53-50",
            PayUParameters::BUYER_STREET_2 => "5555487",
            PayUParameters::BUYER_CITY => "BOGOTÁ",
            PayUParameters::BUYER_STATE => "Bogotá D.C",
            PayUParameters::BUYER_COUNTRY => "CO",
            PayUParameters::BUYER_POSTAL_CODE => "000000",
            PayUParameters::BUYER_PHONE => "1111111",


            // -- Payer --
            // Enter the payer's ID here.
            PayUParameters::PAYER_ID => "1",
            /// Enter the payer's name here
            PayUParameters::PAYER_NAME => "Test pagar Persona",
            // Enter the payer's e-mail here
            PayUParameters::PAYER_EMAIL => "payer_test@test.com",
            // Enter the payer's contact phone here.
            PayUParameters::PAYER_CONTACT_PHONE => "7563126",
            // Enter the payer's contact document here.
            PayUParameters::PAYER_DNI => "5415668464654",
            // Enter the payer's address here.
            PayUParameters::PAYER_STREET => "Cr 23 No. 53-50",
            PayUParameters::PAYER_STREET_2 => "5555487",
            PayUParameters::PAYER_CITY => "BOGOTÁ",
            PayUParameters::PAYER_STATE => "Bogotá D.C",
            PayUParameters::PAYER_COUNTRY => "CO",
            PayUParameters::PAYER_POSTAL_CODE => "000000",
            PayUParameters::PAYER_PHONE => "7563126",

            // -- Credit card data --
            // Enter the number of the credit card here
            PayUParameters::CREDIT_CARD_NUMBER => $data["credit_card_number"],
            // Enter expiration date of the credit card here
            PayUParameters::CREDIT_CARD_EXPIRATION_DATE => $data["date"],
            // Enter the security code of the credit card here
            PayUParameters::CREDIT_CARD_SECURITY_CODE => $data["credit_card_security_code"],
            // Enter the name of the credit card here
            PayUParameters::PAYMENT_METHOD => $data["payment_method"],



            // Enter the number of installments here.
            PayUParameters::INSTALLMENTS_NUMBER => "1",
            // Enter the name of the country here.
            PayUParameters::COUNTRY => PayUCountries::CO,

            // Device Session ID
            //PayUParameters::DEVICE_SESSION_ID => "vghs6tvkcle931686k1900o6e1",
            // Payer IP
            //  PayUParameters::IP_ADDRESS => "127.0.0.1",
            // Cookie of the current session
            // PayUParameters::PAYER_COOKIE => "pt1t38347bs6jc9ruv2ecpv7o2",
            // User agent of the current session
            // PayUParameters::USER_AGENT => "Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
        );

        // Authorization request
        $response = PayUPayments::doAuthorizationAndCapture($parameters);

        // You can obtain the properties in the response
        if ($response) {

            // $data = [
            //     "orderId" => $response->transactionResponse->orderId,
            //     "transactionId" => $response->transactionResponse->transactionId,
            //     "state" => $response->transactionResponse->state,
            //     "paymentNetworkResponseCode" => $response->transactionResponse->paymentNetworkResponseCode,
            //     "paymentNetworkResponseErrorMessage" => $response->transactionResponse->paymentNetworkResponseErrorMessage,
            //     "trazabilityCode" => $response->transactionResponse->trazabilityCode,
            //     "responseCode" => $response->transactionResponse->responseCode,
            //     "responseMessage" => $response->transactionResponse->responseMessage,

            // ];
            return dd($response, $data);
        }
    } catch (\Throwable $th) {
        dd(["message" => $th->getMessage(), $data]);
    }
})->name('payu.payment.test');

Route::post('/payu-payment', function (Request $request) {
    $month = (((int) $request->month) < 10) ? '0' . $request->month : $request->month;
    $data = [
        "credit_card_number" => (int)$request->credit_card_number,
        "date" => $request->years1 . $request->years2 . $request->years3 . $request->years4 . '/' . $month,
        "credit_card_security_code" => (int)$request->credit_card_security_code,
        "payment_method" => $request->payment_method ?? "VISA"
    ];
    try {
        //code...
    } catch (\Throwable $th) {
        echo ($th->getMessage());
        echo ($th->getTrace());
    }

    if ($data["credit_card_number"] == 0) return $data["error"] = "el numero de la tarjeta de credito no puede ser 0";
    if ($data["credit_card_security_code"] == 0) return $data["error"] = "el numero de seguridad no puede ser 0";


    try {


        PayU::$apiKey = env('PAYU_API_KEY'); // Enter your API key here
        PayU::$apiLogin = env('PAYU_API_LOGIN'); // Enter your API Login here
        PayU::$merchantId = env('PAYU_MERCANT_ID'); // Enter your Merchant Id here
        PayU::$language = SupportedLanguages::ES; // Enter the language here
        PayU::$isTest = false; // assign true if you are in test mode


        Environment::setPaymentsCustomUrl("https://api.payulatam.com/payments-api/4.0/service.cgi");
        // Reports URL
        Environment::setReportsCustomUrl("https://api.payulatam.com/reports-api/4.0/service.cgi");



        $reference = 'payment_test_' . strtotime("now");
        // $reference = "payment_test_00000431";
        $value = 10700.50;

        $parameters = array(
            // Enter the account’s identifier here 918558
            PayUParameters::ACCOUNT_ID => env('PAYU_ACCOUNT_ID'),
            // Enter the reference code here.
            PayUParameters::REFERENCE_CODE => $reference,
            // Enter the description here.
            PayUParameters::DESCRIPTION => "payment test",

            // -- Values --
            // Enter the value here.
            PayUParameters::VALUE => $value,
            // Enter the value of the IVA (Value Added Tax only valid for Colombia) of the transaction,
            // if no IVA is sent, the system applies 19% automatically. It can contain two decimal digits.
            // Example 19000.00. In case you don't have IVA, set 0.
            PayUParameters::TAX_VALUE => "0",
            // Enter the value of the base value on which VAT (only valid for Colombia) is calculated.
            // In case you don't have IVA, set 0.
            PayUParameters::TAX_RETURN_BASE => "0",
            // Enter the currency here.
            PayUParameters::CURRENCY => "COP",

            // -- Buyer --
            // Enter the buyer Id here.
            PayUParameters::BUYER_ID => "1",
            // Enter the buyer's name here.
            PayUParameters::BUYER_NAME => "Test comprador Persona",
            // Enter the buyer's e-mail here.
            PayUParameters::BUYER_EMAIL => "buyer_test@test.com",
            // Enter the buyer's contact phone here.
            PayUParameters::BUYER_CONTACT_PHONE => "1111111",
            // Enter the buyer's contact document here.
            PayUParameters::BUYER_DNI => "1111111111111",
            // Enter the buyer's address here.
            PayUParameters::BUYER_STREET => "Cr 23 No. 53-50",
            PayUParameters::BUYER_STREET_2 => "5555487",
            PayUParameters::BUYER_CITY => "BOGOTÁ",
            PayUParameters::BUYER_STATE => "Bogotá D.C",
            PayUParameters::BUYER_COUNTRY => "CO",
            PayUParameters::BUYER_POSTAL_CODE => "000000",
            PayUParameters::BUYER_PHONE => "1111111",


            // -- Payer --
            // Enter the payer's ID here.
            PayUParameters::PAYER_ID => "1",
            /// Enter the payer's name here
            PayUParameters::PAYER_NAME => "Test pagar Persona",
            // Enter the payer's e-mail here
            PayUParameters::PAYER_EMAIL => "payer_test@test.com",
            // Enter the payer's contact phone here.
            PayUParameters::PAYER_CONTACT_PHONE => "7563126",
            // Enter the payer's contact document here.
            PayUParameters::PAYER_DNI => "5415668464654",
            // Enter the payer's address here.
            PayUParameters::PAYER_STREET => "Cr 23 No. 53-50",
            PayUParameters::PAYER_STREET_2 => "5555487",
            PayUParameters::PAYER_CITY => "BOGOTÁ",
            PayUParameters::PAYER_STATE => "Bogotá D.C",
            PayUParameters::PAYER_COUNTRY => "CO",
            PayUParameters::PAYER_POSTAL_CODE => "000000",
            PayUParameters::PAYER_PHONE => "7563126",

            // -- Credit card data --
            // Enter the number of the credit card here
            PayUParameters::CREDIT_CARD_NUMBER => $data["credit_card_number"],
            // Enter expiration date of the credit card here
            PayUParameters::CREDIT_CARD_EXPIRATION_DATE => $data["date"],
            // Enter the security code of the credit card here
            PayUParameters::CREDIT_CARD_SECURITY_CODE => $data["credit_card_security_code"],
            // Enter the name of the credit card here
            PayUParameters::PAYMENT_METHOD => $data["payment_method"],



            // Enter the number of installments here.
            PayUParameters::INSTALLMENTS_NUMBER => "1",
            // Enter the name of the country here.
            PayUParameters::COUNTRY => PayUCountries::CO,

            // Device Session ID
            // PayUParameters::DEVICE_SESSION_ID => "vghs6tvkcle931686k1900o6e1",
            // // Payer IP
            // //  PayUParameters::IP_ADDRESS => "127.0.0.1",
            // // Cookie of the current session
            // PayUParameters::PAYER_COOKIE => "pt1t38347bs6jc9ruv2ecpv7o2",
            // // User agent of the current session
            // PayUParameters::USER_AGENT => "Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
        );

        // Authorization request
        $response = PayUPayments::doAuthorizationAndCapture($parameters);

        // You can obtain the properties in the response
        if ($response) {

            // $data = [
            //     "orderId" => $response->transactionResponse->orderId,
            //     "transactionId" => $response->transactionResponse->transactionId,
            //     "state" => $response->transactionResponse->state,
            //     "paymentNetworkResponseCode" => $response->transactionResponse->paymentNetworkResponseCode,
            //     "paymentNetworkResponseErrorMessage" => $response->transactionResponse->paymentNetworkResponseErrorMessage,
            //     "trazabilityCode" => $response->transactionResponse->trazabilityCode,
            //     "responseCode" => $response->transactionResponse->responseCode,
            //     "responseMessage" => $response->transactionResponse->responseMessage,

            // ];
            return dd($response, $data);
        }
    } catch (\Throwable $th) {
        dd(["message" => $th->getMessage(), $data]);
    }
})->name('payu.payment');
