<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 40px;
        }

        h1 {
            color: #2563eb;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
        }

        .total {
            font-weight: bold;
        }

        .header {
            margin-bottom: 20px;
        }

        .header p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Invoice</h1>
        <p><strong>Order ID:</strong> MSBD-ORD-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
        <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
        <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
        <p><strong>Shipping Method:</strong> {{ $order->shipping_method }}</p>
        <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Quantity</th>
                <th>Price (Tk)</th>
                <th>Total (Tk)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                @php
                    $isVariant = $item->orderable instanceof \App\Models\ProductVariant;
                    $productName = $isVariant
                        ? ($item->orderable->product->name ?? $item->name) .
                            ' - ' .
                            ($item->orderable->variantValue->name ?? '')
                        : $item->orderable->name ?? $item->name;
                    $sku = $item->orderable->sku ?? $item->sku;
                @endphp
                <tr>
                    <td>{{ $productName }}</td>
                    <td>{{ $sku }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price) }}</td>
                    <td>{{ number_format($item->total) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"></td>
                <td><strong>Delivery Charge</strong></td>
                <td>{{ number_format($order->delivery_charge) }}</td>
            </tr>
            <tr class="total">
                <td colspan="3"></td>
                <td>Total</td>
                <td>{{ number_format($order->total_amount) }}</td>
            </tr>
        </tbody>

    </table>
</body>

</html>
