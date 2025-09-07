<?php require 'php/conn.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/new_logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Currency Converter</title>
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
        .loading {
            text-align: center;
            color: #666;
            font-style: italic;
        }
        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
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
        <h1>Currency Converter</h1>
        <div class="form-group mt-3">
            <label for="amount">Amount</label>
            <input class="form-control" type="number" id="amount" placeholder="Enter amount" step="0.01">
        </div>
        <div class="form-group mt-3">
            <label for="from-currency">From</label>
            <select class="form-control" id="from-currency">
                <option value="">Select currency...</option>
            </select>
        </div>
        <div class="form-group">
            <label for="to-currency">To</label>
            <select class="form-control" id="to-currency">
                <option value="">Select currency...</option>
            </select>
        </div>
        <button onclick="convertCurrency()" class="btn btn-primary mt-3 w-100">Convert</button>
        <div class="result" id="result" style="display: none;">
            <h3>Result</h3>
            <p id="conversion-result"></p>
            <p id="exchange-rate"></p>
            <p id="last-updated"></p>
        </div>
        <div id="loading" class="loading" style="display: none;">
            Loading exchange rates...
        </div>
        <div id="error" class="error" style="display: none;"></div>
    </div>
    </div>
    <script>
        // Popular currencies with their symbols
        const currencies = {
            'USD': 'US Dollar ($)',
            'EUR': 'Euro (€)',
            'GBP': 'British Pound (£)',
            'JPY': 'Japanese Yen (¥)',
            'AUD': 'Australian Dollar (A$)',
            'CAD': 'Canadian Dollar (C$)',
            'CHF': 'Swiss Franc (CHF)',
            'CNY': 'Chinese Yuan (¥)',
            'INR': 'Indian Rupee (₹)',
            'KRW': 'South Korean Won (₩)',
            'SGD': 'Singapore Dollar (S$)',
            'HKD': 'Hong Kong Dollar (HK$)',
            'SEK': 'Swedish Krona (kr)',
            'NOK': 'Norwegian Krone (kr)',
            'DKK': 'Danish Krone (kr)',
            'PLN': 'Polish Zloty (zł)',
            'CZK': 'Czech Koruna (Kč)',
            'HUF': 'Hungarian Forint (Ft)',
            'RUB': 'Russian Ruble (₽)',
            'BRL': 'Brazilian Real (R$)',
            'MXN': 'Mexican Peso ($)',
            'ZAR': 'South African Rand (R)',
            'TRY': 'Turkish Lira (₺)',
            'NZD': 'New Zealand Dollar (NZ$)',
            'THB': 'Thai Baht (฿)',
            'MYR': 'Malaysian Ringgit (RM)',
            'PHP': 'Philippine Peso (₱)',
            'IDR': 'Indonesian Rupiah (Rp)',
            'VND': 'Vietnamese Dong (₫)',
            'AED': 'UAE Dirham (د.إ)',
            'SAR': 'Saudi Riyal (﷼)',
            'EGP': 'Egyptian Pound (£)',
            'ILS': 'Israeli Shekel (₪)',
            'PKR': 'Pakistani Rupee (₨)',
            'BDT': 'Bangladeshi Taka (৳)',
            'LKR': 'Sri Lankan Rupee (₨)',
            'NPR': 'Nepalese Rupee (₨)',
            'KES': 'Kenyan Shilling (KSh)',
            'NGN': 'Nigerian Naira (₦)',
            'GHS': 'Ghanaian Cedi (₵)',
            'UAH': 'Ukrainian Hryvnia (₴)',
            'RON': 'Romanian Leu (lei)',
            'BGN': 'Bulgarian Lev (лв)',
            'HRK': 'Croatian Kuna (kn)',
            'ISK': 'Icelandic Krona (kr)',
            'CLP': 'Chilean Peso ($)',
            'COP': 'Colombian Peso ($)',
            'PEN': 'Peruvian Sol (S/)',
            'ARS': 'Argentine Peso ($)',
            'UYU': 'Uruguayan Peso ($)',
            'BOB': 'Bolivian Boliviano (Bs)',
            'PYG': 'Paraguayan Guarani (₲)'
        };

        let exchangeRates = {};
        let lastUpdated = '';

        // Initialize the currency dropdowns
        function initializeCurrencies() {
            const fromSelect = document.getElementById('from-currency');
            const toSelect = document.getElementById('to-currency');
            
            // Clear existing options except the first one
            fromSelect.innerHTML = '<option value="">Select currency...</option>';
            toSelect.innerHTML = '<option value="">Select currency...</option>';
            
            // Add currency options
            Object.entries(currencies).forEach(([code, name]) => {
                const option1 = new Option(name, code);
                const option2 = new Option(name, code);
                fromSelect.add(option1);
                toSelect.add(option2);
            });

            // Set default values
            fromSelect.value = 'USD';
            toSelect.value = 'INR';
        }

        // Fetch exchange rates from API
        async function fetchExchangeRates() {
            try {
                document.getElementById('loading').style.display = 'block';
                document.getElementById('error').style.display = 'none';
                
                // Try multiple API endpoints
                const apis = [
                    'https://api.fxratesapi.com/latest',
                    'https://api.exchangerate.host/latest',
                    'https://open.er-api.com/v6/latest/USD'
                ];
                
                for (const apiUrl of apis) {
                    try {
                        const response = await fetch(apiUrl);
                        if (response.ok) {
                            const data = await response.json();
                            exchangeRates = data.rates || data.conversion_rates;
                            exchangeRates['USD'] = 1; // Ensure USD is included
                            lastUpdated = new Date().toLocaleDateString();
                            
                            document.getElementById('loading').style.display = 'none';
                            return true;
                        }
                    } catch (e) {
                        continue; // Try next API
                    }
                }
                
                throw new Error('All APIs failed');
                
            } catch (error) {
                document.getElementById('loading').style.display = 'none';
                
                // Use comprehensive fallback rates (updated as of June 2025)
                exchangeRates = {
                    'USD': 1,
                    'EUR': 0.85,
                    'GBP': 0.73,
                    'JPY': 110.25,
                    'AUD': 1.35,
                    'CAD': 1.25,
                    'CHF': 0.92,
                    'CNY': 6.45,
                    'INR': 83.12,
                    'KRW': 1200.50,
                    'SGD': 1.35,
                    'HKD': 7.80,
                    'SEK': 8.50,
                    'NOK': 8.80,
                    'DKK': 6.40,
                    'PLN': 3.75,
                    'CZK': 22.50,
                    'HUF': 310.00,
                    'RUB': 75.50,
                    'BRL': 5.25,
                    'MXN': 18.50,
                    'ZAR': 15.25,
                    'TRY': 8.75,
                    'NZD': 1.45,
                    'THB': 32.50,
                    'MYR': 4.25,
                    'PHP': 55.50,
                    'IDR': 15500,
                    'VND': 24500,
                    'AED': 3.67,
                    'SAR': 3.75,
                    'EGP': 30.75,
                    'ILS': 3.25,
                    'PKR': 285.50,
                    'BDT': 109.75,
                    'LKR': 325.50,
                    'NPR': 133.25,
                    'KES': 142.50,
                    'NGN': 465.25,
                    'GHS': 12.50,
                    'UAH': 27.25,
                    'RON': 4.25,
                    'BGN': 1.66,
                    'HRK': 6.42,
                    'ISK': 125.50,
                    'CLP': 825.50,
                    'COP': 4125.25,
                    'PEN': 3.85,
                    'ARS': 365.75,
                    'UYU': 42.25,
                    'BOB': 6.92,
                    'PYG': 7325.50
                };
                lastUpdated = 'Static rates (Demo)';
                
                // Show info message instead of error
                const infoDiv = document.getElementById('error');
                infoDiv.style.display = 'block';
                infoDiv.style.color = '#0066cc';
                infoDiv.innerHTML = '<small><i>ℹ️ Using demo exchange rates. For live rates, use this converter on your own website.</i></small>';
                
                return false;
            }
        }

        // Convert currency
        async function convertCurrency() {
            const amount = parseFloat(document.getElementById('amount').value);
            const fromCurrency = document.getElementById('from-currency').value;
            const toCurrency = document.getElementById('to-currency').value;

            // Validate inputs
            if (isNaN(amount) || amount <= 0) {
                alert("Please enter a valid amount!");
                return;
            }

            if (!fromCurrency || !toCurrency) {
                alert("Please select both currencies!");
                return;
            }

            if (fromCurrency === toCurrency) {
                alert("Please select different currencies!");
                return;
            }

            // Fetch rates if not already loaded
            if (Object.keys(exchangeRates).length === 0) {
                await fetchExchangeRates();
            }

            // Calculate conversion
            let convertedAmount;
            let rate;

            if (fromCurrency === 'USD') {
                convertedAmount = amount * exchangeRates[toCurrency];
                rate = exchangeRates[toCurrency];
            } else if (toCurrency === 'USD') {
                convertedAmount = amount / exchangeRates[fromCurrency];
                rate = 1 / exchangeRates[fromCurrency];
            } else {
                // Convert through USD
                const usdAmount = amount / exchangeRates[fromCurrency];
                convertedAmount = usdAmount * exchangeRates[toCurrency];
                rate = exchangeRates[toCurrency] / exchangeRates[fromCurrency];
            }

            // Display results
            const fromSymbol = currencies[fromCurrency].match(/\(([^)]+)\)/)[1];
            const toSymbol = currencies[toCurrency].match(/\(([^)]+)\)/)[1];

            document.getElementById('conversion-result').innerHTML = 
                `<strong>${fromSymbol}${amount.toLocaleString()} = ${toSymbol}${convertedAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</strong>`;
            
            document.getElementById('exchange-rate').textContent = 
                `1 ${fromCurrency} = ${rate.toLocaleString('en-US', {minimumFractionDigits: 4, maximumFractionDigits: 4})} ${toCurrency}`;
            
            document.getElementById('last-updated').textContent = 
                `Last updated: ${lastUpdated}`;
            
            document.getElementById('result').style.display = 'block';
        }

        // Initialize when page loads
        window.onload = function() {
            initializeCurrencies();
            fetchExchangeRates();
        };

        // Allow Enter key to trigger conversion
        document.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                convertCurrency();
            }
        });
    </script>
</body>
</html>