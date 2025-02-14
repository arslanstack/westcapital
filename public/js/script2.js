// Password protection
const passwordModal = document.getElementById('passwordModal');
const passwordInput = document.getElementById('passwordInput');
const submitPassword = document.getElementById('submitPassword');
const calculator = document.querySelector('.outer');
const errorMessage = document.getElementById('errorMessage');

const correctPassword = '12345'; // Set your password here

const loanTypeSelect = document.getElementById('loanType');
const purchasePriceWrapper = document.getElementById('purchasePriceWrapper');
const refinancePriceWrapper = document.getElementById('refinancePriceWrapper');
const emdWrapper = document.getElementById('emdWrapper');
const downPaymentWrapper = document.getElementById('downPaymentWrapper');
const ltvWrapper = document.getElementById('ltvWrapper');

// Initialize the calculator
function initCalculator() {
    const purchasePriceInput = document.getElementById('purchasePrice');
    const refinancePriceInput = document.getElementById('refinancePrice');
    const downPaymentPercentInput = document.getElementById('downPaymentPercent');
    const downPaymentValueInput = document.getElementById('downPaymentValue');
    const ltvInput = document.getElementById('ltv');
    const loanTermInput = document.getElementById('loanTerm');
    const interestRateInput = document.getElementById('interestRate');
    const propertyTaxesInput = document.getElementById('propertyTaxes');
    const homeInsuranceInput = document.getElementById('homeInsurance');
    const hoaFeesInput = document.getElementById('hoaFees');
    const emdInput = document.getElementById('emd');
    const monthlyPaymentDisplay = document.getElementById('monthlyPayment');
    const loanAmountInput = document.getElementById('loan_amount');
    const aprInput = document.getElementById('apr'); // New input for APR
    
    function updateDownPayment(isPercentUpdated) {
        const price =
            loanTypeSelect.value === 'purchasing'
                ? parseFloat(purchasePriceInput.value)
                : parseFloat(refinancePriceInput.value);
    
        if (isPercentUpdated) {
            let percent = parseFloat(downPaymentPercentInput.value) ;
    
            // Allow decimal values and ensure the percentage is between 0 and 100
            percent = Math.min(Math.max(percent, 0), 100);
    
            downPaymentPercentInput.value = percent; // Keep two decimal places
            downPaymentValueInput.value = Math.round((percent / 100) * price);
        } else {
            let value = parseFloat(downPaymentValueInput.value) ;
    
            // Ensure down payment does not exceed purchase price
            value = Math.min(Math.max(value, 0), price);
            // downPaymentValueInput.value = Math.round(value);
            downPaymentValueInput.value = (Math.abs(value - Math.round(value)) < 1e-10) ? Math.round(value) : value;
            // downPaymentPercentInput.value =((value / price) * 100);
            let val1 =((value / price) * 100);
            downPaymentPercentInput.value = (Math.abs(val1 - Math.round(val1)) < 1e-10) ? Math.round(val1) : val1;
        }
    
        calculateLTV(); // Ensure loan amount updates when down payment changes
    }
    
    
    
    

    function calculateLTV() {
        const price = loanTypeSelect.value === 'purchasing' ?
            parseFloat(purchasePriceInput.value) :
            parseFloat(refinancePriceInput.value);
    
        const downPaymentValue = parseFloat(downPaymentValueInput.value) || "";
        const emdValue = parseFloat(emdInput.value) || "";
        let loanAmount;
        let ltv;
    
        if (loanTypeSelect.value === 'refinance') {
            // Refinance: Loan amount is based on LTV
            loanAmount = (parseFloat(ltvInput.value) / 100) * price;
        } else {
            // Purchase: Loan amount is price minus down payment and EMD
            loanAmount = price - downPaymentValue - emdValue;
        }
    
        // Ensure Loan Amount does not exceed Price
        if (loanAmount > price) {
            loanAmount = price;
        }
    
        // Calculate LTV
        ltv = (loanAmount / price) * 100;
    
        // Ensure LTV is between 1% and 100%
        if (ltv < 0) {
            ltv = 0;
        } else if (ltv > 100) {
            ltv = 100;
        }
    
        // Update inputs
        // loanAmountInput.value =loanAmount;
        loanAmountInput.value =(Math.abs(loanAmount - Math.round(loanAmount)) < 1e-10) ? Math.round(loanAmount) : loanAmount;
        ltvInput.value = (Math.abs(ltv - Math.round(ltv)) < 1e-10) ? Math.round(ltv) : ltv;
    
        // Enable/disable input based on loan type
        // if (loanTypeSelect.value === 'refinance') {
        //     loanAmountInput.removeAttribute('readonly');
        //     loanAmountInput.classList.remove('dis');
        // } else {
        //     loanAmountInput.setAttribute('readonly', 'true');
        //     loanAmountInput.classList.add('dis');
        // }
    
        calculateMonthlyPayment();
    }
    
   // Event Listener for LTV Input Change
   function newFunc(){
    if (loanTypeSelect.value === 'refinance') {
        const price = parseFloat(refinancePriceInput.value) || "";
        let ltv = parseFloat(ltvInput.value) || "";
        let loanAmount = (ltv / 100) * price;

        // Ensure Loan Amount does not exceed Price
        if (loanAmount > price) {
            loanAmount = price;
            ltv = 100; // If loan amount is max, set LTV to 100%
        }

        loanAmountInput.value = Math.round(loanAmount);
        ltvInput.value = ltv;
    }
    calculateMonthlyPayment();
}
let timeout;
ltvInput.addEventListener('input', () => {
    clearTimeout(timeout); // Clear any existing timeout to prevent multiple triggers
    timeout = setTimeout(newFunc, 1500); // Delay execution by 1 second (1000ms)
    // timeout = setTimeout(calculateMonthlyPayment, 1500);
});

// Event Listener for Loan Amount Input Change
function newFunc2() {
    const price = loanTypeSelect.value === 'purchasing' ?
        parseFloat(purchasePriceInput.value) :
        parseFloat(refinancePriceInput.value);

    let loanAmount = parseFloat(loanAmountInput.value) || 0;
    let ltv = (loanAmount / price) * 100;

    // Ensure Loan Amount does not exceed Price
    if (loanAmount > price) {
        loanAmount = price;
        ltv = 100; // If loan amount is max, set LTV to 100%
    }

    loanAmountInput.value = loanAmount;

    // Fix floating-point precision issues like 55.00000000000001 but keep exact values
    ltvInput.value = (Math.abs(ltv - Math.round(ltv)) < 1e-10) ? Math.round(ltv) : ltv;

    calculateMonthlyPayment();
}


loanAmountInput.addEventListener('input', () => {
    clearTimeout(timeout); // Clear any existing timeout to prevent multiple triggers
    timeout = setTimeout(newFunc2, 1500); // Delay execution by 1 second (1000ms)
    // timeout = setTimeout(calculateMonthlyPayment, 1500);
});

    
    

    function calculateAPR(loanAmount, totalFees, loanTerm, interestRate) {
        // Formula to approximate APR: ((totalCost - loanAmount) / loanAmount) / loanTerm
        const monthlyRate = interestRate / 100 / 12;
        const totalPayments = loanTerm * 12;

        let totalInterest = 0;
        if (monthlyRate === 0) {
            totalInterest = 0;
        } else {
            const totalLoanCost =
                (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, totalPayments)) /
                (Math.pow(1 + monthlyRate, totalPayments) - 1);
            totalInterest = totalLoanCost * totalPayments - loanAmount;
        }

        const apr = ((totalInterest + totalFees) / loanAmount / loanTerm) * 100;
        return apr.toFixed(2);
    }

    
    purchasePriceInput.addEventListener('input', calculateMonthlyPayment);
    purchasePriceInput.addEventListener('input', calculateLTV);
    purchasePriceInput.addEventListener('input', () => updateDownPayment(true));
    purchasePriceInput.addEventListener('input', () => updateDownPayment(false));
    // downPaymentValueInput.addEventListener('input', calculateMonthlyPayment);
    // downPaymentPercentInput.addEventListener('input', calculateMonthlyPayment);
    refinancePriceInput.addEventListener('input', calculateMonthlyPayment);
    refinancePriceInput.addEventListener('input', calculateMonthlyPayment);
    refinancePriceInput.addEventListener('input', calculateLTV);
    // loanAmountInput.addEventListener('input', calculateMonthlyPayment);
    // loanAmountInput.addEventListener('input', calculateLTV);

    downPaymentPercentInput.addEventListener('input', () => {
        clearTimeout(timeout); // Clear any existing timeout to prevent multiple triggers
        timeout = setTimeout(() => updateDownPayment(true), 1500); // Delay execution by 1 second (1000ms)
    });

    downPaymentValueInput.addEventListener('input', () => {
        clearTimeout(timeout); // Clear any existing timeout to prevent multiple triggers
        timeout = setTimeout(() => updateDownPayment(false), 1500); // Delay execution by 1 second (1000ms)
    });
    // downPaymentPercentInput.addEventListener('input', () => updateDownPayment(true));
    // downPaymentValueInput.addEventListener('input', () => updateDownPayment(false));
    // ltvInput.addEventListener('input', calculateLTV); 
    loanTermInput.addEventListener('input', calculateMonthlyPayment);
    interestRateInput.addEventListener('input', calculateMonthlyPayment);
    propertyTaxesInput.addEventListener('input', calculateMonthlyPayment);
    homeInsuranceInput.addEventListener('input', calculateMonthlyPayment);
    hoaFeesInput.addEventListener('input', calculateMonthlyPayment);
    emd.addEventListener('input', calculateLTV);
    emd.addEventListener('input', calculateMonthlyPayment);
    emd.addEventListener('input', () => updateDownPayment(true));

    // Adjust display based on loan type
    loanTypeSelect.addEventListener('change', () => {
        const isRefinance = loanTypeSelect.value === 'refinance';
    
        if (isRefinance) {
            // Show Refinance-related fields
            refinancePriceWrapper.style.display = 'flex';
            purchasePriceWrapper.style.display = 'none';
            downPaymentWrapper.style.display = 'none';  // Hide down payment field in refinance case
            emdWrapper.style.display = 'none';
            ltvWrapper.style.display = 'flex';  // Show LTV field
            emd.value = "0";  // Reset EMD to 0 for refinance
            ltvInput.disabled = false;  // Enable LTV field for refinance
            loanAmountInput.removeAttribute('readonly');
            loanAmountInput.classList.remove('dis');
            // Default loan term for refinance (e.g., 15 years)
            loanTermInput.value = '15'; // Set default loan term to 15 years for refinance
            loanTermInput.disabled = false;  // Keep loan term field enabled for refinance
            refinancePriceInput.value="100000"
            loanAmountInput.value="80000";
            ltvInput.value="80";
        } else {
            // Show Purchase-related fields
            refinancePriceWrapper.style.display = 'none';
            purchasePriceWrapper.style.display = 'flex';
            downPaymentWrapper.style.display = 'flex';  // Show down payment field in purchase case
            emdWrapper.style.display = 'flex';
            ltvWrapper.style.display = 'none';  // Hide LTV field for purchase
            ltvInput.disabled = true;  // Disable LTV field for purchase
            loanAmountInput.setAttribute('readonly', 'true');
            loanAmountInput.classList.add('dis');
            loanTermInput.disabled = false;  // Enable loan term field for purchase
            loanAmountInput.value="80000";
            downPaymentValueInput.value="20000";
            downPaymentPercentInput.value="20";
            purchasePriceInput.value="100000";
        }
    
        // Recalculate values when loan type changes
        calculateMonthlyPayment();
    });
    
    // Ensure loan term input is triggering recalculation
    loanTermInput.addEventListener('input', () => {
        calculateMonthlyPayment();  // Recalculate whenever loan term is updated
    });
    
    function calculateMonthlyPayment() {
        const loanAmount = parseFloat(loanAmountInput.value) || "";
        const loanTerm = parseFloat(loanTermInput.value) || 0;
        const interestRate = parseFloat(interestRateInput.value) || 0;
        const propertyTaxes = parseFloat(propertyTaxesInput.value) || 0;
        const homeInsurance = parseFloat(homeInsuranceInput.value) || 0;
        const hoaFees = parseFloat(hoaFeesInput.value) || 0;
        
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
        
        // Display values
        document.getElementById('principalInterest').textContent = Math.round(principalAndInterest);
        document.getElementById('homeInsuranceDisplay').textContent = Math.round(homeInsurance / 12);
        document.getElementById('propertyTaxDisplay').textContent = Math.round(propertyTaxes / 12);
        document.getElementById('hoaFeesDisplay').textContent = Math.round(hoaFees);
        
        // Total Monthly Payment
        const totalMonthlyPayment = principalAndInterest + propertyTaxes / 12 + homeInsurance / 12 + hoaFees;
        document.getElementById('monthlyPayment').textContent = totalMonthlyPayment.toFixed(0);
        
        // Calculate APR
        const totalFees = parseFloat(propertyTaxes) + parseFloat(homeInsurance);
        const apr = calculateAPR(loanAmount, totalFees, loanTerm, interestRate);
        aprInput.value = apr;
        
        // updateDownPayment(true);
    }
    

    

    // Initialize values when the page loads
    loanTypeSelect.dispatchEvent(new Event('change'));
}
loanTypeSelect.addEventListener('change', () => {
    const isRefinance = loanTypeSelect.value === 'refinance';

    if (isRefinance) {
        // Show Refinance-related fields
        refinancePriceWrapper.style.display = 'flex';
        purchasePriceWrapper.style.display = 'none';
        downPaymentWrapper.style.display = 'none';  // Hide down payment field in refinance case
        emdWrapper.style.display = 'none';
        ltvWrapper.style.display = 'flex';  // Show LTV field
        emd.value = "0";  // Reset EMD to 0 for refinance
        ltvInput.disabled = false;  // Enable LTV field for refinance
    } else {
        // Show Purchase-related fields
        refinancePriceWrapper.style.display = 'none';
        purchasePriceWrapper.style.display = 'flex';
        downPaymentWrapper.style.display = 'flex';  // Show down payment field in purchase case
        emdWrapper.style.display = 'flex';
        ltvWrapper.style.display = 'none';  // Hide LTV field for purchase
        ltvInput.disabled = true;  // Disable LTV field for purchase
    }
    calculateMonthlyPayment(); // Recalculate when loan type changes
});


