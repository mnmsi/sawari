<?php

namespace App\Models\Order;

use App\Models\System\Showroom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Order extends BaseModel
{
    protected $fillable = [
        'user_id',
        'payment_method_id',
        'delivery_option_id',
        'user_address_id',
        'showroom_id',
        'transaction_id',
        'price',
        'discount_rate',
        'shipping_amount',
        'subtotal_price',
        'total_price',
        'status',
        'created_at',
        'updated_at'
    ];

    public function showRooms()
    {
        return $this->hasMany(ShowRoom::class);
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product\Product');
    }

    public function productColor()
    {
        return $this->belongsTo('App\Models\Product\ProductColor');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\System\PaymentMethod');
    }

    public function deliveryOption()
    {
        return $this->belongsTo('App\Models\System\DeliveryOption');
    }

    public function userAddress()
    {
        return $this->belongsTo('App\Models\User\UserAddress');
    }

    public function orderStatus()
    {
        return $this->hasMany('App\Models\Order\OrderStatus');
    }

}

