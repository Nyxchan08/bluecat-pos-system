@extends('layout.main')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card text-white " style="background-color: rgb(104, 3, 104)">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background-color: rgb(226, 143, 17)">
                <div class="card-body">
                    <h5 class="card-title">Total Transactions</h5>
                    <p class="card-text">{{ $totalTransactions }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background-color: rgb(197, 58, 3)">
                <div class="card-body">
                    <h5 class="card-title">Total Sales</h5>
                    <p class="card-text">PHP {{ number_format($totalSales, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Total Suppliers</h5>
                    <p class="card-text">{{ $totalSuppliers }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">Total Products Sold</h5>
                    <p class="card-text">{{ $totalProductsSold }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background-color: rgb(13, 116, 13)">
                <div class="card-body">
                    <h5 class="card-title">Total Products Available</h5>
                    <p class="card-text">{{ $totalProductsAvailable }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-dark">
                <div class="card-body">
                    <h5 class="card-title">Total Low Stock Products</h5>
                    <p class="card-text">{{ $totalLowStockProducts }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <p class="card-text">PHP {{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background-color: rgb(88, 165, 0)">
                <div class="card-body">
                    <h5 class="card-title">Net Revenue</h5>
                    <p class="card-text">PHP {{ number_format($netRevenue, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white" style="background-color: rgb(151, 3, 3)">
                <div class="card-body">
                    <h5 class="card-title">Total Products Unavailable</h5>
                    <p class="card-text">{{ $totalProductsUnavailable }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sales Chart</h5>
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    

    <h2 class="mt-5">Stocks Available Per Product</h2>
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocksPerProduct as $product)
            <tr>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="mt-5">Low Stock Products</h2>
    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lowStockProducts as $product)
            <tr class="low-stock">
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($salesData->pluck('date')),
            datasets: [{
                label: 'Sales',
                data: @json($salesData->pluck('total')),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