initCalculator();
submitPassword.addEventListener('click', () => {
    if (passwordInput.value === correctPassword) {
        passwordModal.style.display = 'none';
        calculator.style.display = 'block';
        initCalculator(); // Initialize calculator functionality
    } else {
        errorMessage.style.display = 'block'; // Fixed typo ('blocks' -> 'block')
    }
});

passwordInput.addEventListener('keydown', (event) => {
    if (event.key === 'Enter') { // Check if the Enter key is pressed
        if (passwordInput.value === correctPassword) {
            passwordModal.style.display = 'none';
            calculator.style.display = 'block';
            initCalculator(); // Initialize calculator functionality
        } else {
            errorMessage.style.display = 'block'; // Fixed typo ('blocks' -> 'block')
        }
    }
});


passwordInput.addEventListener('input', () => {
    errorMessage.style.display = 'none';
});
function updateProgressBar() {
    // Get numeric values from your results
    const principalInterest = parseFloat(document.getElementById('principalInterest').textContent) || 0;
    const homeInsurance = parseFloat(document.getElementById('homeInsuranceDisplay').textContent) || 0;
    const propertyTax = parseFloat(document.getElementById('propertyTaxDisplay').textContent) || 0;
    const hoaFees = parseFloat(document.getElementById('hoaFeesDisplay').textContent) || 0;

    // Calculate the total to normalize percentages
    const total = principalInterest + homeInsurance + propertyTax + hoaFees;

    // Prevent division by zero and calculate percentages
    const principalInterestWidth = (principalInterest / total) * 100 || 0;
    const homeInsuranceWidth = (homeInsurance / total) * 100 || 0;
    const propertyTaxWidth = (propertyTax / total) * 100 || 0;
    const hoaFeesWidth = (hoaFees / total) * 100 || 0;

    // Update the widths of each progress bar segment
    document.querySelector('.progress-segment.principal-interest').style.width = `${principalInterestWidth}%`;
    document.querySelector('.progress-segment.home-insurance').style.width = `${homeInsuranceWidth}%`;
    document.querySelector('.progress-segment.property-tax').style.width = `${propertyTaxWidth}%`;
    document.querySelector('.progress-segment.hoa-fees').style.width = `${hoaFeesWidth}%`;
}

