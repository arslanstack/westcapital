<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estimated Report</title>
  <style>
    @page {
      margin: 0px;
    }

    html {
      margin: 0px
    }

    body {
      margin: 0px;
    }

    .outer_container {
      width: 95%;
      margin: auto;
    }

    .column_head {
      width: 100%;
    }

    .column_head table tr td {
      text-align: left;
    }

    .container {
      /* display: flex; */
      justify-content: space-between;
    }

    h1 {
      font-size: 18px;
    }

    /* .column {
      width: 100%;
      padding: 10px;
      box-sizing: border-box;
    } */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    table,
    th,
    td {
      border: 1px solid #0000006b;
    }

    th,
    td {
      text-align: center;
      padding: 3px 5px;

    }

    td {
      font-size: 12px;
      border: none;
    }

    th {
      background-color: #d1cece;
      font-size: 12px;
      border: none;
    }

    th:nth-child(1) {
      text-align: left;
    }

    th:nth-child(2) {
      text-align: end;
    }

    td:nth-child(1) {
      text-align: left;
    }

    td:nth-child(2) {
      text-align: end;
    }

    .column_head table {
      border: none;
    }

    table p {
      padding: 0;
      margin: 0;
    }
  </style>
</head>

<body>
  <div class="outer_container">
    <div class="container">
      <div style="width: 100%;">
        <table border="0" style="width: 100%;border: none;margin: 0;">

          <tbody>
            <tr>
              <td>
                <P style="font-size: 16px;">{{$name}} </P>
                <P><small>NMLS: {{$license_no}}</small></P>
                <P><strong>Phone: {{$phone}}</strong> </P>
                <P><strong>{{$email}}</strong> </P>
              </td>
              <td style="text-align: end;"><img src="{{$img_url ? public_path('images/' . basename($img_url)) : './images/img.jpg'}}" style="height: 100px; width: 100px;" alt="" srcset=""></td>
              <td>
                <h1>ITEMIZED FEE WORKSHEET</h1>
              </td>


            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <hr>
    <p style="text-align: center;margin: 5px 0;">Your actual rate, payment, and cost could be higher. Get an official Loan Estimate before choosing a loan.</p>
    <div class="container">
      <div style="width: 100%;">
        <table border="0" style="width: 100%;border: none;margin: 0;">

          <tbody>
            <tr>
              <td>Borrower(s): {{$fname}} {{$lname}}</td>
              <td>Preparation Date: {{$date}}</td>

            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <table style="border: none; margin-top: 10px;width: 100%;">
      <tr>
        <td>
          <div class="column_head">
            <table>

              <tbody>
                <tr>
                  <td>Property Value:</td>
                  <td><strong>${{convertToMoney($loanType == 'purchasing' ? $purchasePrice : $refinancePrice)}}</strong></td>

                </tr>
                <tr>
                  <td>Loan Purpose:</td>
                  <td><strong>{{$loanType == 'purchasing' ? 'Purchase' : 'Refinance'}}</strong></td>

                </tr>
                <tr>
                  <td>Product:</td>
                  <td><strong>{{$loanType2}}</strong></td>
                </tr>
                @if($loanType == 'purchasing')
                <tr>
                  <td>Down Payment:</td>
                  <td><strong>{{convertToMoney(($downPaymentValue/($loanType == 'purchasing' ? $purchasePrice : $refinancePrice)) * 100)}} %</strong></td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </td>
        <td>
          <div class="column_head">
            <table>

              <tbody>
                <tr>
                  <td>Loan Amount</td>
                  <td><strong>${{convertToMoney($loan_amount)}}</strong></td>

                </tr>
                <tr>
                  <td>Occupancy:</td>
                  <td><strong>Primary Residence</strong></td>

                </tr>
                <tr>
                  <td>Interest Rate:</td>
                  <td><strong>{{$interestRate}} %</strong></td>
                </tr>
              </tbody>
            </table>
          </div>
        </td>
        <td>
          <div class="column_head">
            <table>

              <tbody>
                <tr>
                  <td>Total Loan Amount:</td>
                  <td><strong>${{convertToMoney($loan_amount)}}</strong></td>

                </tr>
                <tr>
                  <td>Property Type</td>
                  <td><strong>Detached</strong></td>

                </tr>
                <tr>
                  <td>APR / Term</td>
                  <td><strong>{{$apr}}</strong></td>
                </tr>
              </tbody>
            </table>
          </div>
        </td>
      </tr>
    </table>
    <table style="border:none;width: 100%;">
      <tr>
        <td style="width: 50%;">
          <!-- First Column -->
          <div class="column">
            <table>
              <thead>
                <tr>
                  <th>A. Origination Charges</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Underwritting Fee:</td>
                  <td>$ 1,050.00</td>
                </tr>
                @if($showDis)
                <tr>
                  <td>Discount Points:</td>
                  <td>$ {{convertToMoney($discount_points)}}</td>
                </tr>
                @endif
              </tbody>
              <thead>
                <tr>
                  <th>Total Origination Charges</th>
                  <th>$ {{convertToMoney($total_origin)}}</th>
                </tr>
              </thead>
            </table>
            <table>
              <thead>
                <tr>
                  <th>B. Services You Cannot Shop For</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Appraisal Fee:</td>
                  <td>$ 650.00</td>
                </tr>
                <tr>
                  <td>3rd Party Processing Fee:</td>
                  <td>$ 649.00</td>
                </tr>
                <tr>
                  <td>MERS Fee:</td>
                  <td>$ 30.00</td>
                </tr>
                <tr>
                  <td>Life of Loan Flood Fee:</td>
                  <td>$ 35.00</td>
                </tr>
                <tr>
                  <td>Credit Report Fee:</td>
                  <td>$ 85.00</td>
                </tr>
              </tbody>
              <thead>
                <tr>
                  <th>Total Services You Cannot Shop For</th>
                  <th>$ 1,579.00</th>
                </tr>
              </thead>
            </table>
            <table>
              <thead>
                <tr>
                  <th>C. Services You Can Shop For</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($services_you_can_shop_for as $fee)
                <tr>
                  <td>{{$fee['FeeName']}}</td>
                  <td>${{convertToMoney($fee['Amount'])}}</td>
                </tr>
                @endforeach
              </tbody>
              <thead>
                <tr>
                  <th>Total Services You Can Shop For</th>
                  <th>${{convertToMoney($total_loan_cost)}}</th>
                </tr>
              </thead>
            </table>
            <table>
              <thead>
                <tr>
                  <th>D. TOTAL LOAN COSTS</th>
                  <th>$ {{convertToMoney($total_loan_cost_table_d)}}</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
            <table>
              <thead>
                <tr>
                  <th>Total Estimated Funds Needed To Close</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Purchase Price</td>
                  <td>${{convertToMoney($loanType == 'purchasing' ? $purchasePrice : $refinancePrice)}}</td>
                </tr>
                <tr>
                  <td>Estimated Prepaid Items</td>
                  <td>$ {{convertToMoney($est_pv)}}</td>
                </tr>
                <tr>
                  <td>Estimate Closing Cost</td>
                  <td>$ {{convertToMoney($est_cc)}}</td>
                </tr>
                <tr>
                  <td>Total Due from Borrower at Closing (K)</td>
                  <td>$ {{convertToMoney($tdbc)}}</td>
                </tr>
                <tr>
                  <td>EMD</td>
                  <td>$ {{convertToMoney($emd)}}</td>
                </tr>
                <tr>
                  <td>Loan Amount</td>
                  <td>$ {{convertToMoney($loan_amount)}}</td>
                </tr>
                <thead>
                  <tr>
                    <th>Total Estimated Funds To Y0u</th>
                    <th>$ {{convertToMoney($total_est_table)}}</th>
                  </tr>
                </thead>
              </tbody>
            </table>
          </div>
        </td>
        <td style="display:grid;">
          <!-- Second Column -->
          <div class="column">
            <table>
              <thead>
                <tr>
                  <th>E. Taxes and Other Government Fees </th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($taxes_and_other_govt_fees as $fee_name => $fee_amount)
                <tr>
                  <td>{{ ucfirst(str_replace('_', ' ', $fee_name)) }}</td> <!-- Convert snake_case to readable text -->
                  <td>${{ convertToMoney($fee_amount, 2) }}</td> <!-- Format as currency -->
                </tr>
                @endforeach
              </tbody>
              <thead>
                <tr>
                  <th>Total Taxes and Other Government Fees </th>
                  <th>$ {{convertToMoney($total_taxes_and_fee)}}</th>
                </tr>
              </thead>
            </table>
            <table>
              <thead>
                <tr>
                  <th>F. Prepaids </th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Property Taxes (5 months):</td>
                  <td>${{convertToMoney($prepaid_items['property_tax'])}}</td>
                </tr>
                <tr>
                  <td>Home Insurance (5 months):</td>
                  <td>${{convertToMoney($prepaid_items['insurance'])}}</td>
                </tr>
              </tbody>
              <thead>
                <tr>
                  <th>Total Prepaids </th>
                  <th>${{convertToMoney($total_prepaid)}}</th>
                </tr>
              </thead>
            </table>
            <table>
              <thead>
                <tr>
                  <th>G. Initial Escrow Payment at Closing </th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Property Taxes (2 months):</td>
                  <td>${{convertToMoney($escrow['property_tax'])}}</td>
                </tr>
                <tr>
                  <td>Home Insurance (2 months):</td>
                  <td>${{convertToMoney($escrow['insurance'])}}</td>
                </tr>
              </tbody>
              <thead>
                <tr>
                  <th>Total Initial Escrow Payment at Closing </th>
                  <th>${{convertToMoney($total_escrow)}}</th>
                </tr>
              </thead>
            </table>

            <table>
              <thead>
                <tr>
                  <th>H. Other</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($other_fees as $fee_name => $fee_amount)
                <tr>
                  <td>{{ ucwords(str_replace('_', ' ', $fee_name)) }}</td> <!-- Format fee name -->
                  <td>${{ convertToMoney($fee_amount, 2) }}</td> <!-- Format amount as currency -->
                </tr>
                @endforeach
              </tbody>
              <thead>
                <tr>
                  <th>Total Other</th>
                  <th>$ {{convertToMoney($total_other)}}</th>
                </tr>
              </thead>
            </table>
            <table>
              <thead>
                <tr>
                  <th>I. Total Estimated Monthly Housing Payment</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>First Mortgage Payment:</td>
                  <td>${{ convertToMoney($first_mortgage) }}</td>
                </tr>
                <tr>
                  <td>Hazard Insurance:</td>
                  <td>${{ convertToMoney($est_insurance) }}</td>
                </tr>
                <tr>
                  <td>Property Tax:</td>
                  <td>${{ convertToMoney($est_tax) }}</td>
                </tr>
                <tr>
                  <td>Mortgage Insurance:</td>
                  <td>${{ convertToMoney($est_mortgage) }}</td>
                </tr>
              </tbody>
              <thead>
                <tr>
                  <th>Total Total Estimated Monthly Housing Payment</th>
                  <th>${{convertToMoney($total_est_monthly)}}</th>
                </tr>
              </thead>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>
</body>

</html>