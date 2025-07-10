<?php

namespace App\Http\Controllers\API;

use App\Models\listing;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Transaction\Store;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransactionController extends Controller
{
    public function index(){
        $transactions = Transaction::query()->with(['listing', 'user'])->where('user_id', Auth::user()->id)->paginate(10);

        return response()->json([
           'success' => true,
           'message' =>  'Get all my transactions',
           'data' => $transactions,
        ]);
    }

    public function store(Store $request){
        $this->_fullyBookedChecker($request);

        $transaction = Transaction::create([
            'listing_id' => $request->listing_id,
            'start_date'=> $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => Auth::user()->id,
        ]);

        $transaction->Listing;

        return response()->json([
            'success'=> true,
            'data' => $transaction,
        ]);
    }

    public function show($slug): JsonResponse{
        // $user = Auth::user()->id;

        // if(!$user){
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Unauthorized'
        //     ], JsonResponse::HTTP_UNAUTHORIZED);
        // }

        $transaction = Transaction::query()->with(['listing'])->whereHas('listing', function($query) use ($slug){
            $query->where('slug', $slug);
        })->where('user_id', Auth::user()->id)->get();

        if(!$transaction){
            return response()->json([
                'success'=> false,
                'message' => 'Unauthorized'
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get Detail Transaction',
            'data' => $transaction
        ]);
    }

    public function isAvailable(Store $request, listing $listing){
        $this->_fullyBookedChecker($request);
        $listing = listing::findOrFail($request->listing_id);

        return response()->json([
            'success' => true,
            'message' => 'Listing is ready to book',
            'data' => $listing,
        ]);
    }

    private function _fullyBookedChecker(Store $request){
        $listing = listing::find($request->listing_id);
        $runningTransactionCount = Transaction::query()->where('listing_id', $listing->id)
        ->whereNot('status', 'canceled')
        ->where(function($query) use ($request){
            $query->whereBetween('start_date', [
                $request->start_date,
                $request->end_date,
            ])->orWhereBetween('end_date', [
                $request->start_date,
                $request->end_date
            ])->orWhere(function($subquery) use ($request){
                $subquery->where('start_date', '<=', $request->start_date)->where('end_date', '>=', $request->end_date);
            });
        })->count();

        if($runningTransactionCount >= $listing->max_person){
            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => 'Listing is fully booked',
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
        return true;
    }
}
