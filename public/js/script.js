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
    const monthlyPaymentDisplay = document.getElementById('monthlyPayment');
    const loan_amount = document.getElementById('loan_amount');


    function updateDownPayment(isPercentUpdated) {
        const price = loanTypeSelect.value === 'purchasing' ? parseFloat(purchasePriceInput.value) : parseFloat(refinancePriceInput.value);
        if (isPercentUpdated) {
            const percent = parseFloat(downPaymentPercentInput.value) || 0;
            downPaymentValueInput.value = ((percent / 100) * price);
        } else {
            const value = parseFloat(downPaymentValueInput.value) || 0;
            downPaymentPercentInput.value = ((value / price) * 100);
        }
        calculateLTV();
        calculateMonthlyPayment();


    }

    function calculateLTV() {
        const refinancePrice = parseFloat(refinancePriceInput.value) || 0;
        const downPaymentValue = parseFloat(downPaymentValueInput.value) || 0;
        const loanAmount = refinancePrice - downPaymentValue;
        const ltv = (loanAmount / refinancePrice) * 100;
        ltvInput.value = ltv;
    }

    function calculateMonthlyPayment() {
        const price = loanTypeSelect.value === 'purchasing' ? parseFloat(purchasePriceInput.value) : parseFloat(refinancePriceInput.value);
        const downPaymentValue = parseFloat(downPaymentValueInput.value) || 0;
        const loanTerm = parseFloat(loanTermInput.value) || 0;
        const interestRate = parseFloat(interestRateInput.value) || 0;
        const propertyTaxes = parseFloat(propertyTaxesInput.value) || 0;
        const homeInsurance = parseFloat(homeInsuranceInput.value) || 0;
        const hoaFees = parseFloat(hoaFeesInput.value) || 0;

        const loanAmount = (price - downPaymentValue) - emd.value || 0;
        loan_amount.value = loanAmount;
        const monthlyRate = interestRate / 100 / 12;
        const totalPayments = loanTerm * 12;

        let principalAndInterest = 0;
        if (monthlyRate === 0) {
            principalAndInterest = loanAmount / totalPayments;
        } else {
            principalAndInterest =
                (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, totalPayments)) /
                (Math.pow(1 + monthlyRate, totalPayments) - 1);
        }

        document.getElementById('principalInterest').textContent = principalAndInterest.toFixed(2);
        document.getElementById('homeInsuranceDisplay').textContent = (homeInsurance / 12).toFixed(2);
        document.getElementById('propertyTaxDisplay').textContent = (propertyTaxes / 12).toFixed(2);
        document.getElementById('hoaFeesDisplay').textContent = hoaFees.toFixed(2);

        const totalMonthlyPayment = principalAndInterest + (propertyTaxes / 12) + (homeInsurance / 12) + hoaFees;
        document.getElementById('monthlyPayment').textContent = totalMonthlyPayment.toFixed(0);
        updateDownPayment(true);
        calculateLTV();
    }

    // Initialize event listeners
    purchasePriceInput.addEventListener('input', calculateMonthlyPayment);
    refinancePriceInput.addEventListener('input', calculateMonthlyPayment);
    downPaymentPercentInput.addEventListener('input', () => updateDownPayment(true));
    downPaymentValueInput.addEventListener('input', () => updateDownPayment(false));
    ltvInput.addEventListener('input', calculateLTV); // Manually update LTV
    loanTermInput.addEventListener('input', calculateMonthlyPayment);
    interestRateInput.addEventListener('input', calculateMonthlyPayment);
    propertyTaxesInput.addEventListener('input', calculateMonthlyPayment);
    homeInsuranceInput.addEventListener('input', calculateMonthlyPayment);
    hoaFeesInput.addEventListener('input', calculateMonthlyPayment);
    emd.addEventListener('input', calculateMonthlyPayment);
    emd.addEventListener('input', () => updateDownPayment(true));

    // Adjust display based on loan type
    loanTypeSelect.addEventListener('change', () => {
        const isRefinance = loanTypeSelect.value === 'refinance';

        if (isRefinance) {
            refinancePriceWrapper.style.display = 'flex';
            purchasePriceWrapper.style.display = 'none';
            // downPaymentWrapper.style.display = 'none';
            emdWrapper.style.display = 'none';
            ltvWrapper.style.display = 'flex';
            emd.value = "0";
            calculateLTV(); // Calculate LTV if refinance is selected
        } else {
            refinancePriceWrapper.style.display = 'none';
            purchasePriceWrapper.style.display = 'flex';
            downPaymentWrapper.style.display = 'flex';
            emdWrapper.style.display = 'flex';
            ltvWrapper.style.display = 'none';
        }
        calculateMonthlyPayment();
    });

    // Initialize values when the page loads
    loanTypeSelect.dispatchEvent(new Event('change'));
}

initCalculator();
submitPassword.addEventListener('click', () => {
    if (passwordInput.value === correctPassword) {
        passwordModal.style.display = 'none';
        calculator.style.display = 'block';
        initCalculator(); // Initialize calculator functionality
    } else {
        errorMessage.style.display = 'blocks';
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
openModalButton.addEventListener('click', () => {
    modal.style.display = 'flex';
});

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

