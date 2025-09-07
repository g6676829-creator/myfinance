<?php require 'php/conn.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/new_logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Investment Return Calculator</title>
    <style>
        .outer {
            background-image: url("../images/background.png");
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            margin: 0;
        }
        .calculator {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0px 0px 5px black;
            padding: 30px;
            width: 350px;
        }
        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        input, select {
            box-shadow: none !important;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
            border-left: 4px solid #2563eb;
        }
        .result h3 {
            margin-top: 0;
            color: #333;
        }
        .result p {
            margin: 5px 0;
            color: #555;
        }
        .breakdown {
            margin-top: 15px;
            padding: 10px;
            background-color: #f0f8ff;
            border-radius: 3px;
            border: 1px solid #e0e0e0;
        }
        .breakdown h4 {
            margin: 0 0 10px 0;
            color: #2563eb;
            font-size: 16px;
        }
        .breakdown-item {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 14px;
        }
        .gain {
            color: #28a745;
            font-weight: bold;
        }
        .loss {
            color: #dc3545;
            font-weight: bold;
        }
        /*scrollbar customization start*/
        ::-webkit-scrollbar {
            width: 7px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #0000FF;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover{
            background: #461dcd;
        }
    </style>
</head>
<body>
    <?php require 'components/nav.php';?>
    <div class="outer">
    <div class="calculator mt-3">
        <h1>Investment Return Calculator</h1>
        <div class="form-group mt-3">
            <label for="initial-investment">Initial Investment (₹)</label>
            <input class="form-control" type="number" id="initial-investment" placeholder="e.g., 100000">
        </div>
        <div class="form-group mt-3">
            <label for="investment-period">Investment Period</label>
            <div class="row">
                <div class="col-8">
                    <input class="form-control" type="number" id="investment-period" placeholder="e.g., 5">
                </div>
                <div class="col-4">
                    <select class="form-control" id="period-type">
                        <option value="years">Years</option>
                        <option value="months">Months</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="annual-return">Expected Annual Return (%)</label>
            <input class="form-control" type="number" id="annual-return" placeholder="e.g., 12" step="0.1">
        </div>
        <div class="form-group mt-3">
            <label for="compounding">Compounding Frequency</label>
            <select class="form-control" id="compounding">
                <option value="1">Annually</option>
                <option value="2">Semi-Annually</option>
                <option value="4">Quarterly</option>
                <option value="12" selected>Monthly</option>
                <option value="365">Daily</option>
            </select>
        </div>
        <button onclick="calculateReturns()" class="btn btn-primary mt-3 w-100">Calculate Returns</button>
        <div class="result" id="result" style="display: none;">
            <h3>Investment Results</h3>
            <p id="final-amount"></p>
            <p id="total-returns"></p>
            <p id="return-percentage"></p>
            
            <div class="breakdown" id="breakdown">
                <h4>Year-wise Breakdown</h4>
                <div id="yearly-breakdown"></div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function calculateReturns() {
            // Get input values
            const initialInvestment = parseFloat(document.getElementById('initial-investment').value);
            const investmentPeriod = parseFloat(document.getElementById('investment-period').value);
            const periodType = document.getElementById('period-type').value;
            const annualReturn = parseFloat(document.getElementById('annual-return').value);
            const compoundingFreq = parseInt(document.getElementById('compounding').value);

            // Validate inputs
            if (isNaN(initialInvestment) || isNaN(investmentPeriod) || isNaN(annualReturn)) {
                alert("Please enter valid numbers!");
                return;
            }

            if (initialInvestment <= 0 || investmentPeriod <= 0) {
                alert("Investment amount and period must be positive!");
                return;
            }

            // Convert period to years
            const yearsInvestment = periodType === 'years' ? investmentPeriod : investmentPeriod / 12;

            // Calculate compound interest
            // A = P(1 + r/n)^(nt)
            const rate = annualReturn / 100;
            const finalAmount = initialInvestment * Math.pow((1 + rate / compoundingFreq), compoundingFreq * yearsInvestment);
            
            const totalReturns = finalAmount - initialInvestment;
            const returnPercentage = (totalReturns / initialInvestment) * 100;
            const cagr = (Math.pow(finalAmount / initialInvestment, 1 / yearsInvestment) - 1) * 100;

            // Display main results
            document.getElementById('final-amount').innerHTML = 
                `<strong>Final Amount: ₹${finalAmount.toLocaleString('en-IN', {minimumFractionDigits: 0, maximumFractionDigits: 0})}</strong>`;
            
            const returnsClass = totalReturns >= 0 ? 'gain' : 'loss';
            document.getElementById('total-returns').innerHTML = 
                `Total Returns: <span class="${returnsClass}">₹${totalReturns.toLocaleString('en-IN', {minimumFractionDigits: 0, maximumFractionDigits: 0})}</span>`;
            
            document.getElementById('return-percentage').innerHTML = 
                `Total Return: <span class="${returnsClass}">${returnPercentage.toFixed(2)}%</span> | CAGR: <span class="${returnsClass}">${cagr.toFixed(2)}%</span>`;

            // Generate year-wise breakdown
            generateYearlyBreakdown(initialInvestment, rate, compoundingFreq, yearsInvestment);

            document.getElementById('result').style.display = 'block';
        }

        function generateYearlyBreakdown(principal, rate, compFreq, totalYears) {
            const breakdownDiv = document.getElementById('yearly-breakdown');
            breakdownDiv.innerHTML = '';

            // Show breakdown for each year (max 10 years to avoid clutter)
            const yearsToShow = Math.min(Math.ceil(totalYears), 10);
            
            for (let year = 1; year <= yearsToShow; year++) {
                const yearAmount = principal * Math.pow((1 + rate / compFreq), compFreq * year);
                const yearGain = yearAmount - principal;
                const yearReturnPct = (yearGain / principal) * 100;
                
                const breakdownItem = document.createElement('div');
                breakdownItem.className = 'breakdown-item';
                
                const gainClass = yearGain >= 0 ? 'gain' : 'loss';
                
                breakdownItem.innerHTML = `
                    <span>Year ${year}:</span>
                    <span class="${gainClass}">₹${yearAmount.toLocaleString('en-IN', {minimumFractionDigits: 0, maximumFractionDigits: 0})} (+${yearReturnPct.toFixed(1)}%)</span>
                `;
                
                breakdownDiv.appendChild(breakdownItem);
            }

            // If investment period is more than 10 years, show final year
            if (totalYears > 10) {
                const finalAmount = principal * Math.pow((1 + rate / compFreq), compFreq * totalYears);
                const finalGain = finalAmount - principal;
                const finalReturnPct = (finalGain / principal) * 100;
                
                const breakdownItem = document.createElement('div');
                breakdownItem.className = 'breakdown-item';
                breakdownItem.style.borderTop = '1px solid #ddd';
                breakdownItem.style.paddingTop = '8px';
                breakdownItem.style.marginTop = '8px';
                
                const gainClass = finalGain >= 0 ? 'gain' : 'loss';
                
                breakdownItem.innerHTML = `
                    <span>Year ${Math.ceil(totalYears)} (Final):</span>
                    <span class="${gainClass}">₹${finalAmount.toLocaleString('en-IN', {minimumFractionDigits: 0, maximumFractionDigits: 0})} (+${finalReturnPct.toFixed(1)}%)</span>
                `;
                
                breakdownDiv.appendChild(breakdownItem);
            }

            // Add investment summary
            const summaryDiv = document.createElement('div');
            summaryDiv.style.marginTop = '10px';
            summaryDiv.style.padding = '8px';
            summaryDiv.style.backgroundColor = '#fff';
            summaryDiv.style.borderRadius = '3px';
            summaryDiv.style.fontSize = '12px';
            summaryDiv.style.color = '#666';
            
            const compoundingText = {
                1: 'annually',
                2: 'semi-annually', 
                4: 'quarterly',
                12: 'monthly',
                365: 'daily'
            };
            
            summaryDiv.innerHTML = `
                <strong>Investment Summary:</strong><br>
                Principal: ₹${principal.toLocaleString('en-IN')}<br>
                Period: ${totalYears} years<br>
                Rate: ${(rate * 100).toFixed(1)}% compounded ${compoundingText[compFreq]}
            `;
            
            breakdownDiv.appendChild(summaryDiv);
        }

        // Allow Enter key to trigger calculation
        document.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                calculateReturns();
            }
        });
    </script>
</body>
</html>