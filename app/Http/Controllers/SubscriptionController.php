<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionController extends Controller
{
    // Show the payment form
    public function showPaymentForm()
    {
        return view('payment');
    }

    // Handle subscription creation
    public function subscribe(Request $request)
    {
        $user = Auth::user();
        $paymentMethod = $request->paymentMethod;
        $plan = $request->plan;

        try {
            // Create the subscription
            $user->newSubscription('default', $plan)
                ->create($paymentMethod);

            // Generate and download the invoice PDF
            $invoice = $user->invoices()->first();
            // $pdf = $user->downloadInvoice($invoice->id, [
            //     'vendor' => 'Your Company',
            //     'product' => 'Your Product',
            //     'street' => 'Main Str. 1',
            //     'location' => '2000 Antwerp, Belgium',
            //     'phone' => '+32 499 00 00 00',
            //     'email' => 'info@example.com',
            //     'url' => 'https://example.com',
            //     'vendorVat' => 'BE123456789',
            // ]);
            $pdf = $user->downloadInvoice($invoice->id, [
                'vendor' => 'Your Company',
                'product' => 'Your Product',
                'street' => 'Main Str. 1',
                'location' => '2000 Antwerp, Belgium',
                'phone' => '+32 499 00 00 00',
                'email' => 'info@example.com',
                'url' => 'https://example.com',
                'vendorVat' => 'BE123456789',
            ], 'invoice.pdf', null, 'invoice'); // Use the custom invoice view

            return response()->json(['success' => true]);
        } catch (IncompletePayment $exception) {
            // Handle incomplete payment (e.g., 3D Secure)
            return response()->json([
                'success' => false,
                'redirect' => route('cashier.payment', [$exception->payment->id, 'redirect' => route('home')]),
            ]);
        } catch (\Exception $e) {
            // Handle other errors
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
