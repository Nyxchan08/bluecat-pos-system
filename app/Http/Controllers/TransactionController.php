<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $searchTerm = $request->input('searchTerm');
        
        // Query transactions based on the user's role
        $transactionsQuery = Transaction::query()->with(['transactionItems.product']);
    
        if ($user->role !== 'admin') {
            $transactionsQuery->where('user_id', $user->user_id);
        }
    
        // If there's a search term, filter transactions based on it
        if ($searchTerm) {
            $transactionsQuery->where(function($query) use ($searchTerm) {
                $query->where('transaction_id', 'like', '%' . $searchTerm . '%')
                      ->orWhere('total_amount', 'like', '%' . $searchTerm . '%')
                      ->orWhere('transaction_date', 'like', '%' . $searchTerm . '%');
            });
        }
    
        // Retrieve filtered or all transactions based on search
        $transactions = $transactionsQuery->get();
        $transactions = $transactionsQuery->orderBy('transaction_id', 'desc')->get();
    
        return view('transaction.index', compact('transactions', 'searchTerm'));
    }
    
    
        

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'payment_method' => 'required|string|in:cash,credit_card,debit_card', 
        ]);
    
        DB::beginTransaction();
        try {
            $user_id = Auth::id();
            $totalAmount = 0;
            $itemsData = [];
    
            foreach ($request->items as $item) {
                $product = Product::where('product_name', $item['name'])->firstOrFail();
    
                if (!$product->status) {
                    throw new \Exception('The product "' . $item['name'] . '" is inactive and cannot be purchased.');
                }
    
                if ($product->quantity < $item['quantity']) {
                    throw new \Exception('Insufficient quantity available for ' . $item['name']);
                }
    
                $totalPrice = $product->price * $item['quantity'];
                $discountedPrice = $request->discount ? $totalPrice - ($totalPrice * ($request->discount / 100)) : $totalPrice;
                $totalAmount += $discountedPrice;
    
                $itemsData[] = [
                    'product_id' => $product->product_id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'cost_price' => $product->cost_price,
                ];
    
                $product->quantity -= $item['quantity'];
                $product->save();
            }
    
            $change = $request->payment_amount - $totalAmount;
    
            $transaction = Transaction::create([
                'user_id' => $user_id,
                'total_amount' => $totalAmount,
                'transaction_date' => now(),
                'discount' => $request->discount ?? 0,
                'payment_amount' => $request->payment_amount,
                'change' => $change,
                'payment_method' => $request->payment_method,
            ]);
    
            foreach ($itemsData as $itemData) {
                $transaction->transactionItems()->create($itemData);
            }
    
            DB::commit();
    
            return response()->json(['message' => 'Purchase successful!', 'change' => $change], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Transaction error: ', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    
        




    public function download($transactionId)
    {
        $transaction = Transaction::with('transactionItems.product')->find($transactionId);
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $html = View::make('transaction.invoice', ['transaction' => $transaction])->render();
        $dompdf->loadHtml($html);
        $dompdf->render();

        $output = $dompdf->output();
        $pdfPath = 'transactions/invoices/' . $transactionId . '.pdf';
        Storage::put($pdfPath, $output);

        return Storage::download($pdfPath);
    }

    public function preview($transactionId)
    {
        $transaction = Transaction::with('transactionItems.product')->find($transactionId);
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $html = View::make('transaction.invoice', ['transaction' => $transaction])->render();
        $dompdf->loadHtml($html);
        $dompdf->render();

        return $dompdf->stream('transaction_invoice.pdf', ['Attachment' => false]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->transactionItems()->delete(); 
            $transaction->delete(); 
    
            DB::commit();
            return redirect()->route('transactions.index')->with('message_success', 'Transaction deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Transaction deletion error: ', ['error' => $e->getMessage()]);
            return redirect()->route('transactions.index')->with('message_error', 'Failed to delete transaction.');
        }
    }
    
}
    

