<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProofOfDeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Upload proof of delivery (photo)
     */
    public function uploadProof(Request $request)
    {
        $orderId = $request->input('order_id');
        $driverId = $request->input('driver_id');

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = 'proof_of_delivery_' . $orderId . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('proof_of_delivery', $filename, 'public');

            // Update order in Firestore
            $database = app('firebase.firestore')->database();
            $orderRef = $database->collection('orders')->document($orderId);
            
            $orderRef->update([
                'proofOfDelivery' => [
                    'photoUrl' => Storage::url($path),
                    'filename' => $filename,
                    'uploadedBy' => $driverId,
                    'uploadedAt' => app('firebase.firestore')->database()->timestamp(),
                    'verified' => false
                ],
                'orderStatus' => 'Delivered'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Proof of delivery uploaded successfully',
                'photoUrl' => Storage::url($path)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to upload proof of delivery'
        ], 400);
    }

    /**
     * Verify proof of delivery
     */
    public function verifyProof(Request $request)
    {
        $orderId = $request->input('order_id');
        $verified = $request->input('verified', true);
        $adminId = auth()->id();

        $database = app('firebase.firestore')->database();
        $orderRef = $database->collection('orders')->document($orderId);
        
        $orderRef->update([
            'proofOfDelivery.verified' => $verified,
            'proofOfDelivery.verifiedBy' => $adminId,
            'proofOfDelivery.verifiedAt' => app('firebase.firestore')->database()->timestamp()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proof of delivery ' . ($verified ? 'verified' : 'rejected') . ' successfully'
        ]);
    }

    /**
     * Get proof of delivery for order
     */
    public function getProof($orderId)
    {
        $database = app('firebase.firestore')->database();
        $orderRef = $database->collection('orders')->document($orderId);
        $order = $orderRef->snapshot()->data();

        if (!$order || !isset($order['proofOfDelivery'])) {
            return response()->json([
                'success' => false,
                'message' => 'Proof of delivery not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'proof' => $order['proofOfDelivery']
        ]);
    }

    /**
     * Download proof of delivery
     */
    public function downloadProof($orderId)
    {
        $database = app('firebase.firestore')->database();
        $orderRef = $database->collection('orders')->document($orderId);
        $order = $orderRef->snapshot()->data();

        if (!$order || !isset($order['proofOfDelivery'])) {
            return response()->json([
                'success' => false,
                'message' => 'Proof of delivery not found'
            ], 404);
        }

        $proof = $order['proofOfDelivery'];
        
        if (Storage::disk('public')->exists('proof_of_delivery/' . $proof['filename'])) {
            return Storage::download('public/proof_of_delivery/' . $proof['filename']);
        }

        return response()->json([
            'success' => false,
            'message' => 'Proof of delivery file not found'
        ], 404);
    }
}
