<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-details,
        .invoice-items,
        .invoice-totals {
            width: 100%;
            margin-bottom: 20px;
        }

        .invoice-items th,
        .invoice-items td {
            text-align: left;
            padding: 5px;
        }

        .invoice-items th {
            border-bottom: 1px solid #000;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="invoice-header">
        <h2>RAGA PVT LTD</h2>
        <p>S USMAN ROAD, T. NAGAR, CHENNAI, TAMIL NADU</p>
        <p>PHONE: 044 25836222 | GSTIN: 33AAAGP0685F1ZH</p>
        <h3>Retail Invoice</h3>
    </div>

    <table class="invoice-details">
        <tr>
            <td>Date: {{ $date }}</td>
            <td class="text-right">Bill No: {{ $bill_no }}</td>
        </tr>
        <tr>
            <td>Payment Mode: {{ $payment_mode }}</td>
            <td class="text-right">DR Ref: {{ $dr_ref }}</td>
        </tr>
    </table>

    <table class="invoice-items">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th class="text-right">Amt</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>
                    {{ $item['name'] }}
                    @if($item['properties']->isNotEmpty())
                    <ul>
                        @foreach($item['properties'] as $property)
                        <li>{{ $property['name'] }} (+{{ number_format($property['price'], 2) }})</li>
                        @endforeach
                    </ul>
                    @endif
                </td>
                <td>{{ $item['quantity'] }}</td>
                <td class="text-right">{{ number_format($item['total_price'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="invoice-totals">
        <tr>
            <td>Sub Total</td>
            <td class="text-right">{{ number_format($subtotal, 2) }}</td>
        </tr>
        <tr>
            <td>Discount</td>
            <td class="text-right">-{{ number_format($discount, 2) }}</td>
        </tr>
        @foreach($taxes as $tax)
        <tr>
            <td>{{ $tax['name'] }} @ {{ $tax['rate'] }}%</td>
            <td class="text-right">{{ number_format($tax['amount'], 2) }}</td>
        </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td class="text-right">{{ number_format($total, 2) }}</td>
        </tr>
        <tr>
            <td>Cash</td>
            <td class="text-right">{{ number_format($cash, 2) }}</td>
        </tr>
        <tr>
            <td>Cash Tendered</td>
            <td class="text-right">{{ number_format($cash_tendered, 2) }}</td>
        </tr>
    </table>
</body>

</html>