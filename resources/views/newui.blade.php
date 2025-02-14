<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Loan Calculator</title>
    <link rel="stylesheet" href="{{asset('css/styles2.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .disabled {
            cursor: not-allowed;
        }

        .dis {
            background-color: #80808036 !important;
            cursor: not-allowed;
        }

        .one-table ul li {
            text-align: left;
        }
    </style>
</head>

<body>
    <!-- Modal -->
    <div class="modal" id="passwordModal">
        <div class="img_logo">
            <img src="{{asset('images/logo.png')}}" alt="" srcset="">
        </div>
        <div class="modal-content">
            <h3>Enter Password To View Calculator</h3>
            <input type="password" id="passwordInput" value="12345" placeholder="Enter password" />
            <button id="submitPassword">
                <span>Submit</span>
                <div class="layer"></div>
            </button>
            <p id="errorMessage" style="color: red; display: none;">Incorrect password. Try again.</p>
        </div>
    </div>
    <!-- Response Modal -->
    <div class="modal2" id="modal2" style="display:none;">
        <div class="resModalContent-modal-content">
            <span class="close" id="closeResModal">&times;</span>
            <div class="resDiv">
                <div class="loan-costs-container">
                    <div class="loan-costs-section">
                        <h2 class="section-title">Loan Costs</h2>
                        <div class="one-table">
                            <div class="cost-item">
                                <span class="item-label">A. Origination Charges</span>
                                <span class="item-value"></span>
                            </div>
                            <ul class="origination-charges-list">
                                <li style="text-align: left;">Underwritting Fee: <span
                                        style="float: right;">$1,050.00</span></li>
                                <li style="text-align: left;display: none;" class="disLi">Discount Points: <span
                                        style="float: right;" class="discont_p">$0.00</span></li>
                            </ul>
                            <div class="cost-item">
                                <span class="item-label">Total Origination Charges</span>
                                <span class="item-value total-origination">$0.00</span>
                            </div>
                        </div>
                        <div class="one-table">
                            <div class="cost-item">
                                <span class="item-label">B. Services You Cannot Shop For</span>
                                <span class="item-value"></span>
                            </div>
                            <ul class="service-cannot-shop-list">
                                <li style="text-align: left;">Appraisal Fee: <span style="float: right;">$650.00</span>
                                </li>
                                <li style="text-align: left;">3rd Party Processing Fee: <span
                                        style="float: right;">$649.00</span></li>
                                <li style="text-align: left;">MERS Fee: <span style="float: right;">$30.00</span></li>
                                <li style="text-align: left;">Life of Loan Flood Fee: <span
                                        style="float: right;">$130.00</span></li>
                                <li style="text-align: left;">Flood Certification Fee: <span
                                        style="float: right;">$35.00</span></li>
                                <li style="text-align: left;">Credit Report Fee: <span
                                        style="float: right;">$85.00</span></li>
                            </ul>
                            <div class="cost-item">
                                <span class="item-label">Total Services You Cannot Shop For</span>
                                <span class="item-value">$ 1,579.00</span>
                            </div>
                        </div>
                        <div class="one-table">
                            <div class="cost-item">
                                <span class="item-label">C. Services You Can Shop For</span>
                                <span class="item-value"></span>
                            </div>
                            <ul class="service-can-shop-list">
                            </ul>
                            <div class="cost-item">
                                <span class="item-label">Total Services You Can Shop For</span>
                                <span class="item-value total-services-shop"></span>
                            </div>
                        </div>
                        <div class="one-table">
                            <div class="cost-item total-cost">
                                <span class="item-label">D. TOTAL LOAN COSTS</span>
                                <span class="item-value total-loan-cost"></span>
                            </div>
                        </div>
                    </div>
                    <div class="other-costs-section">
                        <h2 class="section-title">Other Costs</h2>
                        <div class="one-table bg-dark-gray" style="">
                            <div class="cost-item">
                                <span class="item-label">E. Taxes and Other Government Fees</span>
                                <span class="item-value"></span>
                            </div>
                            <ul class="service-list">
                                <li>Recording Fees and Other Taxes: <span style="float: right;"
                                        class="recording"></span></li>
                                <li>Transfer Taxes: <span style="float: right;" class="tax"></span></li>
                            </ul>
                            <div class="cost-item">
                                <span class="item-label">Total Taxes and Other Government Fees</span>
                                <span class="item-value total-taxes"></span>
                            </div>
                        </div>
                        <!-- <div class="one-table bg-dark-gray" style="background-color: #c99e9e !important; font-size: 11px;">
                            <div class="cost-item">
                                <span class="item-label">E-1. Recording Fee Break Down</span>
                                <span class="item-value"></span>
                            </div>
                            <ul class="service-list recording-breakdown">

                            </ul>
                        </div>
                        <div class="one-table bg-dark-gray" style="background-color: #b88484 !important; font-size: 11px;">
                            <div class="cost-item">
                                <span class="item-label">E-2. Taxes Break Down</span>
                                <span class="item-value"></span>
                            </div>
                            <ul class="service-list tax-breakdown">

                            </ul>
                        </div> -->

                        <div class="one-table">
                            <div class="cost-item">
                                <span class="item-label">F. Pre-Paids</span>
                                <span class="item-value"></span>
                            </div>
                            <ul class="service-list prepaid">

                            </ul>
                            <div class="cost-item">
                                <span class="item-label">Total Pre-Paids</span>
                                <span class="item-value total-prepaid">$0</span>
                            </div>
                        </div>
                        <div class="one-table">
                            <div class="cost-item">
                                <span class="item-label">G. Initial Escrow Payment at Closing </span>
                                <span class="item-value total-escrow">$0</span>
                            </div>
                            <ul class="service-list escrow">

                            </ul>
                            <div class="cost-item">
                                <span class="item-label">Total Initial Escrow Payment at Closing </span>
                                <span class="item-value"></span>
                            </div>
                        </div>
                        <div class="one-table">
                            <div class="cost-item total-cost">
                                <span class="item-label">H. Others</span>
                                <span class="item-value"></span>
                            </div>
                            <ul class="service-list other-fee-list">
                            </ul>
                            <div class="cost-item total-cost">
                                <span class="item-label">Total Others</span>
                                <span class="item-value total-others"></span>
                            </div>
                        </div>
                        <div class="one-table">
                            <div class="cost-item total-cost">
                                <span class="item-label">I. Total Estimated Monthly Housing Payment</span>
                                <span class="item-value"></span>
                            </div>
                            <ul class="service-list est-monthly">
                                <li style="text-align: left;">First Mortgage Payment: <span style="float: right;"
                                        class="f_mortgage">$0.00</span></li>
                                <li style="text-align: left;">Hazard Insurance: <span style="float: right;"
                                        class="monthly_insurance">$0.00</span></li>
                                <li style="text-align: left;">Property Tax: <span style="float: right;"
                                        class="monthly_tax">$0.00</span></li>
                                <li style="text-align: left;">Mortgage Insurance: <span style="float: right;"
                                        class="monthly_mip">$0.00</span></li>
                                <li style="text-align: left;">Monthly HOA Fee: <span style="float: right;"
                                        class="monthly_hoa">$0.00</span></li>
                            </ul>
                            <div class="cost-item total-cost">
                                <span class="item-label">Total Estimated Monthly Housing Payment</span>
                                <span class="item-value total-est-monthly"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Response Modal -->
    <!--Email Modal -->
    <!--Email Modal -->
    <div class="modal1" id="email_modal">
        <div class="modal-content">
            <span class="close" id="close_modal">&times;</span>
            <!--<h3>Enter the email Id you want to sent disastemate</h3>-->
            <input type="text" id="send_email" placeholder="Enter the email Id you want to sent disastemate" />
            <div class="button-container pdf">
                <button class="button btn-pdf disabled" disabled>
                    <span>Download PDF Now</span>
                    <div class="layer"></div>
                </button>
            </div>
            <!--<button class="sendEmail btn-email">Send Email</button>-->
            <div class="button-container pdf">
                <button class="button sendEmail btn-email disabled" disabled>
                    <span>Send PDF</span>
                    <div class="layer"></div>
                </button>
            </div>
        </div>
    </div>
    <!--<div class="flex_btns">-->
    <!--    <div class="pdf">-->
    <!--        <button class="btn-pdf disabled" disabled>Download PDF</button>-->
    <!--    </div>-->
    <!--    <div class="email">-->
    <!--        <button id="open_modal" class="btn-email disabled" disabled>Email</button>-->
    <!--    </div>-->
    <!--</div>-->
    <div class="flex_btns">
        <!-- <div class="pdf">
    <button>Download PDF</button>
  </div> -->
        <!-- <div class="button-container pdf">
            <button class="button btn-pdf disabled" disabled>
                <span>Download PDF</span>
                <div class="layer"></div>
            </button>
        </div> -->
        <!-- <div class="email">
