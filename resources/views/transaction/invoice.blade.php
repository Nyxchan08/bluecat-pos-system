<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Invoice</title>
</head>
<body>

    <h2>DON'T BUY AGAIN</h2>
    {{-- <img src="{{asset('img/receipt.jpg')}}" alt="cat"> --}}
    <p>Transaction ID: {{ $transaction->transaction_id }}</p>
    <p>Date: {{ $transaction->transaction_date }}</p>
    <p>Total Amount: PHP {{ number_format($transaction->total_amount, 2) }}</p>
    <p>Discount: % {{ $transaction->discount }}</p>
    <p>Payment Amount: PHP {{ number_format($transaction->payment_amount, 2) }}</p>
    <p>Change: PHP {{ number_format($transaction->change, 2) }}</p>
     
    <h3>Items:</h3>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->transactionItems as $item)
            <tr>
                <td>{{ $item->product->product_name }}</td>
                <td>{{ $item->product->sku }}</td>
                <td>{{ $item->quantity }}</td>
                <td>PHP {{ $item->price }}</td>
                <td>PHP {{ $item->quantity * $item->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>