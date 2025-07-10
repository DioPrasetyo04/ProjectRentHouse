<?php

namespace App\Filament\Widgets;

use Flowframe\Trend\Trend;
use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use App\Filament\Resources\TransactionResource;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class MonthlyTransactionChart extends ChartWidget
{
    protected static ?int $sort = 1;
    protected static ?string $heading = 'Monthly Transaction';

    protected function getData(): array
    {
        $data = Trend::model(Transaction::class)
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth()
        )->perDay()->count();
        return [
            'datasets' => [
                [
                    'label' => 'Transactions created',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getDescription(): ?string{
        return 'The number of transaction created per month';
    }
}
