<?php

namespace App\Jobs;

use App\Mail\DataToOwners;
use App\Models\Admin;
use App\Models\Orders;
use App\Models\Phones;
use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\File;

class SendOrdersToOwners implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        /** @var Admin $owners_check */
        $owners_check = Admin::where('owner', '=', 1)->exists();

        if (!$owners_check) {
            return throw new Exception('There is no owners.');
        }

        /** @var string $filename */
        $filename = 'public/total_orders.csv';

        /** @var File $file */
        $file = fopen($filename, 'w');

        if (!$file) {
            return throw new Exception('Can not open file.');
        }

        /** @var Carbon $start_of_day */
        $start_of_day = Carbon::now()
            ->setDay(Carbon::now()->get('day') - 1)
            ->setTime(0, 0, 1);
        /** @var Carbon $end_of_day */
        $end_of_day = Carbon::now()->setTime(0, 0);

        /** @var Orders $orders_check */
        $orders_check = Orders::whereBetween('created_at', [
            $start_of_day,
            $end_of_day
        ])->exists();

        if (!$orders_check) {
            fclose($file);
            return throw new Exception('There are no orders.');
        }

        /** @var Orders $orders */
        $orders = Orders::whereBetween('created_at', [
            $start_of_day,
            $end_of_day
        ])
            ->selectRaw(
                'user_id,
                phone_id,
                created_at,
                sum(total_price) as total_price,
                sum(amount) as amount'
            )
            ->groupBy([
                'phone_id',
                'user_id',
                'created_at',
            ])
            ->orderBy('total_price')
            ->get();

        fputcsv($file, ['Date', 'Model', 'Amount', 'Customer', 'Total Price']);

        $orders = $orders->sortByDesc('total_price');

        foreach ($orders as $order) {
            fputcsv($file, [
                $order->created_at,
                $order->phoneRelation->model,
                $order->amount,
                $order->userRelation->name,
                $order->total_price
            ]);
        }

        fclose($file);


        /** @var Admin $owners */
        $owners = Admin::query()->where('owner', '=', 1)->get();

        foreach ($owners as $owner) {
            Mail::to($owner->email)->send(new DataToOwners());
        }
    }
}
