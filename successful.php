<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Successful</title>
    <link rel="stylesheet" href="css/success.css"> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            font-size: 2.5em;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.2em;
            margin: 5px 0;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            width: 300px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1em;
            margin-top: 10px;
        }

        button:hover {
            background-color: #45a049;
        }

        #modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        #modal p {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            margin: 0;
        }

        #modal button {
            margin-top: 10px;
            background-color: #f44336;
        }

        #modal button:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <?php
    // Retrieve token and amount from query parameters
    $token = isset($_GET['token']) ? htmlspecialchars($_GET['token']) : 'N/A';
    $amount = isset($_GET['amount']) ? htmlspecialchars($_GET['amount']) : '0.00';
    ?>

    <div class="total">
        <h1>Purchase Successful</h1>
        <p>Thank you for purchasing electricity tokens.</p>
        <p>Amount Purchased: ZAR <?php echo $amount; ?></p>
        <p>Your Token: <?php echo $token; ?></p>

        <form action="transmit.php" method="POST">
            <label for="transmission">Choose Transmission Method:</label>
            <input type="radio" id="manual" name="transmission" value="manual" required> Manual Transmit<br>
            <input type="radio" id="electronic" name="transmission" value="electronic" required> Electronic Transmit<br>
            <button type="submit">Transmit</button>
        </form>
        <div class="pic">
            <img src="pics/MeterBox.png" alt="meter" style="width: 50px; height: 50px;">
        </div>
        
    </div>
    

    

    <div id="modal" style="display: none;">
        <p>Your tokens have been successfully loaded to your meter box. Thank you for using Khanyisa!</p>
        <button onclick="closeModal()">Close</button>
    </div>
    
    <script>
        // Function to show modal for electronic transmission
        document.getElementById('electronic').addEventListener('change', function() {
            if (this.checked) {
                showModal();
            }
        });

        function showModal() {
            document.getElementById('modal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</body>
</html>
