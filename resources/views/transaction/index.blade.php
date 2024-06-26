@extends('layout.main')

@section('content')
@include('include.message')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2>Transactions</h2>
            @foreach ($transactions as $transaction)
                <div class="card mb-4">
                    <div class="btn-group" style="position: absolute; top: 10px; right: 10px;">
                        <a href="{{ route('transactions.download', ['id' => $transaction->transaction_id]) }}" class="btn btn-primary btn-sm">Download</a>
                        <a href="{{ route('transactions.preview', ['id' => $transaction->transaction_id]) }}" class="btn btn-secondary btn-sm" target="_blank">Preview</a>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $transaction->transaction_id }}">Delete</button>
                    </div>
                    <div class="card-header">
                        <h4 style="margin-top: 2.5rem">Transaction #{{ $transaction->transaction_id }}</h4>
                        <p>Date: {{ $transaction->transaction_date }}</p>
                        <p>Total Amount: PHP {{ number_format($transaction->total_amount, 2) }}</p>
                        <p>Discount: % {{ $transaction->discount }}</p>
                        <p>Payment Amount: PHP {{ number_format($transaction->payment_amount, 2) }}</p>
                        <p>Change: PHP {{ number_format($transaction->change, 2) }}</p>
                        <p>Payment Method: {{ ucfirst($transaction->payment_method) }}</p>
                    </div>
                    

                    <div class="card-body">
                        <h5>Items</h5>
                        <div style="overflow-x: auto;">
                            <table class="table table-striped">
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
                                            <td>
                                                @if ($item->product)
                                                    {{ $item->product->product_name }}
                                                @else
                                                    Product Not Found
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->product)
                                                    {{ $item->product->sku }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>PHP {{ $item->price }}</td>
                                            <td>PHP {{ $item->quantity * $item->price }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                
                <div class="modal fade" id="deleteModal-{{ $transaction->transaction_id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Delete Transaction</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this transaction?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
                                <form action="{{ route('transactions.destroy', ['id' => $transaction->transaction_id]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


@endsection
