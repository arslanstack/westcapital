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
        // dd($request->all());
        $formData = $request->all(); // Get all data including CSRF token
        $data = $formData['data'];
        $session_id = Config::where('key', 'session_id')->first()->value;
        $title = Config::where('key', 'api_title')->first()->value;

        $apiData = $this->prepareLoadstarApiData($data);

        $client = new Client();
        // dd($apiData);
        try {
            $response = $client->request('POST', "https://www.lodestarss.com/Live/$title/closing_cost_calculations.php", [
                'json' => $apiData,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept' => 'application/json',
                    'Cookie' => "$title=$session_id",
                ],
            ]);

            $all_fees = json_decode($response->getBody(), true);
            // dd($all_fees);
            // $services_you_can_shop_for = [];
            // // this would include
            // // all the borrower title agent fee + borrower loan policy premium
            // // then there is 
            // $total_loan_cost = 0;
            // // sum of all the borrower tittle agent fee and borrower loan policy premium
            // // then there is
            // $taxes_and_other_govt_fees = [];
            // // there would be 2 items in this array
            // // Transfer tax = sum of all borrower transfer_taxes
            // // Recording Fee = sum of all borrower recording_fees
            // // then there is
            // $other_fees = [];
            // // there would be few items in this array
            // // one of them i know is owner policy premium
            // // you can show others as well here
            $services_you_can_shop_for = [];
            $total_loan_cost = 0;
            $taxes_and_other_govt_fees = [
                'transfer_tax' => 0,
                'recording_fee' => 0,
            ];
            $other_fees = [];


            // 1. Services you can shop for
            foreach ($all_fees['title_agent_fees']['borrower'] as $fee) {
                $services_you_can_shop_for[] = [
                    'FeeName' => $fee['FeeName'],
                    'Amount' => $fee['Amount'],
                ];
                $total_loan_cost += $fee['Amount'];
            }
            $services_you_can_shop_for[] = [
                'FeeName' => 'Lender\'s Title Policy (Loan Policy Premium)',
                'Amount' => $all_fees['loan_policy_premium']['borrower'] ?? 0,
            ];
            $total_loan_cost += $all_fees['loan_policy_premium']['borrower'] ?? 0;

            // 2. Taxes and other government fees
            foreach ($all_fees['transfer_taxes']['borrower'] as $tax) {
                if ($tax['type'] === 'MortgageTax' || $tax['type'] === 'DeedTax' || $tax['type'] === 'MortgageIntangibleTax') {
                    $taxes_and_other_govt_fees['transfer_tax'] += $tax['amount'];
                }
            }
            foreach ($all_fees['recording_fees'] as $fee) {
                $taxes_and_other_govt_fees['recording_fee'] += $fee['amount'];
            }

            // 3. Other fees
            $other_fees['Owner\'s Title Policy'] = $all_fees['owners_policy_premium']['borrower'] ?? 0;
            // 4.  Transfer Fee Breakdown
            $transfer_fee_breakdown = [];
            foreach ($all_fees['transfer_taxes']['borrower'] as $tax) { 
                $transfer_fee_breakdown[] = [
                    'FeeName' => $tax['type'],
                    'Amount' => $tax['amount'],
                ];
            }

            // 5. Recordinf Fee BreakDown
            $recording_fee_breakdown = [];
            foreach ($all_fees['recording_fees'] as $fee) {
                $recording_fee_breakdown[] = [
                    'FeeName' => $fee['type'],
                    'Amount' => $fee['amount'],
                ];
            }
            // 6. Rest All fee in rest fee
            $rest_fee = [];
            foreach ($all_fees as $key => $value) {
                if (!in_array($key, ['title_agent_fees', 'loan_policy_premium', 'transfer_taxes', 'recording_fees', 'owners_policy_premium'])) {
                    $rest_fee[$key] = $value;
                }
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Fees fetched successfully.',
                'data' => [
                    'services_you_can_shop_for' => $services_you_can_shop_for,
                    'total_loan_cost' => $total_loan_cost,
                    'taxes_and_other_govt_fees' => $taxes_and_other_govt_fees,
                    'other_fees' => $other_fees,
                    'rest_fee' => $rest_fee,
                    'transfer_fee_breakdown' => $transfer_fee_breakdown,
                    'recording_fee_breakdown' => $recording_fee_breakdown,
                ],
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
        $state = $data['state'];
        $county = $data['county'];
        $township = $data['township'];
        $purpose = $data['loanType'] == 'refinance' ? '00' : '11';
        $purchasePrice = floatval($data['loanType'] == 'refinance' ? 0 : $data['purchasePrice']);
        $loanAmount = $data['loan_amount'];
        $priorInsurance = 0;
        $exdebt = 0;

        return [
            "session_id" => $session_id,
            "state" => $state,
            "county" => $county,
            "township" => $township,
            "search_type" => "CFPB",
            "purpose" => $purpose,
            "filename" => "",
            "loan_amount" => $loanAmount,
            "purchase_price" => $purchasePrice,
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
