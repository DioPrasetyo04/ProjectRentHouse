<?php

namespace App\Filament\Widgets;

use App\Models\listing;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 3;
    private function getPercentage(int $from, int $to){
        return $to - $from / ($to + $from / 2) * 100;
    }
    protected function getStats(): array
    {
        $newListing = listing::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count();
        $transactions = Transaction::whereStatus('approved')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year);
        $prevTransactions = Transaction::whereStatus('approved')->whereMonth('created_at', Carbon::now()->subMonth()->month)->whereYear('created_at', Carbon::now()->subMonth()->year);
        $transactionsCount = $transactions->count();
        $prevTransactionsCount = $prevTransactions->count();
        $transactionsPercentage = $this->getPercentage($prevTransactionsCount, $transactionsCount);
        $revenuePercentage = $this->getPercentage($prevTransactions->sum('total_price'), $transactions->sum('total_price'));

        return [
            Stat::make('New Listing Of The Month', $newListing),
            Stat::make('Transaction Of The Month', $transactionsCount)
            ->description($transactionsPercentage > 0 ? "{$transactionsPercentage}% increased" : "{$transactionsPercentage}% decreased")
            ->descriptionIcon($transactionsPercentage > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
            ->color($transactionsPercentage > 0 ? 'success' : 'danger'),
            Stat::make('Revenue of the month', Number::currency($transactions->sum('total_price'), 'USD'))
            ->description($revenuePercentage > 0 ? "{$revenuePercentage}% increased" : "{$revenuePercentage}% decreased")
            ->descriptionIcon($revenuePercentage > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
            ->color($revenuePercentage > 0 ? 'success' : 'danger')
        ];
    }
}
