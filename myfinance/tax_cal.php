<?php require'php/conn.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/new_logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Income Tax Calculator</title>
    <style>
        .outer {
            background-image: url("../images/background.png");
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .calculator {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0px 0px 5px black;
            padding: 30px;
            width: 400px;
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
        .tax-breakdown {
            margin-top: 15px;
            padding: 10px;
            background-color: #f0f8ff;
            border-radius: 3px;
            border: 1px solid #e0e0e0;
        }
        .tax-breakdown h4 {
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
        .tax-slab {
            background-color: #fff;
            padding: 8px;
            margin: 5px 0;
            border-radius: 3px;
            border-left: 3px solid #28a745;
        }
        .deduction-item {
            background-color: #fff;
            padding: 5px;
            margin: 3px 0;
            border-radius: 3px;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
        }
        .tax-amount {
            color: #dc3545;
            font-weight: bold;
        }
        .savings {
            color: #28a745;
            font-weight: bold;
        }
        .regime-switch {
            margin-bottom: 15px;
            text-align: center;
        }
        .regime-switch label {
            margin: 0 10px;
            font-weight: normal;
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
    <div class="outer mt-3">
    <div class="calculator">
        <h1>Income Tax Calculator</h1>
        
        <div class="regime-switch">
            <label><input type="radio" name="regime" value="old" checked> Old Regime</label>
            <label><input type="radio" name="regime" value="new"> New Regime</label>
        </div>

        <div class="form-group mt-3">
            <label for="annual-income">Annual Income (₹)</label>
            <input class="form-control" type="number" id="annual-income" placeholder="e.g., 800000">
        </div>

        <div class="form-group mt-3">
            <label for="age-category">Age Category</label>
            <select class="form-control" id="age-category">
                <option value="below60">Below 60 years</option>
                <option value="senior">Senior Citizen (60-80 years)</option>
                <option value="supersenior">Super Senior Citizen (80+ years)</option>
            </select>
        </div>

        <div id="deductions-section">
            <div class="form-group mt-3">
                <label for="section-80c">Section 80C Deductions (₹)</label>
                <input class="form-control" type="number" id="section-80c" placeholder="PPF, ELSS, Life Insurance (Max: 1,50,000)">
            </div>

            <div class="form-group mt-3">
                <label for="section-80d">Section 80D - Health Insurance (₹)</label>
                <input class="form-control" type="number" id="section-80d" placeholder="Health Insurance Premium">
            </div>

            <div class="form-group mt-3">
                <label for="hra-exemption">HRA Exemption (₹)</label>
                <input class="form-control" type="number" id="hra-exemption" placeholder="House Rent Allowance Exemption">
            </div>

            <div class="form-group mt-3">
                <label for="other-deductions">Other Deductions (₹)</label>
                <input class="form-control" type="number" id="other-deductions" placeholder="80E, 80G, etc.">
            </div>
        </div>

        <button onclick="calculateTax()" class="btn btn-primary mt-3 w-100">Calculate Tax</button>
        
        <div class="result" id="result" style="display: none;">
            <h3>Tax Calculation Results</h3>
            <p id="gross-income"></p>
            <p id="taxable-income"></p>
            <p id="total-tax"></p>
            <p id="net-income"></p>
            
            <div class="tax-breakdown" id="tax-breakdown">
                <h4>Tax Breakdown</h4>
                <div id="slab-breakdown"></div>
            </div>

            <div class="tax-breakdown" id="deduction-summary" style="display: none;">
                <h4>Deduction Summary</h4>
                <div id="deduction-details"></div>
            </div>
        </div>
    </div>
    </div>

    <script>
        // Tax slabs for FY 2024-25
        const taxSlabs = {
            old: {
                below60: [
                    { min: 0, max: 250000, rate: 0 },
                    { min: 250000, max: 500000, rate: 5 },
                    { min: 500000, max: 1000000, rate: 20 },
                    { min: 1000000, max: Infinity, rate: 30 }
                ],
                senior: [
                    { min: 0, max: 300000, rate: 0 },
                    { min: 300000, max: 500000, rate: 5 },
                    { min: 500000, max: 1000000, rate: 20 },
                    { min: 1000000, max: Infinity, rate: 30 }
                ],
                supersenior: [
                    { min: 0, max: 500000, rate: 0 },
                    { min: 500000, max: 1000000, rate: 20 },
                    { min: 1000000, max: Infinity, rate: 30 }
                ]
            },
            new: {
                below60: [
                    { min: 0, max: 300000, rate: 0 },
                    { min: 300000, max: 600000, rate: 5 },
                    { min: 600000, max: 900000, rate: 10 },
                    { min: 900000, max: 1200000, rate: 15 },
                    { min: 1200000, max: 1500000, rate: 20 },
                    { min: 1500000, max: Infinity, rate: 30 }
                ],
                senior: [
                    { min: 0, max: 300000, rate: 0 },
                    { min: 300000, max: 600000, rate: 5 },
                    { min: 600000, max: 900000, rate: 10 },
                    { min: 900000, max: 1200000, rate: 15 },
                    { min: 1200000, max: 1500000, rate: 20 },
                    { min: 1500000, max: Infinity, rate: 30 }
                ],
                supersenior: [
                    { min: 0, max: 300000, rate: 0 },
                    { min: 300000, max: 600000, rate: 5 },
                    { min: 600000, max: 900000, rate: 10 },
                    { min: 900000, max: 1200000, rate: 15 },
                    { min: 1200000, max: 1500000, rate: 20 },
                    { min: 1500000, max: Infinity, rate: 30 }
                ]
            }
        };

        function calculateTax() {
            // Get input values
            const annualIncome = parseFloat(document.getElementById('annual-income').value) || 0;
            const ageCategory = document.getElementById('age-category').value;
            const regime = document.querySelector('input[name="regime"]:checked').value;
            
            // Get deductions (only for old regime)
            let section80c = 0;
            let section80d = 0;
            let hraExemption = 0;
            let otherDeductions = 0;
            
            if (regime === 'old') {
                section80c = Math.min(parseFloat(document.getElementById('section-80c').value) || 0, 150000);
                section80d = parseFloat(document.getElementById('section-80d').value) || 0;
                hraExemption = parseFloat(document.getElementById('hra-exemption').value) || 0;
                otherDeductions = parseFloat(document.getElementById('other-deductions').value) || 0;
            }

            // Validate inputs
            if (annualIncome <= 0) {
                alert("Please enter a valid annual income!");
                return;
            }

            // Calculate total deductions
            const totalDeductions = section80c + section80d + hraExemption + otherDeductions;
            
            // Calculate taxable income
            const taxableIncome = Math.max(0, annualIncome - totalDeductions);
            
            // Calculate tax based on slabs
            const slabs = taxSlabs[regime][ageCategory];
            let tax = 0;
            const slabDetails = [];
            
            for (const slab of slabs) {
                if (taxableIncome > slab.min) {
                    const taxableInThisSlab = Math.min(taxableIncome, slab.max) - slab.min;
                    const taxInThisSlab = (taxableInThisSlab * slab.rate) / 100;
                    tax += taxInThisSlab;
                    
                    if (taxableInThisSlab > 0) {
                        slabDetails.push({
                            range: `₹${slab.min.toLocaleString()} - ${slab.max === Infinity ? 'Above' : '₹' + slab.max.toLocaleString()}`,
                            rate: slab.rate,
                            taxableAmount: taxableInThisSlab,
                            tax: taxInThisSlab
                        });
                    }
                }
            }

            // Add Health and Education Cess (4%)
            const cess = tax * 0.04;
            const totalTax = tax + cess;
            
            // Calculate net income
            const netIncome = annualIncome - totalTax;

            // Display results
            displayResults(annualIncome, taxableIncome, totalTax, netIncome, slabDetails, {
                section80c, section80d, hraExemption, otherDeductions, totalDeductions
            }, regime, tax, cess);
        }

        function displayResults(grossIncome, taxableIncome, totalTax, netIncome, slabDetails, deductions, regime, baseTax, cess) {
            document.getElementById('gross-income').innerHTML = 
                `<strong>Gross Annual Income: ₹${grossIncome.toLocaleString('en-IN')}</strong>`;
            
            document.getElementById('taxable-income').innerHTML = 
                `Taxable Income: ₹${taxableIncome.toLocaleString('en-IN')}`;
            
            document.getElementById('total-tax').innerHTML = 
                `<span class="tax-amount">Total Tax Payable: ₹${totalTax.toLocaleString('en-IN', {minimumFractionDigits: 0, maximumFractionDigits: 0})}</span>`;
            
            document.getElementById('net-income').innerHTML = 
                `<span class="savings">Net Take-home Income: ₹${netIncome.toLocaleString('en-IN', {minimumFractionDigits: 0, maximumFractionDigits: 0})}</span>`;

            // Tax breakdown
            const slabBreakdownDiv = document.getElementById('slab-breakdown');
            slabBreakdownDiv.innerHTML = '';

            slabDetails.forEach(slab => {
                const slabDiv = document.createElement('div');
                slabDiv.className = 'tax-slab';
                slabDiv.innerHTML = `
                    <div class="breakdown-item">
                        <span>${slab.range} @ ${slab.rate}%</span>
                        <span>₹${slab.tax.toLocaleString('en-IN', {minimumFractionDigits: 0, maximumFractionDigits: 0})}</span>
                    </div>
                `;
                slabBreakdownDiv.appendChild(slabDiv);
            });

            // Add cess breakdown
            const cessDiv = document.createElement('div');
            cessDiv.className = 'breakdown-item';
            cessDiv.style.marginTop = '10px';
            cessDiv.style.paddingTop = '10px';
            cessDiv.style.borderTop = '1px solid #ddd';
            cessDiv.innerHTML = `
                <span>Health & Education Cess (4%)</span>
                <span>₹${cess.toLocaleString('en-IN', {minimumFractionDigits: 0, maximumFractionDigits: 0})}</span>
            `;
            slabBreakdownDiv.appendChild(cessDiv);

            // Deduction summary (only for old regime)
            const deductionSummaryDiv = document.getElementById('deduction-summary');
            if (regime === 'old' && deductions.totalDeductions > 0) {
                deductionSummaryDiv.style.display = 'block';
                const deductionDetailsDiv = document.getElementById('deduction-details');
                deductionDetailsDiv.innerHTML = '';

                if (deductions.section80c > 0) {
                    const div = document.createElement('div');
                    div.className = 'deduction-item';
                    div.innerHTML = `<span>Section 80C</span><span>₹${deductions.section80c.toLocaleString('en-IN')}</span>`;
                    deductionDetailsDiv.appendChild(div);
                }

                if (deductions.section80d > 0) {
                    const div = document.createElement('div');
                    div.className = 'deduction-item';
                    div.innerHTML = `<span>Section 80D</span><span>₹${deductions.section80d.toLocaleString('en-IN')}</span>`;
                    deductionDetailsDiv.appendChild(div);
                }

                if (deductions.hraExemption > 0) {
                    const div = document.createElement('div');
                    div.className = 'deduction-item';
                    div.innerHTML = `<span>HRA Exemption</span><span>₹${deductions.hraExemption.toLocaleString('en-IN')}</span>`;
                    deductionDetailsDiv.appendChild(div);
                }

                if (deductions.otherDeductions > 0) {
                    const div = document.createElement('div');
                    div.className = 'deduction-item';
                    div.innerHTML = `<span>Other Deductions</span><span>₹${deductions.otherDeductions.toLocaleString('en-IN')}</span>`;
                    deductionDetailsDiv.appendChild(div);
                }

                const totalDiv = document.createElement('div');
                totalDiv.className = 'deduction-item';
                totalDiv.style.borderTop = '1px solid #ddd';
                totalDiv.style.paddingTop = '5px';
                totalDiv.style.fontWeight = 'bold';
                totalDiv.innerHTML = `<span>Total Deductions</span><span class="savings">₹${deductions.totalDeductions.toLocaleString('en-IN')}</span>`;
                deductionDetailsDiv.appendChild(totalDiv);
            } else {
                deductionSummaryDiv.style.display = 'none';
            }

            document.getElementById('result').style.display = 'block';
        }

        // Toggle deductions section based on regime
        document.addEventListener('change', function(e) {
            if (e.target.name === 'regime') {
                const deductionsSection = document.getElementById('deductions-section');
                if (e.target.value === 'new') {
                    deductionsSection.style.display = 'none';
                } else {
                    deductionsSection.style.display = 'block';
                }
            }
        });

        // Allow Enter key to trigger calculation
        document.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                calculateTax();
            }
        });
    </script>
</body>
</html>