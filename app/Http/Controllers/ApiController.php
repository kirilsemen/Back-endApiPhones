<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Requests\PhonesRequest;
use App\Http\Requests\UpdatePhonesRequest;
use App\Models\Orders;
use App\Models\Phones;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getPhones(): array
    {
        return [
            'status' => '200',
            'message' => 'OK.',
            'phones' => Phones::paginate(20),
        ];
    }

    public function createPhone(PhonesRequest $phonesRequest): array
    {
        /** @var array $data */
        $data = $phonesRequest->validated();

        Phones::query()->create($data);

        return [
            'status' => '201',
            'message' => 'Phone was created successfully.'
        ];
    }

    public function updatePhones(int $id, UpdatePhonesRequest $phonesRequest): array
    {
        /** @var Phones $phone */
        $phone = Phones::find($id);

        if (!$phone) {
            return [
                'status' => '404',
                'message' => 'Phone not found.'
            ];
        }

        /** @var array $data */
        $data = $phonesRequest->validated();
        $phone->update($data);

        return [
            'status' => '200',
            'message' => 'Phone data was updated.'
        ];
    }

    public function deletePhone(int $id): array
    {
        /** @var Phones $phone */
        $phone = Phones::find($id);

        if ($phone) {
            $phone->delete();

            return [
                'status' => '200',
                'message' => 'Phone was deleted.'
            ];
        }

        return [
            'status' => '404',
            'message' => 'Phone not found.'
        ];
    }

    public function restorePhone(int $id): array
    {
        /** @var Phones $phone */
        $phone = Phones::onlyTrashed()->find($id);

        if ($phone) {
            $phone->restore();

            return [
                'status' => '200',
                'message' => 'Phone was restored.'
            ];
        }

        return [
            'status' => '404',
            'message' => 'Phone not found.'
        ];
    }

    public function createOrder(OrderRequest $orderRequest): array
    {
        /** @var Phones $phone */
        $phone = Phones::find($orderRequest->phone_id);

        if ($orderRequest->amount > $phone->quantity){
            return [
                'status' => '400',
                'message' => 'Total amount can not be greater thant stock amount.'
            ];
        }

        /** @var Orders $order */
        $order = $phone->ordersRelations()->create([
            'user_id' => $orderRequest->user_id,
            'status' => 'pending',
            'amount' => $orderRequest->amount,
            'total_price' => $orderRequest->total_price
        ]);

        if (!$order) {
            return [
                'status' => '400',
                'message' => 'Bad Request.',
            ];
        }

        return [
            'status' => '201',
            'message' => 'Order created.'
        ];
    }

    public function getOrders(Request $request): array
    {
        /** @var User $user */
        $user = $request->user();
        /** @var Orders $orders */
        $orders = $user->ordersRelations()->paginate(20);

        if (!$orders) {
            return [
                'status' => '404',
                'message' => 'Orders not found.'
            ];
        }

        return [
            'status' => '200',
            'message' => 'OK.',
            'orders' => $orders
        ];
    }

    public function getOrder(int $id, Request $request): array
    {
        /** @var User $user */
        $user = $request->user();
        /** @var Orders $order */
        $order = $user->ordersRelations()->withTrashed()->find($id);

        if (!$order) {
            return [
                'status' => '400',
                'message' => 'Something went wrong'
            ];
        }

        return [
            'status' => '200',
            'message' => 'OK.',
            'order' => $order
        ];
    }

    public function fulfillOrder(int $id): array
    {
        /** @var Orders $order */
        $order = Orders::find($id);

        if (!$order) {
            return [
                'status' => '404',
                'message' => 'Order not found.'
            ];
        }

        $order->update([
           'status' => 'complete'
        ]);

        return [
            'status' => '200',
            'message' => 'Order is fulfilled.'
        ];
    }

    public function cancelOrder(int $id): array
    {
        /** @var Orders $order */
        $order = Orders::find($id);

        if (!$order) {
            return [
                'status' => '404',
                'message' => 'Order not found.'
            ];
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        return [
            'status' => '200',
            'message' => 'Order is canceled.'
        ];
    }
}
