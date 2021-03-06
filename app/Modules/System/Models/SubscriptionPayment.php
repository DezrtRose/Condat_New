<?php namespace App\Modules\System\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model {

    protected $table = "subscription_payments";
    protected $connection = 'master';
    protected $primaryKey = "subscription_payment_id";

    protected $fillable = array('amount', 'payment_date', 'payment_type', 'agency_subscription_id', 'stripe_transaction_id');

    public $timestamps = false;

}
