<?php

namespace App\Models;

use App\Models\listing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\JsonResponse;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'listing_id',
        'start_date',
        'end_date',
        'price_per_day',
        'total_days',
        'fee',
        'total_price',
        'status'
    ];

    // kalkulasi attribute yang tidak dinput melalui form oleh user pada table transaksi
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($transaction) {
            $listing = listing::find($transaction->listing_id);

            if (!$listing) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Not Found'
                ], 404);
            }

            $totalDays = Carbon::createFromDate($transaction->start_date)->diffInDays($transaction->end_date) + 1;

            $totalPrice = $listing->price_per_day * $totalDays;
            $fee = $totalPrice * 0.1;

            $transaction->price_per_day = $listing->price_per_day;
            $transaction->total_days = $totalDays;
            $transaction->fee = $fee;
            $transaction->total_price = $totalPrice + $fee;
        });
    }


    /**
     * Get the user that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function listing(): BelongsTo
    {
        return $this->belongsTo(listing::class, 'listing_id');
    }
}
