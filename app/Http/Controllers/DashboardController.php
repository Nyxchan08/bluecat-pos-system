<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\TransactionItem;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalTransactions = Transaction::count();
        $totalSales = Transaction::sum('total_amount');
        $stocksPerProduct = Product::select('product_name', 'quantity')->get();
        $lowStockProducts = Product::where('quantity', '<', 10)->get();
        $totalSuppliers = Supplier::count();
    
        // Calculate total products sold
        $totalProductsSold = TransactionItem::sum('quantity');
        
        // Calculate total products available (products with quantity > 0)
        $totalProductsAvailable = Product::where('quantity', '>', 0)->count();
    
        // Calculate total low stock products
        $totalLowStockProducts = Product::where('quantity', '<', 10)->count();
        
        // Calculate total unavailable products
        $totalProductsUnavailable = Product::where('quantity', '=', 0)->count();
    
        // Calculate total cost price and total net revenue
        $totalCostPrice = TransactionItem::sum(DB::raw('quantity * cost_price'));
        
        // Calculate total net revenue
        $totalNetRevenue = TransactionItem::sum(DB::raw('(quantity * (price - cost_price))'));// Net revenue per item
    
        // Calculate total revenue
        $totalRevenue = Transaction::sum('total_amount');
    
        // Calculate net revenue
        $netRevenue = $totalNetRevenue;
    
        // Sales data for the graph (dummy data, replace with real data)
        $salesData = Transaction::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
                                  ->groupBy('date')
                                  ->orderBy('date')
                                  ->get();
    
        return view('dashboard.index', compact(
            'totalUsers', 'totalTransactions', 'totalSales', 'stocksPerProduct', 'lowStockProducts',
            'totalSuppliers', 'totalProductsSold', 'totalProductsAvailable', 'totalLowStockProducts',
            'totalRevenue', 'netRevenue', 'salesData', 'totalProductsUnavailable'
        ));
    }
}
