<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Loan Calculator</title>
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
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
            <input type="password" id="passwordInput" placeholder="Enter password" />
            <button id="submitPassword">Submit</button>
            <p id="errorMessage" style="color: red; display: none;">Incorrect password. Try again.</p>
        </div>
    </div>
    <!--Email Modal -->
    <!--Email Modal -->
    <div class="modal1" id="email_modal">
        <div class="modal-content">
            <span class="close" id="close_modal">&times;</span>
            <h3>Enter email to send pdf</h3>
            <input type="email" id="Email_id" placeholder="Enter email" />
            <button class="sendPDF">Send PDF</button>
        </div>
    </div>
    <div class="flex_btns">
        <div class="pdf">
            <button class="pdfbutton disabled" disabled>Download PDF</button>
        </div>
        <div class="email">
            <button id="open_modal" class="emailbtn disabled" disabled>Email</button>
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

                <!-- Subject Address input -->
                <div class="flex_input">
                    <label for="subject">Subject Address</label>
                    <div class="input-wrapper without-tag">
                        <input type="text" id="subject" placeholder="Enter subject address" />
                    </div>
                </div>
                <div class="flex_input">
                    <label for="state">State</label>
                    <div class="input-wrapper without-tag">
                        <select id="state" onchange="getCounty(this)">
                            <option value="" disabled selected>Choose an option</option>
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                </div>
                <div class="flex_input">
                    <label for="county">County</label>
                    <div class="input-wrapper without-tag">
                        <select id="county" onchange="getTownship(this)">
                            <option value="" disabled selected>Choose an option</option>

                        </select>
                    </div>
                </div>
                <div class="flex_input">
                    <label for="township">Township</label>
                    <div class="input-wrapper without-tag">
                        <select id="township">
                            <option value="All Townships">All Townships</option>

                        </select>
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
                        <input type="number" id="emd" placeholder="EMD" />
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
                    <label for="interestRate">Interest Rate (%)</label>
                    <div class="input-wrapper">
                        <span>%</span>
                        <input type="number" id="interestRate" value="7.09" placeholder="Enter annual interest rate" value="5" />
                    </div>
                </div>
                <div class="flex_input">
                    <label for="mip">MIP/PMI</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="number" id="mip" placeholder="MIP/PMI" />
                    </div>
                </div>

                <!-- Additional fields like Property Taxes, Home Insurance, HOA Fees -->
                <div class="flex_input">
                    <label for="propertyTaxes">Annual Property Taxes ($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="number" onkeyup="calculateMonthlyPayment1()" value="0" id="propertyTaxes" placeholder="Enter annual property taxes" />
                    </div>
                </div>
                <div class="flex_input">
                    <label for="homeInsurance">Annual Home Insurance ($)</label>
                    <div class="input-wrapper">
                        <span>$</span>
                        <input type="number" onkeyup="calculateMonthlyPayment1()" value="900" id="homeInsurance" placeholder="Enter annual home insurance" />
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
                <div class="fee_response">
                    <h3>API Response</h3>
                </div>
                <div class="user_form">
                    <form action="">
                        <div class="calculator" style="width: 90%;margin: auto;box-shadow: 2px 2px 28px -7px rgb(0 0 0 / 37%);margin-top: 20px;">
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
                                    <input type="phone" id="email" placeholder="Enter license number" />
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

    <script src="{{asset('js/script.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.querySelector('.get_fees button').addEventListener('click', function(e) {
            e.preventDefault();
            // disable get fee button and change text to fetching
            document.querySelector('.get_fees button').classList.add('disabled');
            document.querySelector('.get_fees button').innerHTML = 'Fetching...';
            // fetch all the fields and make an ajax request to the backend
            const formData = collectFormData();
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
                    $('.fee_response').html('<h3>API Response</h3><pre>' + JSON.stringify(response, null, 2) + '</pre>');

                    toastr.success('Fees calculated successfully', '', {
                        timeOut: 1000 // Auto-dismiss after 1 second
                    });
                    //Enable the email and pdf button after success API call.
                    document.querySelector('.emailbtn').classList.remove('disabled');
                    document.querySelector('.emailbtn').removeAttribute('disabled');
                    document.querySelector('.pdfbutton').classList.remove('disabled');
                    document.querySelector('.pdfbutton').removeAttribute('disabled');
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

        function collectFormData() {
            const formData = {};
            const formElements = document.querySelectorAll('.calculator input, .calculator select, .calculator textarea'); // Adjust selector as needed

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
        $('.pdfbutton').click(function() {
            var button = $(this);
            button.html('Generating...');
            button.prop('disabled', true);
            $.ajax({
                url: 'generatepdf',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    data: {
                        fname: $('#fname').val(),
                        lname: $('#lname').val(),
                        subjectaddr: $('#subject').val(),
                        loanType: $('#loanType').val(),
                        refinancePrice: $('#refinancePrice').val(),
                        purchasePrice: $('#purchasePrice').val(),
                        emd: $('#emd').val(),
                        downPaymentPercent: $('#downPaymentPercent').val(),
                        downPaymentValue: $('#downPaymentValue').val(),
                        ltv: $('#ltv').val(),
                        loan_amount: $('#loan_amount').val(),
                        loanTerm: $('#loanTerm').val(),
                        interestRate: $('#interestRate').val(),
                        mip: $('#mip').val(),
                        propertyTaxes: $('#propertyTaxes').val(),
                        homeInsurance: $('#homeInsurance').val(),
                        hoaFees: $('#hoaFees').val(),
                        getFeeRes: $('.fee_response').html()
                    },
                },
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


        function validateEmail(email) {
            var re = /\S+@\S+\.\S+/;
            return re.test(email);
        }
        $('.sendPDF').click(function() {
            var button = $(this);
            button.html('Sending...');
            button.prop('disabled', true);
            email = $('#Email_id').val();
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
                toastr.error('Please enter a valid email', '', {
                    timeOut: 1000 // Auto-dismiss after 1 second
                });
                button.html('Send PDF');
                button.prop('disabled', false);
                return;
            }
            $.ajax({
                url: 'sendpdf',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    data: {
                        sendingemail: email,
                        fname: $('#fname').val(),
                        lname: $('#lname').val(),
                        subjectaddr: $('#subject').val(),
                        loanType: $('#loanType').val(),
                        refinancePrice: $('#refinancePrice').val(),
                        purchasePrice: $('#purchasePrice').val(),
                        emd: $('#emd').val(),
                        downPaymentPercent: $('#downPaymentPercent').val(),
                        downPaymentValue: $('#downPaymentValue').val(),
                        ltv: $('#ltv').val(),
                        loan_amount: $('#loan_amount').val(),
                        loanTerm: $('#loanTerm').val(),
                        interestRate: $('#interestRate').val(),
                        mip: $('#mip').val(),
                        propertyTaxes: $('#propertyTaxes').val(),
                        homeInsurance: $('#homeInsurance').val(),
                        hoaFees: $('#hoaFees').val(),
                    }
                },
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
        function getCounty(e) {
            var state = e.value;
            $.ajax({
                url: 'getcounty',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    state: state
                },
                success: function(response) {
                    var countyDropdown = document.getElementById('county');

                    // Clear the dropdown before populating it
                    countyDropdown.innerHTML = '';

                    // Ensure the response structure is as expected
                    if (response.counties && response.counties.counties && response.counties.counties.length > 0) {
                        // Populate counties
                        response.counties.counties.forEach(function(item) {
                            var option = document.createElement('option');
                            option.value = item;
                            option.text = item;
                            countyDropdown.appendChild(option);
                        });
                    } else {
                        // Add "All Counties" option if no counties are available
                        var option = document.createElement('option');
                        option.value = 'All Counties';
                        option.text = 'All Counties';
                        countyDropdown.appendChild(option);
                    }
                },
                error: function(xhr) {

                    // Show an error message using Toastr
                    toastr.error('Error fetching counties. Please try again.', '', {
                        timeOut: 2000 // Auto-dismiss after 2 seconds
                    });

                    // Optionally, add a default "error" message to the dropdown
                    var option = document.createElement('option');
                    option.value = '';
                    option.text = 'Error loading counties';
                    countyDropdown.appendChild(option);
                }
            });

        }

        function getTownship(e) {
            var county = e.value;
            var state = document.getElementById('state').value;
            $.ajax({
                url: 'gettownship',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    state: state,
                    county: county
                },
                success: function(response) {

                    // Access the townships array in the response
                    if (response.townships && response.townships.townships && response.townships.townships.length > 0) {
                        var townshipsDropdown = document.getElementById('township');

                        // Clear existing options
                        townshipsDropdown.innerHTML = '';

                        // Populate the dropdown with townships
                        response.townships.townships.forEach(function(township) {
                            var option = document.createElement('option');
                            option.value = township;
                            option.text = township;
                            townshipsDropdown.appendChild(option);
                        });
                    } else {
                        toastr.warning('No townships available.', '', {
                            timeOut: 1000 // Auto-dismiss after 1 second
                        });
                    }
                },
                error: function(error) {
                    toastr.error('Error getting township', '', {
                        timeOut: 1000 // Auto-dismiss after 1 second
                    });
                }

            });
        }
    </script>
</body>

</html>