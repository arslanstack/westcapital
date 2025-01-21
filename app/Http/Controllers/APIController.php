<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class APIController extends Controller
{
    public function Login()
    {
        $username = Config::where('key', 'api_username')->first()->value;
        $password = Config::where('key', 'api_password')->first()->value;
        $session_id = Config::where('key', 'session_id')->first()->value;
        $title = Config::where('key', 'api_title')->first()->value;
        $client = new Client();

        $response = $client->request('POST', "https://www.lodestarss.com/Live/$title/Login/login.php", [
            'form_params' => [
                'username' => $username,
                'password' => $password
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
                'Cookie' => "$title=$session_id",
            ],
        ]);

        $new_session_id = json_decode($response->getBody())->session_id;

        $session = Config::where('key', 'session_id')->first();
        $session->value = $new_session_id;
        $session->save();

        return true;
    }

    public function getCounties(Request $request)
    {
        $state = $request->state;
        if (!$state) {
            return response()->json(['error' => 'State is required.'], 400);
        }

        $session_id = Config::where('key', 'session_id')->first()->value;
        $title = Config::where('key', 'api_title')->first()->value;

        $client = new Client();

        try {
            $response = $client->request('GET', "https://www.lodestarss.com/Live/$title/counties.php?state=$state&session_id=$session_id", [
                'headers' => [
                    'Cookie' => "$title=$session_id"
                ]
            ]);

            $counties = json_decode($response->getBody());
            return response()->json([
                'status' => 'success',
                'message' => 'Counties fetched successfully.',
                'counties' => $counties
            ]);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 401) {
                $this->Login();
                return $this->getCounties($request); // Retry the request
            }
            return response()->json(['error' => 'Failed to fetch counties.', 'message' => $e->getMessage()], 500);
        }
    }

    public function getTownships(Request $request)
    {
        $state = $request->state;
        $county = $request->county;
        if (!$state || !$county) {
            return response()->json(['error' => 'State and County are required.'], 400);
        }

        $session_id = Config::where('key', 'session_id')->first()->value;
        $title = Config::where('key', 'api_title')->first()->value;

        $client = new Client();

        try {
            $response = $client->request('GET', "https://www.lodestarss.com/Live/$title/townships.php?state=$state&county=$county&session_id=$session_id", [
                'headers' => [
                    'Cookie' => "$title=$session_id"
                ]
            ]);

            $townships = json_decode($response->getBody());
            return response()->json([
                'status' => 'success',
                'message' => 'Townships fetched successfully.',
                'townships' => $townships
            ]);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 401) {
                $this->Login();
                return $this->getTownships($request); // Retry the request
            }
            return response()->json(['error' => 'Failed to fetch townships.', 'message' => $e->getMessage()], 500);
        }
    }

    public function getFee(Request $request)
    {
        $formData = $request->all(); // Get all data including CSRF token
        $data = $formData['data'];
        $session_id = Config::where('key', 'session_id')->first()->value;
        $title = Config::where('key', 'api_title')->first()->value;

        $apiData = $this->prepareLoadstarApiData($data);

        $client = new Client();

        try {
            $response = $client->request('POST', "https://www.lodestarss.com/Live/$title/closing_cost_calculations.php", [
                'json' => $apiData,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept' => 'application/json',
                    'Cookie' => "$title=$session_id",
                ],
            ]);

            $fees = json_decode($response->getBody());
            return response()->json([
                'status' => 'success',
                'message' => 'Fees fetched successfully.',
                'fees' => $fees
            ]);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 401) {
                $this->Login();
                return $this->getFee($request); // Retry the request
            }
            return response()->json(['error' => 'Failed to fetch fees.', 'message' => $e->getMessage()], 500);
        }
    }

    private function prepareLoadstarApiData(array $data)
    {
        $session_id = Config::where('key', 'session_id')->first()->value;
        $loanType = $data['loanType'];
        $state = $data['state'];
        $county = $data['county'];
        $township = $data['township'];
        $purchasePrice = floatval($data['purchasePrice']);
        $refinancePrice = floatval($data['refinancePrice']);
        $downPaymentValue = floatval($data['downPaymentValue']);
        $ltv = floatval($data['ltv']) / 100;

        $purpose = $loanType === 'purchasing' ? '01' : '04';
        $loanAmount = $loanType === 'purchasing'
            ? $purchasePrice - $downPaymentValue
            : $refinancePrice * $ltv;
        $priorInsurance = $loanType === 'refinance' ? $refinancePrice : 0;
        $exdebt = $loanType === 'refinance' ? $refinancePrice : 0;

        return [
            "session_id" => $session_id,
            "state" => $state,
            "county" => $county,
            "township" => $township,
            "search_type" => "CFPB",
            "purpose" => $purpose,
            "filename" => "",
            "loan_amount" => $loanAmount,
            "purchase_price" => $loanType === 'purchasing' ? $purchasePrice : 0,
            "prior_insurance" => $priorInsurance,
            "exdebt" => $exdebt,
            "loan_info" => [
                "prop_type" => 1,
                "amort_type" => 1,
                "loan_type" => 2,
                "prop_purpose" => 1,
                "prop_usage" => 1,
                "number_of_families" => 1,
                "is_first_time_home_buyer" => 0,
                "is_federal_credit_union" => 0,
                "is_same_lender_as_previous" => 1,
                "is_same_borrwers_as_previous" => 1,
            ],
            "include_encompass_mapping" => 1,
        ];
    }
}
