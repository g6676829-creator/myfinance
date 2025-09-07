<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/new_logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>SIP Calculator</title>
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
        input{
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
    <div class="calculator">
        <h1>SIP Calculator</h1>
        <div class="form-group mt-3">
            <label for="monthly-investment">Monthly Investment (₹)</label>
            <input class="form-control" type="number" id="monthly-investment" placeholder="e.g., 5000">
        </div>
        <div class="form-group mt-3">
            <label for="tenure">Investment Period (Years)</label>
            <input class="form-control" type="number" id="tenure" placeholder="e.g., 10">
        </div>
        <div class="form-group mt-3">
            <label for="return-rate">Expected Annual Return (%)</label>
            <input class="form-control" type="number" id="return-rate" placeholder="e.g., 12">
        </div>
        <button onclick="calculateSIP()" class="btn btn-primary mt-3 w-100">Calculate</button>
        <div class="result" id="result" style="display: none;">
            <h3>Results</h3>
            <p id="invested-amount"></p>
            <p id="estimated-returns"></p>
            <p id="maturity-amount"></p>
        </div>
    </div>
    </div>
    <script>
        function calculateSIP() {
            // Get input values
            const monthlyInvestment = parseFloat(document.getElementById('monthly-investment').value);
            const tenure = parseInt(document.getElementById('tenure').value);
            const returnRate = parseFloat(document.getElementById('return-rate').value);

            // Validate inputs
            if (isNaN(monthlyInvestment) || isNaN(tenure) || isNaN(returnRate)) {
                alert("Please enter valid numbers!");
                return;
            }

            // Calculate SIP maturity value
            const months = tenure * 12;
            const monthlyRate = returnRate / 100 / 12;
            
            // Future Value of SIP formula
            const maturityValue = monthlyInvestment * 
                ((Math.pow(1 + monthlyRate, months) - 1) / monthlyRate) * 
                (1 + monthlyRate);

            const totalInvestment = monthlyInvestment * months;
            const estimatedReturns = maturityValue - totalInvestment;

            // Display results
            document.getElementById('invested-amount').textContent = 
                `Total Invested: ₹${totalInvestment.toLocaleString('en-IN')}`;
            document.getElementById('estimated-returns').textContent = 
                `Estimated Returns: ₹${estimatedReturns.toLocaleString('en-IN')}`;
            document.getElementById('maturity-amount').textContent = 
                `Maturity Value: ₹${maturityValue.toLocaleString('en-IN')}`;
            
            document.getElementById('result').style.display = 'block';
        }
    </script>
</body>
</html>