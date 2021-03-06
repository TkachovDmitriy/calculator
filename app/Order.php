<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Order extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'delivery',
        'quantity',
        'price',
        'urgency',
        'order_data',
        'comment',
        'application_status_id',
        'order_date',
        'created_at',
        'updated_at'
    ];

    /**
     * @return mixed
     */
    public static function getOrders()
    {
        return DB::table('orders')
            ->select('orders.id', 'name', 'email', 'phone', 'comment', 'orders.created_at',
                'orders.updated_at', 'status', 'address', 'delivery', 'price', 'urgency', 'order_data',
                'quantity', 'order_date')
            ->join('statuses', 'application_status_id', '=', 'statuses.id')
            ->orderByDesc('orders.created_at')
            ->get();
    }

    public static function createOrder(Request $request)
    {
        $result = json_decode($request->data);
        $orderInfo = json_encode($result->orderInfo);

        try {
            $dbResult = DB::table('orders')
                ->insert([
                    'name' => $result->name,
                    'email' => $result->email,
                    'phone' => $result->phone,
                    'comment' => $result->comment,
                    'address' => $result->address,
                    'delivery' => $result->delivery,
                    'quantity' => $result->quantity,
                    'price' => $result->price,
                    'urgency' => $result->urgency,
                    'order_data' => $orderInfo,
                    'application_status_id' => 1,
                    'order_date' => $result->orderDate,
                    'created_at' => Carbon::now()
                ]);
            return $dbResult;
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function deleteOrder($id)
    {
        return DB::table('orders')
            ->where('orders.id', '=', $id)
            ->delete();
    }

    public static function getOrderById($id)
    {
        return DB::table('orders')
            ->where('orders.id', '=', $id)
            ->get();
    }

    /**
     * @param $request
     * @return \Illuminate\Database\Query\Builder
     */
    public static function updateOrder($request)
    {
        DB::table('orders')
            ->where('orders.id', '=', $request->orderId)
            ->update([
                'application_status_id' => $request->status,
                'updated_at' => Carbon::now(),
            ]);
        return back();
    }
}
