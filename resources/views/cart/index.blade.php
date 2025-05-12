@php
    $itemsCount = count($cartItems);
    $titles = ['товар', 'товара', 'товаров'];
    $cases = [2, 0, 1, 1, 1, 2];
    $index = ($itemsCount % 100 > 4 && $itemsCount % 100 < 20) ? 2 : $cases[min($itemsCount % 10, 5)];
@endphp



@extends('layouts.main')

@section('title', 'Корзина')

@section('content')
    <div class="body_container mt-4">
        <h1 class="mb-4">Корзина {{ $itemsCount }} {{ $titles[$index] }}</h1>

        @if($isEmpty)
            <div class="d-flex justify-content-start w-100 gap-2 h5">
                В корзине пока что пусто! <a href="{{ url('/') }}" class="fw-bold link-success"> Начать покупки</a>
            </div>
        @else

            <div class="row">
                <div class="col-md-8">
                    @foreach($cartItems as $item)
                        <div class="card-cart mb-3" data-product-id="{{ $item->product->id }}"
                            data-product-price="{{ $item->product->price }}">
                            <div class="row g-0">
                                <div class="col-md-2 d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('assets/img/products/' . $item->product->image) }}"
                                        class="img-fluid rounded-start" style="max-width: 120px; max-height: 120px;"
                                        alt="{{ $item->product->name }}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body ms-3">
                                        <h5 class="card-title">{{ $item->product->name }}</h5>
                                        <div class="d-flex align-items-center mt-3">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="me-2">
                                                @csrf
                                                <input type="hidden" name="change" value="-1">
                                                <button class="btn-quantit">−</button>
                                            </form>
                                            <span class="mx-2 fw-bold cart-item-quantity">{{ $item->quantity }}</span>
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="ms-2">
                                                @csrf
                                                <input type="hidden" name="change" value="1">
                                                <button class="btn-quantit">+</button>
                                            </form>
                                        </div>
                                        <p class="small mt-3">В магазинах:
                                            @if($item->quantity > 0)
                                                <span class="text-success fw-bold">в наличии</span>
                                            @else
                                                <span class="text-danger fw-bold">нет в наличии</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-center justify-content-end">
                                    <form action="{{ route('cart.remove', $item->product_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-delete-cart">удалить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Блок выбора способа получения -->
                    <div class="card-cart mb-3">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Где и как вы хотите получить заказ?</h2>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <div class="card-order-opt selected-delivery-option" id="pickupOption">
                                        <div class="card-body-order d-flex">
                                            <div class="d-flex align-items-center me-3">
                                                <i class="fa-solid fa-location-dot fa-2xl" style="color: #3d464d"></i>
                                            </div>
                                            <div class="align-self-center"> <!-- Вертикальное центрирование текста -->
                                                <h5 class="card-title mb-1">Самовывоз</h5>
                                                <p class="card-text mb-0">1 магазин</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-cart-cur" id="courierDeliveryOption">
                                        <div class="card-body">
                                            <div class="card-body-order d-flex">
                                                <div class="d-flex align-items-center me-3">
                                                    <i class="fa-solid fa-truck fa-2xl" style="color: #3d464d;"></i>
                                                </div>
                                                <div class="align-self-center"> <!-- Вертикальное центрирование текста -->
                                                    <h5 class="card-title mb-1">Доставка курьером</h5>
                                                    <p class="card-text mb-0">завтра, от 290 ₽</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Модальное окно с формой доставки -->

                                <div class="modal fade" id="courierModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="card-title">Куда доставить товар?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="deliveryForm">
                                                    @csrf
                                                    <!-- Адрес -->
                                                    <div class="mb-4">
                                                        <h6 class="mb-3 fw-semibold">Адрес доставки</h6>
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label for="city" class="form-label">Город/Населенный
                                                                    пункт</label>
                                                                <input type="text" class="form-control" id="city" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="street" class="form-label">Улица</label>
                                                                <input type="text" class="form-control" id="street" required>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3 mt-2">
                                                            <div class="col-md-3">
                                                                <label for="house" class="form-label">Дом</label>
                                                                <input type="text" class="form-control" id="house" required>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="apartment" class="form-label">Кв/Офис</label>
                                                                <input type="text" class="form-control" id="apartment" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Контактные данные -->
                                                    <div class="mb-4">
                                                        <h6 class="mb-3 fw-semibold">Контактные данные</h6>
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label for="fullName" class="form-label">ФИО</label>
                                                                <input type="text" class="form-control" id="full_name" required
                                                                    placeholder="Иванов Иван Иванович">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="phone" class="form-label">Телефон</label>
                                                                <input type="tel" class="form-control" id="phone" required
                                                                    placeholder="+7(999)999-99-99">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Дата и время -->
                                                    <div class="mb-4">
                                                        <h6 class="mb-3 fw-semibold">Дата и время доставки</h6>
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label for="deliveryDate" class="form-label">Дата
                                                                    доставки</label>
                                                                <input type="date" class="form-control" id="delivery_date"
                                                                    required value="">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="deliveryTime" class="form-label">Временной
                                                                    интервал</label>
                                                                <select class="form-select me-2" id="time_interval" required>
                                                                    <option value="9-12" selected>9:00 – 12:00</option>
                                                                    <option value="12-15">12:00 – 15:00</option>
                                                                    <option value="15-18">15:00 – 18:00</option>
                                                                    <option value="18-21">18:00 – 21:00</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Дополнительно -->
                                                    <div class="mb-4">
                                                        <h6 class="mb-3 fw-semibold">Дополнительная информация</h6>
                                                        <div class="mb-3">
                                                            <label for="comment" class="form-label">Комментарий к
                                                                доставке</label>
                                                            <textarea class="form-control" id="comment" rows="2"
                                                                placeholder="Код домофона, номер подъезда, этаж и т.д."></textarea>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="saveAddress">
                                                            <label class="form-check-label" for="saveAddress">Сохранить этот
                                                                адрес для будущих заказов</label>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn-go w-70" id="confirmDeliveryBtn">Сохранить
                                                    данные</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Выбранный пункт самовывоза -->
                            <div class="card-map mb-3 border">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3 class="card-title mb-3">Выбранный пункт самовывоза</h3>
                                            <p class="card-text">
                                                г. Владивосток, п. Трудовое,<br>
                                                ул.Лермнотова 70, стр 5, 2 этаж,<br>
                                                ТЦ Лермонтов<br>
                                                <span class="text-success mt-3">Забирайте сегодня</span>
                                            </p>
                                            <p class="card-text">
                                                <strong>ПН - ПТ:</strong> с 9:00 до 20:00
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1134.8383541431979!2d132.06098994160817!3d43.297639095441994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5fb3bca1ca8b5f6d%3A0x3fd2b441cff944af!2z0YPQuy4g0JvQtdGA0LzQvtC90YLQvtCy0LAsIDcw0LAsINCi0YDRg9C00L7QstC-0LUsINCf0YDQuNC80L7RgNGB0LrQuNC5INC60YDQsNC5LCDQoNC-0YHRgdC40Y8sIDY5MDkxMg!5e0!3m2!1sru!2sus!4v1737705762439!5m2!1sru!2sus"
                                                width="100%" height="220" style="border-radius: 8px;" allowfullscreen=""
                                                loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                            </iframe>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!-- Дата получения -->
                            <div class="date-picker mb-4">
                                <div class="date-grid">

                                    @php
                                        $today = now();
                                        $dates = [];
                                        for ($i = 0; $i < 4; $i++) {
                                            $date = $today->copy()->addDays($i);
                                            $dates[] = [
                                                'date' => $date,
                                                'formatted' => $date->format('d.m.Y'),
                                                'iso' => $date->format('Y-m-d')
                                            ];
                                        }
                                    @endphp

                                    @foreach ($dates as $day)
                                        <button type="button"
                                            class="btn btn-date {{ $loop->first ? 'btn-primary' : 'btn-outline-primary' }}"
                                            data-date="{{ $day['iso'] }}" onclick="selectDate(this)">
                                            {{ $day['formatted'] }}
                                        </button>
                                    @endforeach
                                </div>
                                <input type="hidden" name="selected_date" id="selectedDate" value="{{ $dates[0]['iso'] }}">
                            </div>

                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="card-cart">
                        <div class="card-body">
                            <div class="card-body-txt d-flex">

                                <h3 class="card-title">Итого:</h3>
                                <p class="card-text fs-4" style="margin-left: 190px;">
                                    <strong>{{ number_format($totalSum, 0, '', ' ') }} ₽</strong>
                                </p>
                            </div>
                            <p class="card-text fs-6">
                                {{ $itemsCount }} {{ $titles[$index] }}
                            </p>
                            <div id="deliverySummary"></div>

                            <form action="{{ route('order.store') }}" method="POST" id="orderForm">
                                @csrf
                                <input type="hidden" name="delivery_type" id="deliveryType" value="pickup">
                                <input type="hidden" name="selected_date" id="selectedDate" value="{{ $dates[0]['iso'] }}">
                                <input type="hidden" name="save_address" id="saveAddressHidden" value="0">
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">


                                <!-- Скрытые поля для данных доставки -->
                                <input type="hidden" name="city" id="deliveryCity">
                                <input type="hidden" name="street" id="deliveryStreet">
                                <input type="hidden" name="house" id="deliveryHouse">
                                <input type="hidden" name="apartment" id="deliveryApartment">
                                <input type="hidden" name="full_name" id="deliveryFullName">
                                <input type="hidden" name="phone" id="deliveryPhone">
                                <input type="hidden" name="delivery_date" id="deliveryDateField">
                                <input type="hidden" name="time_interval" id="deliveryTimeInterval">
                                <input type="hidden" name="comment" id="deliveryComment">
                                <button type="submit" class="btn-go">
                                    Оформить заказ
                                </button>
                            </form>
                        </div>
                    </div>


                    <!-- Дополнительные опции -->
                    <!-- <div class="card-cart mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Шате-M Плюс</h5>
                            <ul class="list-unstyled">
                                <li><a href="#" class="text-decoration-none">Белые игры</a></li>
                                <li><a href="#" class="text-decoration-none">График</a></li>
                                <li><a href="#" class="text-decoration-none">Рисунок</a></li>
                                <li><a href="#" class="text-decoration-none">Уровень</a></li>
                            </ul>

                            <h5 class="card-title mt-3">Выберите</h5>
                            <ul class="list-unstyled">
                                <li><a href="#" class="text-decoration-none">Открыть Яндекс Карты</a></li>
                                <li><a href="#" class="text-decoration-none">ВсеИнструменты.py</a></li>
                                <li><a href="#" class="text-decoration-none">Яндекс Условия использования</a></li>
                                <li><a href="#" class="text-decoration-none">Яндекс Список</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div> -->

@endsection