// Example function to trigger updates (tie this to your logic)
function calculateMonthlyPayment1() {
    // Your logic to update results...

    updateProgressBar(); // Ensure the progress bar is updated
}

// Call this once initially to set up the bar
updateProgressBar();
// Select elements
const openModalButton = document.getElementById('open_modal');
const closeModalButton = document.getElementById('close_modal');
const modal = document.getElementById('email_modal');

// Function to open modal
// openModalButton.addEventListener('click', () => {
//     modal.style.display = 'flex';
// });

// Function to close modal
closeModalButton.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Close modal when clicking outside of it
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});


// ResponseModal

const resmodal = document.getElementById('modal2');
const closeResModal = document.getElementById('closeResModal');


// Function to close modal
closeResModal.addEventListener('click', () => {
    resmodal.style.display = 'none';
});

// Close modal when clicking outside of it
window.addEventListener('click', (event) => {
    if (event.target === resmodal) {
        resmodal.style.display = 'none';
    }
});

//   const ltvInput = document.getElementById('ltv');
  
//   ltvInput.addEventListener('input', () => {
//     let value = parseInt(ltvInput.value, 10);
//     if (value < 0) {
//       ltvInput.value = 0;
//     } else if (value > 99) {
//       ltvInput.value = 99;
//     }
//   });
// document.querySelector('.limit').addEventListener('input', function () {
//     if (this.value < 0) this.value = 0;
//     if (this.value > 99) this.value = 99;
// });

// document.getElementById("ltv").addEventListener("input", function () {
//     let value = this.value;
//     if (value < 0) {
//         this.value = 0;
//     } else if (value > 99) {
//         this.value = 0;
//     }
// });
