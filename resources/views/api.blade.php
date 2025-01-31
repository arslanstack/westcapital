<?php
// Define API URL and headers
$apiUrl = 'https://www.lodestarss.com/Live/PriorityTitle/closing_cost_calculations.php';
$headers = [
    'Accept: application/json',
    'Content-Type: application/json',
    'Cookie: PriorityTitle=c0oe4k4cdlat0t9dd5cfh92qjg'
];
$session_id = 'c0oe4k4cdlat0t9dd5cfh92qjg';
// API request payload
$requestData = [
    'session_id' => 'c0oe4k4cdlat0t9dd5cfh92qjg',
    'state' => 'NY',
    'county' => 'Delaware',
    'township' => 'All Townships',
    'search_type' => 'CFPB',
    'purpose' => '01',
    'loan_amount' => 712250.0,
    'purchase_price' => 0,
    'prior_insurance' => 520400.0,
    'exdebt' => 527467.0,
    'loan_info' => [
        'prop_type' => 1,
        'amort_type' => 1,
        'loan_type' => 2,
        'prop_purpose' => 1,
        'prop_usage' => 1,
        'number_of_families' => 1,
        'is_first_time_home_buyer' => 0,
        'is_federal_credit_union' => 0,
        'is_same_lender_as_previous' => 1,
        'is_same_borrwers_as_previous' => 1
    ],
    'include_encompass_mapping' => 1
];

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));

// Execute the API request
$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    $response = "Error: $error";
} else {
    $response = json_decode($response, true); // Decode JSON response
}

function formatResponse($data)
{
    if (is_array($data)) {
        $html = '<ul>';
        foreach ($data as $key => $value) {
            $keyFormatted = ucwords(str_replace('_', ' ', $key));
            $valueFormatted = is_array($value) ? formatResponse($value) : htmlspecialchars($value);
            $html .= "<li><strong>{$keyFormatted}:</strong> {$valueFormatted}</li>";
        }
        $html .= '</ul>';
        return $html;
    }
    return htmlspecialchars($data);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Test - West Capital</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            display: flex;
            justify-content: space-between;
        }
        .col {
            width: 48%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .col h2 {
            text-align: center;
        }
        #response {
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Closing Cost Calculation API Demo</h1>
    <div class="container">
        <div class="col">
            <h2>Request</h2>
            <pre><?= htmlspecialchars(json_encode($requestData, JSON_PRETTY_PRINT)); ?></pre>
        </div>
        <div class="col">
            <h2>Response</h2>
            <div id="response">
                <?= is_array($response) ? formatResponse($response) : htmlspecialchars($response); ?>
            </div>
        </div>
    </div>
</body>
</html>
