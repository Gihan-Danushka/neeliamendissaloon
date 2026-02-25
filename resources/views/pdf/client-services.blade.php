<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Service Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #000000;
            margin-bottom: 20px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .logo img {
            max-width: 150px;
            height: auto;
        }

        .client-details {
            margin-bottom: 20px;
        }

        .client-details p {
            margin: 5px 0;
        }

        .total {
            font-weight: bold;
            font-size: 1.2em;
            color: #1e3a8a;
            text-align: right;
        }

        .date {
            text-align: right;
            font-style: italic;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #1e3a8a;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        @media print {
            body {
                background: none;
                margin: 0;
            }

            .invoice-container {
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">

        <div class="logo">
            <img src="../public/images/img/Logo.png" alt="Logo" style="max-width: 30%; height: auto;">

        </div>
        <h1>Client Services Invoice</h1>
        <div class="client-details">
            <p><strong>Name:</strong> {{ $client->name }}</p>
            <p><strong>Email:</strong> {{ $client->email }}</p>
            <p><strong>Contact:</strong> {{ $client->contact }}</p>
            <p><strong>WhatsApp:</strong> {{ $client->whatsapp }}</p>
            <p><strong>Address:</strong> {{ $client->address }}</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Service Name</th>
                    @if (isset($invoiceDetails[0]->color) && $invoiceDetails[0]->color)
                        <th>Colour</th>
                    @endif
                    @if (isset($invoiceDetails[0]->colorCode) && $invoiceDetails[0]->colorCode)
                        <th>Colour Code</th>
                    @endif
                    @if (isset($invoiceDetails[0]->percentage) && $invoiceDetails[0]->percentage)
                        <th>Colour %</th>
                    @endif
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoiceDetails as $detail)
                    <tr>
                        <td>{{ $detail->name }}</td>
                        @if ($detail->color)
                            <td>{{ $detail->color }}</td>
                        @endif
                        @if ($detail->colorCode)
                            <td>{{ $detail->colorCode }}</td>
                        @endif
                        @if ($detail->percentage)
                            <td>{{ $detail->percentage }}%</td>
                        @endif
                        <td>{{ number_format($detail->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total"><strong>Total:</strong> {{ number_format($total, 2) }}</p>
        <p class="date"><strong>Date:</strong> {{ $date }}</p>
    </div>
</body>

</html>
