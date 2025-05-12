<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\Delivery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\DeliveryAddress;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('OrderController store started', [
            'request_data' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        try {
            // Основная валидация
            $validated = $request->validate([
                'delivery_type' => 'required|in:pickup,delivery',
                'selected_date' => 'required|date',
            ]);

            // Получаем данные корзины
            $cartItems = Cart::with('product')
                ->where('user_id', auth()->id())
                ->get();

            if ($cartItems->isEmpty()) {
                return response()->json(['error' => 'Корзина пуста'], 400);
            }

            // Создаем заказ
            $order = Order::create([
                'user_id' => auth()->id(),
                'type' => $validated['delivery_type'],
                'total' => $cartItems->sum(function ($item) {
                    return $item->quantity * $item->product->price;
                }),
                'status' => 'new',
                'delivery_date' => $validated['selected_date'],
            ]);

            // Если это доставка - сохраняем данные
            if ($validated['delivery_type'] === 'delivery') {
                $deliveryData = $request->validate([
                    'city' => 'required|string|max:255',
                    'street' => 'required|string|max:255',
                    'house' => 'required|string|max:20',
                    'apartment' => 'nullable|string|max:20',
                    'full_name' => 'required|string|max:255',
                    'phone' => 'required|string|max:20',
                    'delivery_date' => 'required|date',
                    'time_interval' => 'required|string|in:9-12,12-15,15-18,18-21',
                    'comment' => 'nullable|string|max:500',
                    'save_address' => 'sometimes|boolean'
                ]);

                // Добавляем user_id к данным доставки
                $deliveryData['user_id'] = auth()->id();

                // Создаем доставку для заказа
                Delivery::create([
                    'order_id' => $order->id,
                    'user_id' => auth()->id(),
                    'city' => $deliveryData['city'],
                    'street' => $deliveryData['street'],
                    'house' => $deliveryData['house'],
                    'apartment' => $deliveryData['apartment'] ?? null,
                    'full_name' => $deliveryData['full_name'],
                    'phone' => $deliveryData['phone'],
                    'delivery_date' => $deliveryData['delivery_date'],
                    'time_interval' => $deliveryData['time_interval'],
                    'comment' => $deliveryData['comment'] ?? null
                ]);

                // Если нужно сохранить адрес для будущих заказов
                if ($deliveryData['save_address'] ?? false) {
                    $this->saveDeliveryAddressForUser($deliveryData);
                }
            }

            // Добавляем товары
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            // Очищаем корзину
            Cart::where('user_id', auth()->id())->delete();

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'redirect_url' => route('order.success', $order->id)
            ]);

        } catch (ValidationException $e) {
            \Log::error('Validation error in OrderController: ' . $e->getMessage());
            return response()->json([
                'errors' => $e->errors(),
                'message' => 'Ошибка валидации данных'
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Error in OrderController: ' . $e->getMessage());
            return response()->json([
                'error' => 'Произошла ошибка при оформлении заказа',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Сохранение адреса для пользователя (без привязки к заказу)
    protected function saveDeliveryAddressForUser(array $data)
    {
        // Создаем или обновляем сохраненный адрес
        return DeliveryAddress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'city' => $data['city'],
                'street' => $data['street']
            ],
            [
                'house' => $data['house'],
                'apartment' => $data['apartment'] ?? null,
                'full_name' => $data['full_name'],
                'phone' => $data['phone']
            ]
        );
    }

    public function getLast()
    {
        $address = DeliveryAddress::where('user_id', auth()->id())
            ->latest()
            ->first();

        return $address ? response()->json([
            'city' => $address->city,
            'street' => $address->street,
            'house' => $address->house,
            'apartment' => $address->apartment,
            'full_name' => $address->full_name,
            'phone' => $address->phone
        ]) : response()->json([]);
    }

    public function success(Order $order)
{
    // Проверяем, что заказ принадлежит текущему пользователю
    if ($order->user_id !== auth()->id()) {
        abort(403, 'У вас нет доступа к этому заказу');
    }

    return view('order.success', [
        'order' => $order,
        'items' => $order->items()->with('product')->get()
    ]);
}

// Просмотр текущих заказов в профиле
public function index(Request $request)
{
    $orders = auth()->user()->orders()
                ->when($request->status, fn($q, $status) => $q->where('status', $status))
                ->when($request->period, function($q, $period) {
                    $date = now();
                    match ($period) {
                        'month' => $date->subMonth(),
                        '3months' => $date->subMonths(3),
                        'year' => $date->subYear(),
                        default => null,
                    };
                    return $q->where('created_at', '>=', $date);
                })
                ->with(['items.product'])
                ->withCount('items')
                ->latest()
                ->paginate(10)
                ->appends($request->query());
    
    // Для AJAX-запросов возвращаем только часть шаблона
    if ($request->ajax()) {
        return view('order.partials.orders_list', compact('orders'));
    }

    $statuses = [
        'new' => 'Новый',
        'processing' => 'В обработке', 
        'completed' => 'Завершен',
        'cancelled' => 'Отменен'
    ];
    
    $orders->each(function($order) use ($statuses) {
        $order->status_text = $statuses[$order->status] ?? $order->status;
    });
    
    return view('order.orderuser', compact('orders'));
}

public function show(Order $order)
{

    // Проверка, что заказ принадлежит пользователю 
    if ($order->user_id != auth()->id()) {
        abort(403);
    }
    
    // Добавляем преобразование статуса
    $statuses = [
        'new' => 'Новый',
        'processing' => 'В обработке',
        'completed' => 'Завершен',
        'cancelled' => 'Отменен'
    ];
    
    $order->status_text = $statuses[$order->status] ?? $order->status;
    
    return view('order.show', [
        'order' => $order->load(['items.product', 'user']),
        'items' => $order->items()->with('product')->get()
    ]);


}

// Удаление заказа
public function cancel(Order $order)
{
    if ($order->user_id != auth()->id()) {
        return response()->json(['error' => 'Доступ запрещен'], 403);
    }

    if ($order->status != 'new') {
        return response()->json(['error' => 'Нельзя отменить заказ в текущем статусе'], 400);
    }

    foreach ($order->items as $item) {
        $product = $item->product;
        if ($product) {
            $product->quantity += $item->quantity;
            $product->save();
        }
    }

     // Обновляем статус заказа
    $order->status = 'cancelled';
    $order->save();

    return response()->json([
        'success' => true,
        'status_text' => 'Отменен'
       
    ]);
}


}