<button id="open_modal">Email</button>
  </div> -->
        <!-- <div class="button-container email">
            <button id="open_modal" class="button btn-email disabled" disable>
                <span>Email</span>
                <div class="layer"></div>
            </button>
        </div> -->
    </div>
    <!-- Calculator -->
    <div class="container outer">
        <div class="calculator-main">
            <div class="calculator">
                <!-- <h2 style="text-align:start;color: rgb(12, 57, 200);">Step 1</h2> -->
                <h3 style="color:white;text-align:center">Loan Calculator - Step 1</h3>




                <!-- Name input fields -->
                <div class="flex_input">
                    <label>Name</label>
                    <div class="down-payment-group">
                        <div class="input-wrapper without-tag two_imput">
                            <input type="text" id="fname" placeholder="First name" />
                        </div>
                        <div class="input-wrapper without-tag two_imput">
                            <input type="text" id="lname" placeholder="Last name" />
                        </div>
                    </div>
                </div>


                <!-- Dropdown for selecting Purchase or Refinance -->
                <div class="flex_input">
                    <label for="loanType">Purchasing / Refinance</label>
                    <div class="input-wrapper without-tag">
                        <select id="loanType">
                            <option value="purchasing">Purchasing</option>
                            <option value="refinance">Refinance</option>
                        </select>
                    </div>
                </div>
                <!-- Refinance Price (Visible for refinance) -->
                <div class="flex_input" id="refinancePriceWrapper">
                    <label for="refinancePrice">Estimated Property Value ($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="text" class="number-input" id="refinancePrice" value="100000"
                            placeholder="Enter refinance price" />
                    </div>
                </div>

                <!-- Purchase Price (Visible for purchasing) -->
                <div class="flex_input" id="purchasePriceWrapper">
                    <label for="purchasePrice">Purchase Price ($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="text" class="number-input" id="purchasePrice" value="100000"
                            placeholder="Enter purchase price" />
                    </div>
                </div>

                <!-- EMD (Visible for purchasing) -->
                <div class="flex_input" id="emdWrapper">
                    <label for="emd">EMD</label>
                    <div class="input-wrapper ">
                        <span>$</span>
                        <input type="number" value="0" id="emd" placeholder="EMD" />
                    </div>
                </div>

                <!-- Down Payment input (Visible only for purchasing) -->
                <div class="flex_input" id="downPaymentWrapper">
                    <label>Down Payment</label>
                    <div class="down-payment-group">
                        <div class="input-wrapper two_imput">
                            <span>%</span>
                            <input type="number" id="downPaymentPercent" value="20" placeholder="Percentage" />
                        </div>
                        <div class="input-wrapper two_imput">
                            <span>$</span>
                            <input type="number" id="downPaymentValue" value="20000" placeholder="Value" />
                        </div>
                    </div>
                </div>
                <!-- LTV input (Editable for refinancing) -->
                <div class="flex_input" id="ltvWrapper">
                    <label for="ltv">Loan to Value (LTV)</label>
                    <div class="input-wrapper ">
                        <span>%</span>
                        <input type="number" id="ltv" value="0" />
                    </div>
                </div>
                <!-- loan amount -->
                <div class="flex_input">
                    <label for="interestRate">Loan Amount ($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="number" id="loan_amount" />
                    </div>
                </div>
                <!-- Loan Term and Interest Rate -->
                <div class="flex_input">
                    <label for="loanTerm">Loan Term (years)</label>
                    <div class="input-wrapper without-tag">
                        <select id="loanTerm">
                            <option value="30">30yrs / 360 months</option>
                            <option value="25">25yrs / 300 months</option>
                            <option value="20">20yrs / 240 months</option>
                            <option value="15">15yrs / 180 months</option>
                            <option value="10">10yrs / 120 months</option>
                        </select>


                        <!-- <input type="number" id="loanTerm" placeholder="Enter loan term in years" value="30" /> -->
                    </div>
                </div>
                <div class="flex_input">
                    <label for="loanTerm">Loan Type</label>
                    <div class="input-wrapper without-tag">
                        <select id="loanType2">
                            <option value="Conventional">Conventional</option>
                            <option value="FHA">FHA</option>
                            <option value="VA">VA</option>
                            <option value="USDA">USDA</option>
                            <option value="Others">Others</option>
                        </select>


                        <!-- <input type="number" id="loanTerm" placeholder="Enter loan term in years" value="30" /> -->
                    </div>
                </div>
                <div class="flex_input">
                    <label for="interestRate">Interest Rate (%)</label>
                    <div class="input-wrapper">
                        <span>%</span>
                        <input type="number" id="interestRate" value="7.09" placeholder="Enter annual interest rate"
                            value="5" />
                    </div>
                </div>
                <div class="flex_input">
                    <label for="interestRate">APR</label>
                    <div class="input-wrapper">
                        <span>%</span>
                        <input type="number" class="dis" id="apr" readonly class="readonly" />
                    </div>
                </div>
                <div class="flex_input">
                    <label for="mip">MIP/PMI</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="number" id="mip" value="0" placeholder="MIP/PMI" />
                    </div>
                </div>

                <!-- Additional fields like Property Taxes, Home Insurance, HOA Fees -->
                <div class="flex_input">
                    <label for="propertyTaxes">Annual Property Taxes ($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="number" onkeyup="calculateMonthlyPayment1()" value="0" id="propertyTaxes"
                            placeholder="Enter annual property taxes" />
                    </div>
                </div>
                <div class="flex_input">
                    <label for="homeInsurance">Annual Home Insurance ($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="number" onkeyup="calculateMonthlyPayment1()" value="0" id="homeInsurance"
                            placeholder="Enter annual home insurance" />
                    </div>
                </div>
                <div class="flex_input">
                    <label for="hoaFees">Monthly HOA Fees ($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="number" id="hoaFees" onkeyup="calculateMonthlyPayment1()" value="0"
                            placeholder="Enter monthly HOA fees" />
                    </div>
                </div>
                <div class="flex_input">
                    <label for="seller_assistance">Seller's Assistance($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="number" id="seller_assistance" value="0" placeholder="Enter Seller's Assistance" />
                    </div>
                </div>
                <div class="flex_input">
                    <label for="discount_points">Discount Points($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="number" id="discount_points" value="0" placeholder="Enter Discount Points" />
                    </div>
                </div>

            </div>

            <div class="calculator-right">
                <div class="result_outer">
                    <div class="subjected_info">
                        <!-- Subject Address input -->
                        <div>
                            <!-- <h2 style="text-align:start;color: rgb(12, 57, 200);">Step 2</h2> -->
                            <h3>Subject Property</h3>

                        </div>
                        <div class="right_input_flex" style="width: 100%;">
                            <label for="subject">Subject Address</label>
                            <div class="right-input">
                                <input type="text" id="subject" placeholder="12 Washington Plaza" />
                            </div>
                        </div>
                        <div class="flex_main">
                            <div class="right_input_flex">
                                <label for="city">City</label>
                                <div class="right-input">
                                    <input type="text" class="dis" id="city" placeholder="e.g. Hialeah"
                                        style=" cursor: not-allowed;" readonly />
                                </div>
                            </div>
                            <div class="right_input_flex">
                                <label for="state">State</label>
                                <div class="right-input">
                                    <input type="text" class="dis" id="state" placeholder="e.g. Florida"
                                        style=" cursor: not-allowed;" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="flex_main">
                            <div class="right_input_flex">
                                <label for="zip">Zip</label>
                                <div class="right-input">
                                    <input type="text" class="dis" id="zip" placeholder="e.g. 33015"
                                        style=" cursor: not-allowed;" readonly />
                                </div>
                            </div>
                            <div class="right_input_flex">
                                <label for="county">County</label>
                                <div class="right-input">
                                    <input type="text" class="dis" id="county" placeholder="e.g. Miami-Dade"
                                        style=" cursor: not-allowed;" readonly />
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="get_fees">
                        <div style="margin-right:20px">
                            <h3>Step 2</h3>
                        </div>
                        <div style="display: flex;align-items: center;">
                            <button>
                                <span>Get Fees</span>
                                <div class="layer"></div>
                            </button>
                        </div>
                    </div>
                    <hr style="display:none">
                    <div class="blue-box" style="display:none">
                        <div class="blue_flex">
                            <div class="blue_left">
                                Loan Amount
                            </div>
                            <div class="blue_right">
                                $5637.33
                            </div>

                        </div>
                        <div class="blue_flex">
                            <div class="blue_left">
                                Anual Tax
                            </div>
                            <div class="blue_right">
                                $5t657.33
                            </div>

                        </div>
                        <div class="blue_flex">
                            <div class="blue_left">
                                Anual Tax
                            </div>
                            <div class="blue_right">
                                $5t657.33
                            </div>

                        </div>
                        <div class="blue_flex">
                            <div class="blue_left">
                                Anual Tax
                            </div>
                            <div class="blue_right">
                                $5t657.33
                            </div>

                        </div>
                        <div class="blue_flex">
                            <div class="blue_left">
                                Anual Tax
                            </div>
                            <div class="blue_right">
                                $5t657.33
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="result" style="margin-top: 10px;">
                        <div class="top_res">
                            <div class="result_label ">Est. monthly payment</div>
                            <div class="result_data result_data_top">$<span id="monthlyPayment">0.00</span></div>
                        </div>
                        <div class="progress-container">
                            <div class="progress-bar">
                                <div class="progress-segment principal-interest" style="width: 0%;"></div>
                                <div class="progress-segment home-insurance" style="width: 0%;"></div>
                                <div class="progress-segment property-tax" style="width: 0%;"></div>
                                <div class="progress-segment hoa-fees" style="width: 0%;"></div>
                            </div>
                        </div>

                        <div class="flex-result">
                            <div class="label1">
                                <div class="result_label result_label1">Principal & Interest </div>
                                <div class="result_data">$<span id="principalInterest">0.00</span></div>
                            </div>
                            <div class="label2">
                                <div class="result_label result_label2">Home Insurance</div>
                                <div class="result_data">$<span id="homeInsuranceDisplay">0.00</span></div>
                            </div>

                        </div>
                        <div class="flex-result">
                            <div class="label1">
                                <div class="result_label result_label3">Property Tax </div>
                                <div class="result_data">$<span id="propertyTaxDisplay">0.00</span></div>
                            </div>
                            <div class="label2">
                                <div class="result_label result_label4">HOA Fees </div>
                                <div class="result_data">$<span id="hoaFeesDisplay">0.00</span></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="calculator-main">
            <div class="calculator">
                <div class="user_form">
                    <form action="">
                        <div style="margin: auto;margin-top: 20px;">
                            <!-- <h2 style="text-align:start;color: rgb(12, 57, 200);">Step 3</h2> -->
                            <h3>LO Profile</h3>

                            <div class="flex_input">
                                <label for="name">Name</label>
                                <div class="input-wrapper without-tag">
                                    <input type="text" id="name" placeholder="Name" />
                                </div>
                            </div>
                            <div class="flex_input">
                                <label for="title">Title</label>
                                <div class="input-wrapper without-tag">
                                    <input type="text" id="title" placeholder="Title" />
                                </div>
                            </div>
                            <div class="flex_input">
                                <label for="phone">Phone Number:</label>
                                <div class="input-wrapper without-tag">
                                    <input type="phone" id="phone" placeholder="Enter phone number" />
                                </div>
                            </div>
                            <div class="flex_input">
                                <label for="email">Email</label>
                                <div class="input-wrapper without-tag">
                                    <input type="phone" id="email" placeholder="Enter email" />
                                </div>
                            </div>
                            <div class="flex_input">
                                <label for="email">License #</label>
                                <div class="input-wrapper without-tag">
                                    <input type="phone" id="license_no" placeholder="Enter license number" />
                                </div>
                            </div>
                            <!-- Upload input -->
                            <div class="flex_input">
                                <label for="img">Upload <br> Head shots/Interchangeable</label>
                                <div class="input-wrapper without-tag">
                                    <input type="file" id="img" />
                                </div>
                            </div>
                            <!--<div class="submit_user">-->
                            <!--    <button>Submit</button>-->
                            <!--</div>-->
                            <div style="text-align: end;">
                                <div class="button-container">
                                    <button class="button" onclick="opensendModal()" id="open_modal">
                                        <span>Final Step</span>
                                        <div class="layer"></div>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div class="calculator-right">

            </div>

        </div>
    </div>
    <script>
        var letSend = false;
        var township = 'All Townships';
        var state_short_name = '';
        var county = '';
        var sendingemail = '';
        var fee_response_json = {};
    </script>
    <script>
        function opensendModal() {
            // prevent form submission
            event.preventDefault();
            if (letSend) {
                const modal = document.getElementById('email_modal');
                modal.style.display = 'flex';
            } else {
                toastr.error('Please fill all the fields and generate fee first.', '', {
                    timeOut: 1000 // Auto-dismiss after 1 second
                });
            }


        }
    </script>
    <script src="{{asset('js/script2.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.querySelector('.get_fees button').addEventListener('click', function (e) {
            // validate first. Following fields are required state, county, and purchase price/Estimated Property Value based on loanType
            if ($('#state').val() == '') {
                toastr.error('Please select a valid address', '', {
                    timeOut: 1000 // Auto-dismiss after 1 second
                });
                return;
            }

            if ($('#purchasePrice').val() == '' && $('#refinancePrice').val() == '') {
                toastr.error('Please enter purchase price or Estimated Property Value', '', {
                    timeOut: 1000 // Auto-dismiss after 1 second
                });
                return;
            }


            e.preventDefault();
            // disable get fee button and change text to fetching
            document.querySelector('.get_fees button').classList.add('disabled');
            document.querySelector('.get_fees button').innerHTML = 'Fetching...';
            // fetch all the fields and make an ajax request to the backend
            const formData = collectFormData();
            formData['state'] = state_short_name;
            formData['county'] = county;
            formData['township'] = township;
            $.ajax({
                url: 'getfees',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    data: formData
                },
                success: function (response) {
                    letSend = true;
                    document.querySelector('.get_fees button').classList.remove('disabled');
                    document.querySelector('.get_fees button').innerHTML = 'Get Fees';
                    fee_response_json = response;
                    console.log(fee_response_json);
                    formatRes(response)
                    resmodal.style.display = 'flex';
                    toastr.success('Fees calculated successfully', '', {
                        timeOut: 1000 // Auto-dismiss after 1 second
                    });

                    document.querySelector('.btn-email').classList.remove('disabled');
                    document.querySelector('.btn-email').removeAttribute('disabled');
                    document.querySelector('.btn-pdf').classList.remove('disabled');
                    document.querySelector('.btn-pdf').removeAttribute('disabled');
                },
                error: function (error) {
                    letSend = false;
                    document.querySelector('.get_fees button').classList.remove('disabled');
                    document.querySelector('.get_fees button').innerHTML = 'Get Fees';
                    console.log(error);
                    toastr.error('Error getting fees', '', {
                        timeOut: 1000 // Auto-dismiss after 1 second
                    });

                }
            });


        });

        function formatRes(response) {
            // Close modal if already open
            resmodal.style.display = 'none';
            var serviceCanShopList = document.querySelector('.service-can-shop-list');
            serviceCanShopList.innerHTML = '';
            response.data.services_you_can_shop_for.forEach(function (fee) {
                var li = document.createElement('li');
                li.innerHTML = fee.FeeName + ': <span style="float: right;">$' + convertToMoney(fee.Amount) + '</span>';
                serviceCanShopList.appendChild(li);
            });

            var totalServicesShop = document.querySelectorAll('.total-services-shop');
            totalServicesShop.innerHTML = '';
            totalServicesShop.forEach(function (total) {
                total.innerHTML = '$' + convertToMoney(response.data.total_loan_cost);
                // the variable total_loan_cost only givesfor services you can shop for dont get confused
            });
            $total_loan_cost = document.querySelector('.total-loan-cost');
            $total_loan_cost_value = response.data.total_loan_cost + 1579 + 1050 + parseFloat($('#discount_points').val());
            $total_loan_cost.innerHTML = '$' + convertToMoney($total_loan_cost_value);
            // in discont_p show value of input discount_points
            var discont_p = document.querySelector('.discont_p');
            discont_p.innerHTML = '';
            if ($('#discount_points').val() == '' || $('#discount_points').val() == 0 || $('#discount_points').val() == null) {
                document.querySelector('.disLi').style.display = 'none';
            } else {
                document.querySelector('.disLi').style.display = 'block';
            }
            discont_p.innerHTML = '$' + convertToMoney($('#discount_points').val());
            // in total-origination show 1050.00 + discount_points value
            var totalOrigination = document.querySelectorAll('.total-origination');
            totalOrigination.innerHTML = '';
            totalOrigination.forEach(function (total) {
                total.innerHTML = '$' + convertToMoney((1050 + parseFloat($('#discount_points').val())));
            });
            // if there is a Deed Fee in recording_fee then console log it

            // taxes_and_other_govt_fees contains two things
            // transfer_tax and recording_fee
            // in class span tax show transfer_tax and recording show recording_fee
            var totalTaxes = document.querySelectorAll('.total-taxes');
            totalTaxes.innerHTML = '';
            totalTaxes.forEach(function (total) {
                total.innerHTML = '$' + convertToMoney((response.data.taxes_and_other_govt_fees.transfer_tax + response.data.taxes_and_other_govt_fees.recording_fee));
            });

            var tax = document.querySelector('.tax');
            tax.innerHTML = '';
            tax.innerHTML = '$' + convertToMoney(response.data.taxes_and_other_govt_fees.transfer_tax);

            var recording = document.querySelector('.recording');
            recording.innerHTML = '';
            recording.innerHTML = '$' + convertToMoney(response.data.taxes_and_other_govt_fees.recording_fee);
            // Table I
            // total-est-monthly, monthly_mip,monthly_tax, monthly_insurance get these



            // get these mip, homeInsurance, propertyTaxes

            var homeInsurance = document.querySelector('#homeInsurance');
            var propertyTaxes = document.querySelector('#propertyTaxes');

            // in prepaid show mip, homeInsurance, propertyTaxes with title on left and values on right side
            var prepaid = document.querySelector('.prepaid');
            prepaid.innerHTML = '';


            var li = document.createElement('li');
            li.innerHTML = 'Home Insurance (5 months): <span style="float: right;">$' + convertToMoney(((parseFloat(homeInsurance.value) / 12) * 5).toFixed(2)) + '</span>';
            prepaid.appendChild(li);

            var li = document.createElement('li');
            li.innerHTML = 'Property Taxes (5 months): <span style="float: right;">$' + convertToMoney(((parseFloat(propertyTaxes.value) / 12) * 5).toFixed(2)) + '</span>';
            prepaid.appendChild(li);


            // show in total-prepaid the total of mip, homeInsurance, propertyTaxes with formula applied
            var totalPrepaid = document.querySelectorAll('.total-prepaid');
            totalPrepaid.innerHTML = '';
            totalPrepaid.forEach(function (total) {
                total.innerHTML = '$' + convertToMoney((((parseFloat(homeInsurance.value) / 12) * 5) + ((parseFloat(propertyTaxes.value) / 12) * 5)).toFixed(2));
            });


            // in escrow show mip, homeInsurance, propertyTaxes with title on left and values on right side
            var escrow = document.querySelector('.escrow');
            escrow.innerHTML = '';


            var li = document.createElement('li');
            li.innerHTML = 'Home Insurance (2 months): <span style="float: right;">$' + convertToMoney(((parseFloat(homeInsurance.value) / 12) * 2).toFixed(2)) + '</span>';
            escrow.appendChild(li);

            var li = document.createElement('li');
            li.innerHTML = 'Property Taxes (2 months): <span style="float: right;">$' + convertToMoney(((parseFloat(propertyTaxes.value) / 12) * 2).toFixed(2)) + '</span>';
            escrow.appendChild(li);

            // show in total-escrow the total of mip, homeInsurance, propertyTaxes with formula applied
            var totalEscrow = document.querySelectorAll('.total-escrow');
            totalEscrow.innerHTML = '';
            totalEscrow.forEach(function (total) {
                total.innerHTML = '$' + convertToMoney((((parseFloat(homeInsurance.value) / 12) * 2) + ((parseFloat(propertyTaxes.value) / 12) * 2)).toFixed(2));
            });
            // Table I
            var mip = document.querySelector('#mip');
            var monthly_mip = document.querySelector('.monthly_mip');
            monthly_mip.innerHTML = '$' + convertToMoney((parseFloat(mip.value) || 0).toFixed(2));
            var hoa = document.querySelector('#hoaFees');
            var monthly_hoa = document.querySelector('.monthly_hoa');
            monthly_hoa.innerHTML = '$' + convertToMoney((parseFloat(hoa.value) || 0).toFixed(2));
            var monthly_tax = document.querySelector('.monthly_tax');
            monthly_tax.innerHTML = '';
            monthly_tax.innerHTML = '$' + convertToMoney((parseFloat(propertyTaxes.value) / 12).toFixed(2));
            var monthly_insurance = document.querySelector('.monthly_insurance');
            monthly_insurance.innerHTML = '';
            monthly_insurance.innerHTML = '$' + convertToMoney((parseFloat(homeInsurance.value) / 12).toFixed(2));
            var f_mortgage = document.querySelector('.f_mortgage');
            f_mortgage.innerHTML = '';
            f_mortgage.innerHTML = '$' + convertToMoney(calFirstMortgage());
            var totalEstMonthly = document.querySelectorAll('.total-est-monthly');
            totalEstMonthly.innerHTML = '';
            totalEstMonthly.forEach(function (total) {
                total.innerHTML = '$' + convertToMoney((parseFloat(mip.value) + parseFloat(hoa.value) + (parseFloat(homeInsurance.value) / 12) + (parseFloat(propertyTaxes.value) / 12) + calFirstMortgage()).toFixed(2));
            });


            // in response other_fees contains other fee items
            // other_fees in ul witht his class show the list of other fees same way
            var otherFeeList = document.querySelector('.other-fee-list');
            otherFeeList.innerHTML = '';
            for (var key in response.data.other_fees) {
                var li = document.createElement('li');
                li.innerHTML = key + ': <span style="float: right;">$' + convertToMoney(response.data.other_fees[key]) + '</span>';
                otherFeeList.appendChild(li);
            }

            var totalOthers = document.querySelectorAll('.total-others');
            totalOthers.innerHTML = '';
            totalOthers.forEach(function (total) {
                var totalAmount = 0;
                for (var key in response.data.other_fees) {
                    totalAmount += response.data.other_fees[key];
                }
                total.innerHTML = '$' + convertToMoney(totalAmount);
            });

            // show transfer_fee_breakdown as li(s) in tax-breakdown
            // var taxBreakdown = document.querySelector('.tax-breakdown');
            // taxBreakdown.innerHTML = '';
            // response.data.transfer_fee_breakdown.forEach(function(fee) {
            //     var li = document.createElement('li');
            //     li.innerHTML = fee.FeeName + ': <span style="float: right;">$' + fee.Amount + '</span>';
            //     taxBreakdown.appendChild(li);
            // });

            // // show recording_fee_breakdown as li(s) in recording-breakdown
            // var recordingBreakdown = document.querySelector('.recording-breakdown');
            // recordingBreakdown.innerHTML = '';
            // response.data.recording_fee_breakdown.forEach(function(fee) {
            //     var li = document.createElement('li');
            //     li.innerHTML = fee.FeeName + ': <span style="float: right;">$' + fee.Amount + '</span>';
            //     recordingBreakdown.appendChild(li);
            // });
            resmodal.style.display = 'flex';
        }




        function collectFormData() {
            const formData = {};
            const formElements = document.querySelectorAll('.calculator input, .calculator select, .calculator textarea'); // Adjust selector as needed
            // add into formData the values of selects with id state, county and township
            formData['state'] = $('#state').val();
            formData['county'] = "New London";
            formData['township'] = "All Townships";
            formElements.forEach(element => {
                if (element.type === 'checkbox') {
                    formData[element.id] = element.checked;
                } else if (element.type === 'radio') {
                    if (element.checked) {
                        formData[element.name] = element.value;

                    }
                } else {
                    formData[element.id] = element.value;
                }

            });


            return formData;
        }
        $('.btn-pdf').click(function () {
            console.log("PDF clicked");
            var formdata = buildRequest();
            if (!formdata) {
                console.log('Invalid form data');
                return;
            }
            var button = $(this);
            button.html('Generating...');
            button.prop('disabled', true);
            formdata.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: 'generatepdf',
                type: 'POST',
                data: formdata,
                contentType: false,
                processData: false,
                success: function (response) {
                    // Create a download link
                    var link = document.createElement('a');
                    link.href = response.pdf_url; // URL of the generated PDF
                    link.download = 'generated_file.pdf'; // Name of the downloaded file
                    link.click();

                    // Wait 5 seconds to ensure download before deletion
                    setTimeout(function () {
                        $.ajax({
                            url: response.delete_url, // Delete URL provided by the backend
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function () {
                                console.log('Temporary PDF file deleted successfully');
                            },
                            error: function () {
                                console.log('Failed to delete temporary PDF file');
                            },
                        });
                    }, 5000); // Delay of 5 seconds

                    // Reset button state
                    button.html('Download PDF');
                    button.prop('disabled', false);

                    toastr.success('PDF downloaded successfully', '', {
                        timeOut: 1000, // Auto-dismiss after 1 second
                    });
                },
                error: function (error) {
                    console.log(error);

                    // Reset button state
                    button.html('Download PDF');
                    button.prop('disabled', false);

                    toastr.error('Error generating PDF', '', {
                        timeOut: 1000, // Auto-dismiss after 1 second
                    });
                },
            });
        });
        $('.btn-email').click(function () {
            modal.style.display = 'flex';
        });

        function buildRequest() {
            // ids of fields of which data i need to build
            // fname, lname, loanType, refinancePrice, purchasePrice, emd, downPaymentPercent, downPaymentValue, ltv, loan_amount, loanTerm, loanType2, interestRate, apr, mip, hoaFees
            // name, title, phone, email, license_no,img
            // subject, city, state, zip, county
            if (typeof fee_response_json === 'undefined') {
                toastr.error('Fee response is missing', '', {
                    timeOut: 1000,
                });
                return null; // Return null if any required variable is undefined
            }
            // get all the values
            var fname = $('#fname').val();
            var lname = $('#lname').val();
            var loanType = $('#loanType').val();
            var refinancePrice = $('#refinancePrice').val();
            var purchasePrice = $('#purchasePrice').val();
            var emd = $('#emd').val();
            var downPaymentPercent = $('#downPaymentPercent').val();
            var downPaymentValue = $('#downPaymentValue').val();
            var ltv = $('#ltv').val();
            var loan_amount = $('#loan_amount').val();
            var loanTerm = $('#loanTerm').val();
            var loanType2 = $('#loanType2').val();
            var interestRate = $('#interestRate').val();
            var apr = $('#apr').val();
            var mip = $('#mip').val();
            var hoaFees = $('#hoaFees').val();
            var propertyTaxes = $('#propertyTaxes').val();
            var homeinsurance = $('#homeInsurance').val();
            var name = $('#name').val();
            var title = $('#title').val();
            var phone = $('#phone').val();
            var email = $('#email').val();
            var license_no = $('#license_no').val();
            var img = $('#img')[0].files[0];
            var subject = $('#subject').val();
            var city = $('#city').val();
            var state = $('#state').val();
            var zip = $('#zip').val();
            var county = $('#county').val();
            var discount_points = $('#discount_points').val();
            var seller_assistance = $('#seller_assistance').val();

            // if(purchasePrice and refinancePrice is empty) then show error
            if (purchasePrice == '' && refinancePrice == '') {
                toastr.error('Please enter Purchase Price or Estimated Property Value', '', {
                    timeOut: 1000 // Auto-dismiss after 1 second
                });
                return;
            }

            // if loanType opotion value purchasing selected then
            if (loanType == 'purchasing') {
                if (purchasePrice == '') {
                    toastr.error('Please enter Purchase Price', '', {
                        timeOut: 1000 // Auto-dismiss after 1 second
                    });
                    return;
                }

                if (emd == '') {
                    toastr.error('Please enter EMD', '', {
                        timeOut: 1000 // Auto-dismiss after 1 second
                    });
                    return;
                }
            } else if (loanType == 'refinance') {
                if (refinancePrice == '') {
                    toastr.error('Please enter Estimated Property Value', '', {
                        timeOut: 1000 // Auto-dismiss after 1 second
                    });
                    return;
                }
            }

            // if(any other thant hese fields empty show error message)
            if (fname == '' || lname == '' || loanType == '' || loanType2 == '' || loanTerm == '' || interestRate == '' || mip == '' || hoaFees == '' || name == '' || title == '' || phone == '' || email == '' || license_no == '' || subject == '' || city == '' || state == '' || zip == '' || county == '') {
                toastr.error('Please fill all the fields', '', {
                    timeOut: 1000 // Auto-dismiss after 1 second
                });
                return;
            }

            // if no img uploaded show error
            if (!img) {
                toastr.error('Please upload an image', '', {
                    timeOut: 1000 // Auto-dismiss after 1 second
                });
                return;
            }

            // if email is not a valid email type input show error
            if (!validateEmail(email)) {
                toastr.error('Please enter a valid email', '', {
                    timeOut: 1000 // Auto-dismiss after 1 second
                });
                return;
            }

            // make a formdata out of these

            var formData = new FormData();
            formData.append('fname', fname);
            formData.append('lname', lname);
            formData.append('loanType', loanType);
            formData.append('refinancePrice', refinancePrice);
            formData.append('purchasePrice', purchasePrice);
            formData.append('emd', emd);
            formData.append('downPaymentPercent', downPaymentPercent);
            formData.append('downPaymentValue', downPaymentValue);
            formData.append('ltv', ltv);
            formData.append('loan_amount', loan_amount);
            formData.append('loanTerm', loanTerm);
            formData.append('loanType2', loanType2);
            formData.append('interestRate', interestRate);
            formData.append('apr', apr);
            formData.append('mip', mip);
            formData.append('hoaFees', hoaFees);
            formData.append('propertyTaxes', propertyTaxes);
            formData.append('homeinsurance', homeinsurance);
            formData.append('seller_assistance', seller_assistance);
            formData.append('principalAndInterest', calFirstMortgage());
            formData.append('name', name);
            formData.append('title', title);
            formData.append('phone', phone);
            formData.append('email', email);
            formData.append('license_no', license_no);
            formData.append('img', img);
            formData.append('subject', subject);
            formData.append('city', city);
            formData.append('state', state);
            formData.append('zip', zip);
            formData.append('county', county);
            formData.append('discount_points', discount_points);
            formData.append('sendingemail', sendingemail);
            formData.append('fee_response_json', JSON.stringify(fee_response_json));

            return formData;

        }


        function calFirstMortgage() {
            const loanAmount = parseFloat(document.getElementById('loan_amount').value) || "";
            const loanTerm = parseFloat(document.getElementById('loanTerm').value) || 0;
            const interestRate = parseFloat(document.getElementById('interestRate').value) || 0;

            // Monthly Interest Rate & Total Payments
            const monthlyRate = interestRate / 100 / 12;
            const totalPayments = loanTerm * 12;

            let principalAndInterest = 0;
            if (monthlyRate === 0) {
                principalAndInterest = loanAmount / totalPayments;
            } else {
                principalAndInterest = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, totalPayments)) /
                    (Math.pow(1 + monthlyRate, totalPayments) - 1);
            }

            return principalAndInterest;
        }

        function validateEmail(email) {
            var re = /\S+@\S+\.\S+/;
            return re.test(email);
        }
        $('.sendEmail').click(function () {
            var button = $(this);
            button.html('Sending...');
            button.prop('disabled', true);
            sendingemail = $('#send_email').val();
            if (email == '') {
                toastr.error('Please enter email', '', {
                    timeOut: 1000 // Auto-dismiss after 1 second
                });
                button.html('Send PDF');
                button.prop('disabled', false);
                return;
            }
            // if email is not a valid email type input show error
            if (!validateEmail(email)) {
                // toastr.error('Please enter a valid email', '', {
                //     timeOut: 1000 // Auto-dismiss after 1 second
                // });
                // button.html('Send PDF');
                // button.prop('disabled', false);
                // return;
            }
            var formData2 = buildRequest();
            if (!formData2) {
                console.log('Invalid form data');
                button.html('Send PDF');
                button.prop('disabled', false);
                return;
            }
            formData2.append('_token', $('meta[name="csrf-token"]').attr('content'));
            console.log(formData2);


            $.ajax({
                url: 'sendpdf',
                type: 'POST',
                data: formData2,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status == 'success') {
                        button.html('Send PDF');
                        button.prop('disabled', false);
                        toastr.success('PDF sent successfully', '', {
                            timeOut: 1000 // Auto-dismiss after 1 second
                        });
                    } else {
                        button.html('Send PDF');
                        button.prop('disabled', false);
                        toastr.error('Error sending PDF', '', {
                            timeOut: 1000 // Auto-dismiss after 1 second
                        });
                    }

                },
                error: function (error) {
                    console.log(error);
                    button.html('Send PDF');
                    button.prop('disabled', false);
                    toastr.error('Error sending PDF', '', {
                        timeOut: 1000 // Auto-dismiss after 1 second
                    });
                }

            });
        });
    </script>

    <script>
        function initMap() {
            // Get the input element
            const input = document.getElementById('subject');

            // Initialize Google Places Autocomplete
            const autocomplete = new google.maps.places.Autocomplete(input);

            // Set the fields to retrieve from the API
            autocomplete.setFields(['geometry', 'formatted_address', 'address_components']);

            // Add an event listener for when a place is selected
            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();

                // Check if the selected place has geometry data
                if (!place.geometry) {
                    console.error('Place has no geometry data');
                    return;
                }

                // Function to get a specific address component
                function getAddressComponent(place, type, nameType) {
                    const component = place.address_components.find(c => c.types.includes(type));
                    return component ? component[nameType] : null;
                }

                // Retrieve the desired components
                state_short_name = getAddressComponent(place, 'administrative_area_level_1', 'short_name') || 'Not Found';
                var state_long_name = getAddressComponent(place, 'administrative_area_level_1', 'long_name') || 'Not Found';
                county = (getAddressComponent(place, 'administrative_area_level_2', 'long_name') || 'Not Found').replace(' County', '');
                township = getAddressComponent(place, 'locality', 'long_name') || 'All Townships';
                var city = getAddressComponent(place, 'locality', 'long_name') || county || 'Not Found';
                var zip = getAddressComponent(place, 'postal_code', 'long_name') || 'Not Found';

                document.getElementById('state').value = state_long_name;
                document.getElementById('county').value = county;
                document.getElementById('city').value = city;
                document.getElementById('zip').value = zip;

                console.log('State:', state_short_name);
                console.log('County:', county);
                console.log('Township:', township);
            });
        }


        function getAddressComponent(place, type) {
            for (const component of place.address_components) {
                if (component.types.includes(type)) {
                    return component.long_name;
                }
            }
            return '';
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBy2l4KGGTm4cTqoSl6h8UAOAob87sHBsA&libraries=places&callback=initMap"
        async defer></script>
    <script>
        function convertToMoney(val) {
            // console.log("before" + val);

            let num = parseFloat(val);

            // Check if the conversion is valid
            if (isNaN(num)) return 0;
            // console.log("after" + num.toLocaleString("en-US", {
            //     minimumFractionDigits: 2,
            //     maximumFractionDigits: 2
            // }));
            // Format the number with commas and two decimal places
            return num.toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    </script>
</body>

</html>