<?php

namespace App\Nova\Metrics;

use App\Nova\Order;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Metrics\Table;

class RecentOrder extends Table
{
    public $name = "Recent Orders";

    public function calculate(NovaRequest $request)
    {
        $result = [];
        $order = \App\Models\Order\Order::with(["user:id,email", "product:id,name"])->orderBy("id", "Desc")->take(10)->get();
        foreach ($order as $o) {
            $result[] = MetricTableRow::make()
                ->title($o['order_key'])
                ->subtitle("User: " . $o['user']['email'] . "  Amount: " . $o['total_price'])
                ->actions(function () {
                    return [
                        MenuItem::resource(Order::class),
                    ];
                });
        }
        return $result;
    }

    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }
}
