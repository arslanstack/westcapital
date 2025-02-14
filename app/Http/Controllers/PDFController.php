<?php

namespace App\Http\Controllers;


use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ReportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PDFController extends Controller
{
    public function genPDF(Request $request)
    {
        $data = $request->all();
        // there is an image file in request with name img
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $data['img_url'] = url('images/' . $name);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Image not found'
            ], 404);
        }
        $fee_response = json_decode($request->fee_response_json, true);
        $data['showDis'] = false;
        if (!$data['discount_points'] || $data['discount_points'] == '' || $data['discount_points'] == null) {
            $data['discount_points'] = 0.00;
            $data['showDis'] = false;
        } else {
            $data['discount_points'] = number_format($data['discount_points'], 2, '.', '');
            $data['showDis'] = true;
        }
        $data['first_mortgage'] = $request->principalAndInterest;
        $data['total_origin'] = number_format($data['discount_points'] + 1050, 2, '.', '');
        $data['services_you_can_shop_for'] = $fee_response['data']['services_you_can_shop_for'];
        $data['total_loan_cost'] = $fee_response['data']['total_loan_cost'];
        $data['total_loan_cost_table_d'] = $fee_response['data']['total_loan_cost'] + $data['discount_points'] + 1050 + 1579;

        $data['taxes_and_other_govt_fees'] = $fee_response['data']['taxes_and_other_govt_fees'];
        $data['total_taxes_and_fee'] = 0;
        foreach ($fee_response['data']['taxes_and_other_govt_fees'] as $fee_name => $fee_amount) {
            $data['total_taxes_and_fee'] += $fee_amount;
        }
        $data['other_fees'] = $fee_response['data']['other_fees'];
        $data['total_other'] = 0;
        foreach ($fee_response['data']['other_fees'] as $fee_name => $fee_amount) {
            $data['total_other'] += $fee_amount;
        }
        if ($data['loanType'] == 'refinance') {
            $data['downPaymentValue'] = 0;
        }
        $data['prepaid_items'] = [];
        // following items would be in it
        // Mortgage Insurance Premium (5 months) = (mip/12) * 5
        // Home Insurance (5 months):  = (homeinsurance/12) * 5
        // Property Taxes (5 months): = (propertyTaxes/12) * 5

        // total_prepaid would be there total
        // now lets create the prepaid items

        $data['prepaid_items']['mip'] = number_format(($data['mip'] / 12) * 5, 2, '.', '');
        $data['prepaid_items']['insurance'] = number_format(($data['homeinsurance'] / 12) * 5, 2, '.', '');
        $data['prepaid_items']['property_tax'] = number_format(($data['propertyTaxes'] / 12) * 5, 2, '.', '');
        $data['total_prepaid'] = number_format($data['prepaid_items']['mip'] + $data['prepaid_items']['insurance'] + $data['prepaid_items']['property_tax'], 2, '.', '');


        $data['escrow']['mip'] = number_format(($data['mip'] / 12) * 2, 2, '.', '');
        $data['escrow']['insurance'] = number_format(($data['homeinsurance'] / 12) * 2, 2, '.', '');
        $data['escrow']['property_tax'] = number_format(($data['propertyTaxes'] / 12) * 2, 2, '.', '');
        $data['total_escrow'] = number_format($data['escrow']['mip'] + $data['escrow']['insurance'] + $data['escrow']['property_tax'], 2, '.', '');

        $data['est_insurance'] = number_format(($data['homeinsurance'] / 12), 2, '.', '');
        $data['est_tax'] = number_format(($data['propertyTaxes'] / 12), 2, '.', '');
        $data['est_mortgage'] = number_format(($data['mip']), 2, '.', '');
        $data['total_est_monthly'] = number_format($data['est_insurance'] + $data['first_mortgage'] + $data['est_tax'] + $data['est_mortgage'], 2, '.', '');

        $data['est_pv'] = $data['total_escrow'] + $data['total_prepaid'];
        $data['est_cc'] = $data['total_origin'] + 1579 + $data['total_loan_cost'] + $data['total_taxes_and_fee'] + $data['total_other'];
        $data['tdbc'] = $request->seller_assistance ?? 0;
        $data['total_est_table'] = $data['est_pv'] + $data['est_cc'] + $data['tdbc'] + $data['emd'] + $data['loan_amount'];
        if ($data['loanType'] == 'purchasing') {
            $data['total_est_table'] += $data['purchasePrice'];
        } else {
            $data['total_est_table'] += $data['refinancePrice'];
        }
        $data['emd'] = $request->emd ?? 0;
        // dd($data['transfer_fee_breakdown_total'], $data['recording_fee_breakdown_total']);
        // dd($data['services_you_can_shop_for'], $data['total_loan_cost'], $data['taxes_and_other_govt_fees'], $data['other_fees'], $data['transfer_fee_breakdown'], $data['recording_fee_breakdown']);
        // dd($fee_response);
        // unset($data['fee_response_json']);
        // dd($data);
        // $data['borrowerFees'] = $fee_response['borrowerFees'];
        // $data['totalBorrowerFee'] = 0;
        // foreach ($fee_response['borrowerFees'] as $fee) {
        //     $data['totalBorrowerFee'] += $fee['Amount'];
        // }
        // $data['taxAndGovtFees'] = $fee_response['taxAndGovtFees'];
        // $data['totalTaxAndGovtFee'] = 0;
        // foreach ($fee_response['taxAndGovtFees'] as $fee) {
        //     $data['totalTaxAndGovtFee'] += $fee['amount'] ?? 0;
        // }
        // $data['otherApplicableFees'] = $fee_response['otherApplicableFees'];
        // $data['totalOtherApplicableFee'] = 0;
        // foreach ($fee_response['otherApplicableFees'] as $fee) {
        //     $data['totalOtherApplicableFee'] += $fee['Amount'];
        // }
        $data['date'] = date('Y-m-d');

        // dd($data['borrowerFees']);
        $data['borrower_fee'] =
            $pdf = PDF::loadView('pdf.template', $data);
        $filePath = 'generated_pdf_' . time() . '.pdf';
        $pdf->save(public_path('temporaryPDFs/' . $filePath));
        return response()->json([
            'status' => 'success',
            'message' => 'PDF generated successfully',
            'pdf_url' => url('temporaryPDFs/' . $filePath),
            'delete_url' => url('delete-pdf/' . $filePath)
        ]);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'PDF generated successfully',
        //     'pdf_url' => url(public/temporaryPDFs/' . $filePath),
        //     'delete_url' => url('delete-pdf/' . $filePath)        
        // ]);
    }

    public function categorizeFees($feeResponse)
    {
        $feeResponse = json_decode($feeResponse, true);
        // Initialize result arrays
        $borrowerFees = [];
        $taxAndGovtFees = [];
        $otherApplicableFees = [];

        // Extract fees from the response
        if (isset($feeResponse['fees']['title_agent_fees']['borrower'])) {
            $borrowerFees = $feeResponse['fees']['title_agent_fees']['borrower'];
        }

        // Combine relevant government and tax fees
        if (isset($feeResponse['fees']['transfer_taxes']['borrower'])) {
            foreach ($feeResponse['fees']['transfer_taxes']['borrower'] as $taxFee) {
                $taxAndGovtFees[] = $taxFee;
            }
        }
        if (isset($feeResponse['fees']['recording_fees'])) {
            foreach ($feeResponse['fees']['recording_fees'] as $recordingFee) {
                $taxAndGovtFees[] = $recordingFee;
            }
        }

        // Extract remaining fees for "other applicable fees"
        if (isset($feeResponse['fees']['title_agent_fees']['seller'])) {
            $otherApplicableFees = $feeResponse['fees']['title_agent_fees']['seller'];
        }

        // Return categorized data
        return [
            'borrowerFees' => $borrowerFees,
            'taxAndGovtFees' => $taxAndGovtFees,
            'otherApplicableFees' => $otherApplicableFees,
        ];
    }


    public function delPDF($filepath)
    {
        $file = public_path('temporaryPDFs/' . $filepath);
        if (file_exists($file)) {
            unlink($file);
            return response()->json([
                'status' => 'success',
                'message' => 'PDF deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'PDF not found'
            ], 404);
        }
    }
    public function sendPDF(Request $request)
    {
        $data = $request->all();
        // there is an image file in request with name img
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $data['img_url'] = url('images/' . $name);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Image not found'
            ], 404);
        }
        $fee_response = json_decode($request->fee_response_json, true);
        $data['showDis'] = false;
        if (!$data['discount_points'] || $data['discount_points'] == '' || $data['discount_points'] == null) {
            $data['discount_points'] = 0.00;
            $data['showDis'] = false;
        } else {
            $data['discount_points'] = number_format($data['discount_points'], 2, '.', '');
            $data['showDis'] = true;
        }
        $data['first_mortgage'] = $request->principalAndInterest;
        $data['total_origin'] = number_format($data['discount_points'] + 1050, 2, '.', '');
        $data['services_you_can_shop_for'] = $fee_response['data']['services_you_can_shop_for'];
        $data['total_loan_cost'] = $fee_response['data']['total_loan_cost'];
        $data['total_loan_cost_table_d'] = $fee_response['data']['total_loan_cost'] + $data['discount_points'] + 1050 + 1579;

        $data['taxes_and_other_govt_fees'] = $fee_response['data']['taxes_and_other_govt_fees'];
        $data['total_taxes_and_fee'] = 0;
        foreach ($fee_response['data']['taxes_and_other_govt_fees'] as $fee_name => $fee_amount) {
            $data['total_taxes_and_fee'] += $fee_amount;
        }
        $data['other_fees'] = $fee_response['data']['other_fees'];
        $data['total_other'] = 0;
        foreach ($fee_response['data']['other_fees'] as $fee_name => $fee_amount) {
            $data['total_other'] += $fee_amount;
        }
        if ($data['loanType'] == 'refinance') {
            $data['downPaymentValue'] = 0;
        }
        $data['prepaid_items'] = [];
        // following items would be in it
        // Mortgage Insurance Premium (5 months) = (mip/12) * 5
        // Home Insurance (5 months):  = (homeinsurance/12) * 5
        // Property Taxes (5 months): = (propertyTaxes/12) * 5

        // total_prepaid would be there total
        // now lets create the prepaid items

        $data['prepaid_items']['mip'] = number_format(($data['mip'] / 12) * 5, 2, '.', '');
        $data['prepaid_items']['insurance'] = number_format(($data['homeinsurance'] / 12) * 5, 2, '.', '');
        $data['prepaid_items']['property_tax'] = number_format(($data['propertyTaxes'] / 12) * 5, 2, '.', '');
        $data['total_prepaid'] = number_format($data['prepaid_items']['mip'] + $data['prepaid_items']['insurance'] + $data['prepaid_items']['property_tax'], 2, '.', '');


        $data['escrow']['mip'] = number_format(($data['mip'] / 12) * 2, 2, '.', '');
        $data['escrow']['insurance'] = number_format(($data['homeinsurance'] / 12) * 2, 2, '.', '');
        $data['escrow']['property_tax'] = number_format(($data['propertyTaxes'] / 12) * 2, 2, '.', '');
        $data['total_escrow'] = number_format($data['escrow']['mip'] + $data['escrow']['insurance'] + $data['escrow']['property_tax'], 2, '.', '');

        $data['est_insurance'] = number_format(($data['homeinsurance'] / 12), 2, '.', '');
        $data['est_tax'] = number_format(($data['propertyTaxes'] / 12), 2, '.', '');
        $data['est_mortgage'] = number_format(($data['mip']), 2, '.', '');
        $data['total_est_monthly'] = number_format($data['est_insurance'] + $data['first_mortgage'] + $data['est_tax'] + $data['est_mortgage'], 2, '.', '');
        $data['est_pv'] = $data['total_escrow'] + $data['total_prepaid'];
        $data['est_cc'] = $data['total_origin'] + 1579 + $data['total_loan_cost'] + $data['total_taxes_and_fee'] + $data['total_other'];
        $data['tdbc'] = $request->seller_assistance ?? 0;
        $data['total_est_table'] = $data['est_pv'] + $data['est_cc'] + $data['tdbc'] + $data['emd'] + $data['loan_amount'];
        if ($data['loanType'] == 'purchasing') {
            $data['total_est_table'] += $data['purchasePrice'];
        } else {
            $data['total_est_table'] += $data['refinancePrice'];
        }
        $data['emd'] = $request->emd ?? 0;
        $data['date'] = date('Y-m-d');
        // dd($request->sendingemail);
        $pdf = PDF::loadView('pdf.template', $data);
        $filePath = 'generated_pdf_' . time() . '.pdf';
        $pdf->save(public_path('temporaryPDFs/' . $filePath));
        $mail = Mail::to($request->sendingemail)->send(new ReportMail(public_path('temporaryPDFs/' . $filePath)));
        unlink(public_path('temporaryPDFs/' . $filePath));

        if ($mail) {
            return response()->json([
                'status' => 'success',
                'message' => 'Email sent successfully with PDF attachment.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send email with PDF attachment.'
            ], 500);
        }
    }
}
