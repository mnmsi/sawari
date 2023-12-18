<?php

namespace App\Nova;

use App\Nova\Actions\Order\OrderCanceledActions;
use App\Nova\Actions\Order\OrderCompletedActions;
use App\Nova\Actions\Order\OrderDeliveredActions;
use App\Nova\Actions\Order\OrderInvoiceActions;
use App\Nova\Actions\Order\OrderPendingActions;
use App\Nova\Actions\Order\OrderProcessingActions;
use App\Nova\Filters\OrderByDateFilter;
use App\Nova\Filters\OrderStatusFilter;
use App\Nova\Metrics\OrderPerDay;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Query\Search\SearchableRelation;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Order\Order>
     */
    public static $model = \App\Models\Order\Order::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'transaction_id';
    public static $group = 'Orders';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'transaction_id',
    ];

    public static function label()
    {
        return __('Order List');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Name of the customer', 'name')->required(),
//            user
            BelongsTo::make('User', 'user', 'App\Nova\User')
                ->rules('required')
                ->noPeeking(),
            Text::make('Phone', 'phone')->required(),
            Text::make('City', 'city')->required(),
            Text::make('Division', 'division')->required(),
            Text::make('Area', 'area')->required(),
            Text::make('Address Line', 'address_line')->required(),
//            payment method
            BelongsTo::make('Payment Method', 'paymentMethod', 'App\Nova\PaymentMethods')
                ->rules('required')
                ->noPeeking(),
//            delivery
            BelongsTo::make('Delivery Type', 'deliveryOption', 'App\Nova\DeliveryOption')
                ->rules('required')
                ->noPeeking(),
//            user address
//            BelongsTo::make('User address', 'userAddress', 'App\Nova\UserAddress')
//                ->nullable()
//                ->noPeeking(),
//            showroom
            BelongsTo::make('Showroom', 'showRooms', 'App\Nova\Showroom')
                ->nullable()
                ->noPeeking(),
//            transaction id
            Text::make('Transaction key', 'transaction_id')
                ->sortable()
                ->nullable()
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter key',
                    ],
                ]),
//            order key
            Text::make('Order key', 'order_key')
                ->sortable()
                ->nullable()
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => 'Enter key',
                    ],
                ]),
//            discount
            Number::make('Discount', 'discount_rate')
                ->min(0)
                ->step('any')
                ->nullable(),
//            shipping amount
            Number::make('Shipping amount', 'shipping_amount')
                ->min(0)
                ->step('any')
                ->nullable(),
//            sub total
            Number::make('Sub total', 'subtotal_price')
                ->min(0)
                ->step('any')
                ->rules('required'),
//            total
            Number::make('Total', 'total_price')
                ->min(0)
                ->step('any')
                ->rules('required'),
//            status
            //            status
            Select::make('Status', 'status')->options([
                'pending' => 'Pending',
                'processing' => 'Processing',
                'completed' => 'Completed',
                'delivered' => 'Delivered',
                'cancelled' => 'Cancelled',
            ])->rules('required')->hideFromIndex()
                ->hideFromDetail(),

            Badge::make('Status', 'status')->map([
                'pending' => 'warning',
                'processing' => 'info',
                'completed' => 'success',
                'delivered' => 'success',
                'cancelled' => 'danger',
            ]),
//            date
            DateTime::make('Created At', 'created_at')
                ->default(now())
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Updated At', 'updated_at')
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->default(now()),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            new OrderPerDay,
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new OrderStatusFilter,
            new OrderByDateFilter,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            new OrderInvoiceActions(),
            new OrderPendingActions(),
            new OrderProcessingActions(),
            new OrderDeliveredActions(),
            new OrderCompletedActions(),
            new OrderCanceledActions(),

            (new OrderInvoiceActions())->onlyOnTableRow(),
            (new OrderPendingActions())->onlyOnTableRow(),
            (new OrderProcessingActions())->onlyOnTableRow(),
            (new OrderDeliveredActions())->onlyOnTableRow(),
            (new OrderCompletedActions())->onlyOnTableRow(),
            (new OrderCanceledActions())->onlyOnTableRow(),
        ];
    }

    public static function searchableColumns()
    {
        return [
            'id',
            new SearchableRelation('user', 'email'),
            new SearchableRelation('paymentMethod', 'name'),
            new SearchableRelation('deliveryOption', 'name'),
            new SearchableRelation('showRooms', 'name'),
        ];
    }

    public static function authorizedToCreate(Request $request): bool
    {
        return false;
    }
}
