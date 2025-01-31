<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Loan Calculator</title>
    <link rel="stylesheet" href="{{asset('css/styles2.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .disabled {
            cursor: not-allowed;
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
            <input type="password" id="passwordInput" value="" placeholder="Enter password" />
            <button id="submitPassword">Submit</button>
            <p id="errorMessage" style="color: red; display: none;">Incorrect password. Try again.</p>
        </div>
    </div>
    <!-- Response Modal -->
    <div class="modal2" id="modal2" style="display:none;">
        <div class="modal-content resModalContent">
            <span class="close" id="closeResModal">&times;</span>
            <div class="resDiv"></div>
        </div>
    </div>
    <!-- Response Modal -->
    <!--Email Modal -->
    <!--Email Modal -->
    <div class="modal1" id="email_modal">
        <div class="modal-content">
            <span class="close" id="close_modal">&times;</span>
            <h3>Enter email to send pdf</h3>
            <input type="text" id="send_email" placeholder="Enter email" />
            <button class="sendEmail">Send PDF</button>
        </div>
    </div>
    <div class="flex_btns">
        <div class="pdf">
            <button class="btn-pdf disabled" disabled>Download PDF</button>
        </div>
        <div class="email">
            <button id="open_modal" class="btn-email disabled" disabled>Email</button>
        </div>
    </div>
    <!-- Calculator -->
    <div class="container outer">
        <div class="calculator-main">
            <div class="calculator">
                <h2>Loan Calculator</h2>



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
                        <input type="text" class="number-input" id="refinancePrice" value="100000" placeholder="Enter refinance price" />
                    </div>
                </div>

                <!-- Purchase Price (Visible for purchasing) -->
                <div class="flex_input" id="purchasePriceWrapper">
                    <label for="purchasePrice">Purchase Price ($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="text" class="number-input" id="purchasePrice" value="100000" placeholder="Enter purchase price" />
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
                        <input type="number" id="ltv" class="readonly" />
                    </div>
                </div>
                <!-- loan amount -->
                <div class="flex_input">
                    <label for="interestRate">Loan Amount ($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="number" id="loan_amount" readonly class="readonly" />
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
                        <input type="number" id="interestRate" value="7.09" placeholder="Enter annual interest rate" value="5" />
                    </div>
                </div>
                <div class="flex_input">
                    <label for="interestRate">APR</label>
                    <div class="input-wrapper">
                        <span>%</span>
                        <input type="number" id="apr" readonly class="readonly" />
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
                <div class="flex_input" style="display: none;">
                    <label for="propertyTaxes">Annual Property Taxes ($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="number" onkeyup="calculateMonthlyPayment1()" value="0" id="propertyTaxes" placeholder="Enter annual property taxes" />
                    </div>
                </div>
                <div class="flex_input" style="display: none;">
                    <label for="homeInsurance">Annual Home Insurance ($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="number" onkeyup="calculateMonthlyPayment1()" value="0" id="homeInsurance" placeholder="Enter annual home insurance" />
                    </div>
                </div>
                <div class="flex_input">
                    <label for="hoaFees">Monthly HOA Fees ($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="number" id="hoaFees" onkeyup="calculateMonthlyPayment1()" value="0" placeholder="Enter monthly HOA fees" />
                    </div>
                </div>

                <div class="get_fees">
                    <button>Get Fees</button>
                </div>
                <div class="user_form">
                    <form action="">
                        <div style="margin: auto;margin-top: 20px;">
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
                            <div class="submit_user">
                                <button>Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div class="calculator-right">
                <div class="result_outer">
                    <div class="subjected_info">
                        <!-- Subject Address input -->
                        <div>
                            <h3>Subject Property</h3>
                        </div>
                        <div class="right_input_flex" style="width: 100%;">
                            <label for="subject">Subject Address</label>
                            <div class="right-input">
                                <input type="text" id="subject" placeholder="12 Washington Plaza" style="width: 100%;" />
                            </div>
                        </div>
                        <div class="flex_main">
                            <div class="right_input_flex">
                                <label for="city">City</label>
                                <div class="right-input">
                                    <input type="text" id="city" placeholder="e.g. Lebanon" style="width: 100%; cursor: not-allowed;" readonly />
                                </div>
                            </div>
                            <div class="right_input_flex">
                                <label for="state">State</label>
                                <div class="right-input">
                                    <input type="text" id="state" placeholder="e.g. Conneticut" style="width: 100%; cursor: not-allowed;" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="flex_main">
                            <div class="right_input_flex">
                                <label for="zip">Zip</label>
                                <div class="right-input">
                                    <input type="text" id="zip" placeholder="e.g. 21311" style="width: 100%; cursor: not-allowed;" readonly />
                                </div>
                            </div>
                            <div class="right_input_flex">
                                <label for="county">County</label>
                                <div class="right-input">
                                    <input type="text" id="county" placeholder="e.g. New London" style="width: 100%; cursor: not-allowed;" readonly />
                                </div>
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
                                <div class="result_label result_label4">HOA Fees </div>
                                <div class="result_data">$<span id="hoaFeesDisplay">0.00</span></div>
                            </div>
                        </div>
                        <div class="flex-result" style="display: none;">
                            <div class="label1" style="display: none;">
                                <div class="result_label result_label3">Property Tax </div>
                                <div class="result_data">$<span id="propertyTaxDisplay">0.00</span></div>
                            </div>
                            <div class="label2" style="display: none;">
                                <div class="result_label result_label2">Home Insurance</div>
                                <div class="result_data">$<span id="homeInsuranceDisplay">0.00</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        var township = 'All Townships';
        var state_short_name = '';
        var county = '';
        var sendingemail = '';
        var fee_response_json = {};
    </script>
    <script src="{{asset('js/script2.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.querySelector('.get_fees button').addEventListener('click', function(e) {
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
                success: function(response) {
                    document.querySelector('.get_fees button').classList.remove('disabled');
                    document.querySelector('.get_fees button').innerHTML = 'Get Fees';
                    fee_response_json = response;
                    console.log(fee_response_json);
                    // const formattedHTML = formatRes(response);
                    // $('.resDiv').html('<h3>API Response</h3>' + formattedHTML);
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
                error: function(error) {

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

            // Start building the modal content
            let modalContent = `<h3 style="text-align: center; color: #333;">API Response</h3>`;

            // Function to generate table rows for a given fee category
            const generateTable = (data, title) => {
                let table = `<h4 style="color: #444; font-size: 18px; margin-top: 20px;">${title}</h4>`;
                table += `<table style="width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid #ccc;">`;
                table += `<thead><tr><th style="padding: 8px; background-color: #f4f4f4; border: 1px solid #ddd;">Fee Title</th><th style="padding: 8px; background-color: #f4f4f4; border: 1px solid #ddd;">Fee Amount</th></tr></thead><tbody>`;

                // Loop through the fee items and populate the table
                data.forEach(item => {
                    table += `
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;">${item.FeeName}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">$${item.Amount}</td>
                </tr>
            `;
                });

                table += `</tbody></table>`;
                return table;
            };

            // Borrower fees
            if (response.fees && response.fees.title_agent_fees && response.fees.title_agent_fees.borrower) {
                modalContent += generateTable(response.fees.title_agent_fees.borrower, 'Borrower Agent Fees');
            }

            // Seller fees
            if (response.fees && response.fees.title_agent_fees && response.fees.title_agent_fees.seller.length > 0) {
                modalContent += generateTable(response.fees.title_agent_fees.seller, 'Seller Agent Fees');
            }

            // Recording fees
            if (response.fees && response.fees.recording_fees && response.fees.recording_fees.length > 0) {
                let recordingFees = `<h4 style="color: #444; font-size: 18px; margin-top: 20px;">Recording Fees</h4>`;
                recordingFees += `<table style="width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid #ccc;">`;
                recordingFees += `<thead><tr><th style="padding: 8px; background-color: #f4f4f4; border: 1px solid #ddd;">Fee Type</th><th style="padding: 8px; background-color: #f4f4f4; border: 1px solid #ddd;">Fee Amount</th></tr></thead><tbody>`;

                response.fees.recording_fees.forEach(item => {
                    recordingFees += `
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;">${item.type}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">$${item.amount}</td>
                </tr>
            `;
                });

                recordingFees += `</tbody></table>`;
                modalContent += recordingFees;
            }

            // Transfer Taxes
            if (response.fees && response.fees.transfer_taxes && response.fees.transfer_taxes.borrower) {
                let transferTaxes = `<h4 style="color: #444; font-size: 18px; margin-top: 20px;">Transfer Taxes</h4>`;
                transferTaxes += `<table style="width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid #ccc;">`;
                transferTaxes += `<thead><tr><th style="padding: 8px; background-color: #f4f4f4; border: 1px solid #ddd;">Tax Type</th><th style="padding: 8px; background-color: #f4f4f4; border: 1px solid #ddd;">Tax Amount</th></tr></thead><tbody>`;

                response.fees.transfer_taxes.borrower.forEach(item => {
                    transferTaxes += `
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;">${item.type}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">$${item.amount}</td>
                </tr>
            `;
                });

                transferTaxes += `</tbody></table>`;
                modalContent += transferTaxes;
            }

            // Closing Policy and Premium fees for Refinance and Purchase
            if (response.fees && response.fees.loan_policy_premium) {
                let premiumFees = `<h4 style="color: #444; font-size: 18px; margin-top: 20px;">Loan Policy Premium</h4>`;
                premiumFees += `<table style="width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid #ccc;">`;
                premiumFees += `<thead><tr><th style="padding: 8px; background-color: #f4f4f4; border: 1px solid #ddd;">Premium Title</th><th style="padding: 8px; background-color: #f4f4f4; border: 1px solid #ddd;">Amount</th></tr></thead><tbody>`;

                if (response.fees.loan_policy_premium.borrower) {
                    premiumFees += `
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;">Borrower Loan Policy Premium</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">$${response.fees.loan_policy_premium.borrower}</td>
                </tr>
            `;
                }

                premiumFees += `</tbody></table>`;
                modalContent += premiumFees;
            }

            // Set the modal content
            document.querySelector('.resDiv').innerHTML = modalContent;
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
        $('.btn-pdf').click(function() {
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
                success: function(response) {
                    // Create a download link
                    var link = document.createElement('a');
                    link.href = response.pdf_url; // URL of the generated PDF
                    link.download = 'generated_file.pdf'; // Name of the downloaded file
                    link.click();

                    // Wait 5 seconds to ensure download before deletion
                    setTimeout(function() {
                        $.ajax({
                            url: response.delete_url, // Delete URL provided by the backend
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function() {
                                console.log('Temporary PDF file deleted successfully');
                            },
                            error: function() {
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
                error: function(error) {
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
        $('.btn-email').click(function() {
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
            formData.append('sendingemail', sendingemail);
            formData.append('fee_response_json', JSON.stringify(fee_response_json));

            return formData;

        }

        function validateEmail(email) {
            var re = /\S+@\S+\.\S+/;
            return re.test(email);
        }
        $('.sendEmail').click(function() {
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
            formData2.append('_token', $('meta[name="csrf-token"]').attr('content'));
            console.log(formData2);
            if (!formData2) {
                console.log('Invalid form data');
                return;
            }

            $.ajax({
                url: 'sendpdf',
                type: 'POST',
                data: formData2,
                contentType: false,
                processData: false,
                success: function(response) {
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
                error: function(error) {
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBy2l4KGGTm4cTqoSl6h8UAOAob87sHBsA&libraries=places&callback=initMap" async defer></script>

</body>

</html>