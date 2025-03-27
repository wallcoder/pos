<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .invoice-container {
            background: #fff;
            width: 80%;
            max-width: 600px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid black;
        }

        .invoice-header h2 {
            color: black;
        }

        .invoice-details {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }

        .invoice-details p {
            margin-bottom: 10px;
            font-size: 16px;
            color: #333;
        }

        .invoice-footer {
            text-align: center;
            margin-top: 20px;
        }

        .download-btn {
            display: inline-block;
            padding: 10px 15px;
            background: black;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
        }

        .download-btn:hover {
            background: rgb(48, 48, 48);
        }

    </style>
</head>
<body>

    <div class="invoice-container">
        <div class="invoice-header">
            <h2>Invoice #{{ $order->id }}</h2>
            <p>Date: {{ $order->created_at->format('d M Y') }}</p>
        </div>

        <div class="invoice-details">
            <p><strong>Customer Phone:</strong> {{ $order->phone }}</p>
            <p><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
            <p><strong>Final Amount:</strong> ₹{{ number_format($order->final_amount, 2) }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
        </div>

        <div class="invoice-footer">
            <a href="{{ url("/invoices/{$order->id}/download") }}" class="download-btn">Download PDF</a>
        </div>
    </div>

</body>
</html>
