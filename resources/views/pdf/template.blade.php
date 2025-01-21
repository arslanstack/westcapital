<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Two Columns with Tables and Headers</title>
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
      width: 70%;
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
    h1{
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
                <P style="font-size: 16px;">Alex Reinig </P>
                <P><small>NMLS: 584809</small></P>
                <P><strong>Phone: (412) 889 3310</strong> </P>
                <P><strong>Alex@redtreeming.com</strong> </P>
              </td>
              <td style="text-align: end;"><img src="./images/img.jpg" style="height: 100px; width: 100px;" alt="" srcset=""></td>
              <td>
                <h1>ITEMIZED FEE WORKSHEET</h1>
              </td>


            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <hr>
    <p style="text-align: center;margin: 5px 0;">Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
    <div class="container">
      <div style="width: 100%;">
        <table border="0" style="width: 100%;border: none;margin: 0;">

          <tbody>
            <tr>
              <td>Borrower(s): Ethan Recktenwald</td>
              <td>Preparation Date: 12/31/2024</td>

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
                  <td><strong>${{$data['refinancePrice']}}</strong></td>

                </tr>
                <tr>
                  <td>Loan Purpose:</td>
                  <td><strong>Purchase</strong></td>

                </tr>
                <tr>
                  <td>Product:</td>
                  <td><strong>USDA 30 Year Fixed</strong></td>
                </tr>
                <tr>
                  <td>DownPayment:</td>
                  <td><strong>$0</strong></td>
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
                  <td>Loan Amount</td>
                  <td><strong>$255,000</strong></td>

                </tr>
                <tr>
                  <td>Total Loan Amt:</td>
                  <td><strong>Primary Residence</strong></td>

                </tr>
                <tr>
                  <td>Property Type:</td>
                  <td><strong>6.000%</strong></td>
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
                  <td><strong>$255,000</strong></td>

                </tr>
                <tr>
                  <td>Property Type</td>
                  <td><strong>Detached</strong></td>

                </tr>
                <tr>
                  <td>APR / Term</td>
                  <td><strong>6.055% / 360</strong></td>
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
                  <th>Origination Charges:</th>
                  <th>$999</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Underwriting Fee</td>
                  <td>$999.00</td>
                </tr>

              </tbody>
            </table>
            <table>
              <thead>
                <tr>
                  <th>Services Borrower Cannot Shop:</th>
                  <th>1,399.00</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Appraisal Fee</td>
                  <td>$555.00</td>
                </tr>
                <tr>
                  <td>Credit Report Fee</td>
                  <td>$100.00</td>
                </tr>
                <tr>
                  <td>Preferred Processing</td>
                  <td>$749.00</td>
                </tr>

              </tbody>
            </table>
            <table>
              <thead>
                <tr>
                  <th>Services Borrower Cannot Shop:</th>
                  <th>$2,198.65</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Doc Prep-Deed</td>
                  <td>$67.00</td>
                </tr>
                <tr>
                  <td>Title-Closing Protection Letter</td>
                  <td>$75.00</td>
                </tr>
                <tr>
                  <td>Title Lender's Coverage</td>
                  <td>$125.00</td>
                </tr>
                <tr>
                  <td>Title- PA 100 Covenants, Conditions and Restrictions Lender Endorsement</td>
                  <td>$1,673,00</td>
                </tr>
                <tr>
                  <td>Title Settlement or Closing Fee</td>
                  <td>$150.00</td>
                </tr>
                <tr>
                  <td>Title - Tax Lien Search</td>
                  <td>$75.00</td>
                </tr>

              </tbody>
            </table>
            <table>
              <thead>
                <tr>
                  <th>Total Estimated Funds Needed To Close</th>
                  <th> </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Purchase Price</td>
                  <td>$255,000.00</td>
                </tr>
                <tr>
                  <td>Estimated Prepaid Items</td>
                  <td>$4455.00</td>
                </tr>
                <tr>
                  <td>Estimate Closing Cost</td>
                  <td>$66.00</td>
                </tr>
                <tr>
                  <td>Total Due from Borrower at Closing (K)</td>
                  <td>$77.00</td>
                </tr>
                <tr>
                  <td>Seller Credit</td>
                  <td>$65.00</td>
                </tr>
                <tr>
                  <td>Loan Amount</td>
                  <td>$150.00</td>
                </tr>
                <tr>
                  <td>Total Paid Already by or on Behalf of Borrower at Closing (L)</td>
                  <td>$270,300.00</td>
                </tr>
                <thead>
                  <tr>
                    <th>Total Estimated Funds To Y0u</th>
                    <th> $3,117.10</th>
                  </tr>
                </thead>
              </tbody>
            </table>
          </div>
        </td>
        <td style="width: 50%;">
          <!-- Second Column -->
          <div class="column">
            <table>
              <thead>
                <tr>
                  <th>Taxes and Other Government Fees:</th>
                  <th>$2,844.50</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>County Deed Tax</td>
                  <td>1,300.00</td>
                </tr>
                <tr>
                  <td>Cell </td>
                  <td>Cell 4</td>
                </tr>
                <tr>
                  <td>Cell 5</td>
                  <td>Cell 6</td>
                </tr>
                <tr>
                  <td>Cell 7</td>
                  <td>Cell 8</td>
                </tr>
              </tbody>
            </table>
            <table>
              <thead>
                <tr>
                  <th>Header 1</th>
                  <th>Header 2</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Cell 1</td>
                  <td>Cell 2</td>
                </tr>
                <tr>
                  <td>Cell 3</td>
                  <td>Cell 4</td>
                </tr>
                <tr>
                  <td>Cell 5</td>
                  <td>Cell 6</td>
                </tr>
              </tbody>
            </table>
            <table>
              <thead>
                <tr>
                  <th>Header 1</th>
                  <th>Header 2</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Cell 1</td>
                  <td>Cell 2</td>
                </tr>
                <tr>
                  <td>Cell 3</td>
                  <td>Cell 4</td>
                </tr>
              </tbody>
            </table>
            <table>
              <thead>
                <tr>
                  <th>Header 1</th>
                  <th>Header 2</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Cell 1</td>
                  <td>Cell 2</td>
                </tr>
              </tbody>
            </table>

            <table>
              <thead>
                <tr>
                  <th>Header 1</th>
                  <th>Header 2</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Cell 1</td>
                  <td>Cell 2</td>
                </tr>
                <tr>
                  <td>Cell 3</td>
                  <td>Cell 4</td>
                </tr>
                <tr>
                  <td>Cell 5</td>
                  <td>Cell 6</td>
                </tr>
                <thead>
                  <tr>
                    <th>Header 1</th>
                    <th>Header 2</th>
                  </tr>
                </thead>
              </tbody>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>
</body>

</html>