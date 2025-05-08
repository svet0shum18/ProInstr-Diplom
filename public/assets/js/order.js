// Тип доставки
function selectDate(element) {
    // Убираем выделение у всех кнопок
    document.querySelectorAll(".btn-date").forEach((btn) => {
        btn.classList.remove("btn-primary");
        btn.classList.add("btn-outline-primary");
    });

    // Добавляем выделение выбранной
    element.classList.remove("btn-outline-primary");
    element.classList.add("btn-primary");

    // Обновляем скрытое поле формы
    document.getElementById("selectedDate").value = element.dataset.date;
}


document.addEventListener('DOMContentLoaded', function() {
    // Элементы DOM
    const courierDeliveryOption = document.getElementById('courierDeliveryOption');
    const pickupOption = document.getElementById('pickupOption');
    const courierModal = new bootstrap.Modal(document.getElementById('courierModal'));
    const deliveryForm = document.getElementById('deliveryForm');
    const confirmDeliveryBtn = document.getElementById('confirmDeliveryBtn');
    const orderForm = document.getElementById('orderForm');
    const saveAddressCheckbox = document.getElementById('saveAddress');
    const deliveryTypeInput = document.getElementById('deliveryType');
    const saveAddressHidden = document.getElementById('saveAddressHidden');
    
    // Инициализация даты доставки (минимум завтра)
    const deliveryDateInput = document.getElementById('delivery_date');
    if (deliveryDateInput) {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        deliveryDateInput.min = tomorrow.toISOString().split('T')[0];
        deliveryDateInput.value = tomorrow.toISOString().split('T')[0];
    }

    // Обработчик клика по опции доставки курьером
    courierDeliveryOption.addEventListener('click', function() {
        courierModal.show();
        deliveryTypeInput.value = 'delivery';
        updateDeliveryOptionStyles('delivery');
        loadSavedAddress();
    });

    // Обработчик клика по опции самовывоза
    pickupOption.addEventListener('click', function() {
        deliveryTypeInput.value = 'pickup';
        updateDeliveryOptionStyles('pickup');
        updateDeliverySummary();
    });

    // Обновление стилей выбранного способа доставки
    function updateDeliveryOptionStyles(option) {
        if (option === 'delivery') {
            courierDeliveryOption.classList.add('selected-delivery-option');
            courierDeliveryOption.classList.remove('card-cart-cur');
            pickupOption.classList.remove('selected-delivery-option');
            pickupOption.classList.add('card-cart-cur');
        } else {
            pickupOption.classList.add('selected-delivery-option');
            pickupOption.classList.remove('card-cart-cur');
            courierDeliveryOption.classList.remove('selected-delivery-option');
            courierDeliveryOption.classList.add('card-cart-cur');
        }
    }

    // Загрузка сохраненного адреса
    async function loadSavedAddress() {
        try {
            const response = await fetch('/get-saved-delivery-data', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            if (response.ok) {
                const address = await response.json();
                if (address && address.city) {
                    fillDeliveryForm(address);
                }
            }
        } catch (error) {
            console.error('Ошибка при загрузке адреса:', error);
        }
    }

    // Заполнение формы данными адреса
    function fillDeliveryForm(address) {
        document.getElementById('city').value = address.city || '';
        document.getElementById('street').value = address.street || '';
        document.getElementById('house').value = address.house || '';
        document.getElementById('apartment').value = address.apartment || '';
        document.getElementById('full_name').value = address.full_name || '';
        document.getElementById('phone').value = address.phone || '';
    }

    // Обработчик подтверждения данных доставки
    confirmDeliveryBtn.addEventListener('click', function() {
        if (validateDeliveryForm()) {
            // Обновляем скрытые поля в основной форме
            updateOrderFormDeliveryData();
            
            // Обновляем блок с информацией о доставке
            updateDeliverySummary();
            
            // Закрываем модальное окно
            courierModal.hide();
        }
    });

    // Валидация формы доставки
    function validateDeliveryForm() {
        let isValid = true;
        const requiredFields = ['city', 'street', 'house', 'full_name', 'phone', 'delivery_date'];
        
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // Дополнительная валидация телефона
        const phone = document.getElementById('phone').value;
        if (!/^[\d\+\(\)\s-]{10,15}$/.test(phone)) {
            document.getElementById('phone').classList.add('is-invalid');
            isValid = false;
        }

        return isValid;
    }

    // Обновление данных доставки в основной форме
    function updateOrderFormDeliveryData() {
        document.getElementById('deliveryCity').value = document.getElementById('city').value;
        document.getElementById('deliveryStreet').value = document.getElementById('street').value;
        document.getElementById('deliveryHouse').value = document.getElementById('house').value;
        document.getElementById('deliveryApartment').value = document.getElementById('apartment').value;
        document.getElementById('deliveryFullName').value = document.getElementById('full_name').value;
        document.getElementById('deliveryPhone').value = document.getElementById('phone').value;
        document.getElementById('deliveryDateField').value = document.getElementById('delivery_date').value;
        document.getElementById('deliveryTimeInterval').value = document.getElementById('time_interval').value;
        document.getElementById('deliveryComment').value = document.getElementById('comment').value;
        document.getElementById('saveAddressHidden').value = saveAddressCheckbox.checked ? 1 : 0;
    }

    // Обновление блока с информацией о доставке
    function updateDeliverySummary() {
        const deliverySummary = document.getElementById('deliverySummary');
        
        if (deliveryTypeInput.value === 'pickup') {
            deliverySummary.innerHTML = `
                <p class="card-text fs-6">Самовывоз из магазина</p>
                <p class="card-text fs-6">г. Владивосток, п. Трудовое, ул.Лермнотова 70, стр 5</p>
            `;
        } else {
            const timeIntervals = {
                '9-12': '9:00 – 12:00',
                '12-15': '12:00 – 15:00',
                '15-18': '15:00 – 18:00',
                '18-21': '18:00 – 21:00'
            };
            
            const city = document.getElementById('city').value;
            const street = document.getElementById('street').value;
            const house = document.getElementById('house').value;
            const apartment = document.getElementById('apartment').value;
            const fullName = document.getElementById('full_name').value;
            const phone = document.getElementById('phone').value;
            const deliveryDate = document.getElementById('delivery_date').value;
            const timeInterval = document.getElementById('time_interval').value;
            
            deliverySummary.innerHTML = `
                <p class="card-text fs-6">Доставка курьером</p>
                <p class="card-text fs-6">${city}, ${street}, ${house}${apartment ? ', кв. ' + apartment : ''}</p>
                <p class="card-text fs-6">${formatDate(deliveryDate)}, ${timeIntervals[timeInterval]}</p>
                <p class="card-text fs-6">Получатель: ${fullName}, ${phone}</p>
            `;
        }
    }

    // Вспомогательная функция для форматирования даты
    function formatDate(dateString) {
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        return new Date(dateString).toLocaleDateString('ru-RU', options);
    }

    // Обработчик отправки формы заказа
    orderForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Для доставки курьером проверяем, что данные заполнены
        if (deliveryTypeInput.value === 'delivery' && 
            !document.getElementById('deliveryCity').value) {
            alert('Пожалуйста, заполните данные доставки');
            return;
        }
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: new FormData(this)
            });
            
            const result = await response.json();
            
            if (result.redirect_url) {
                window.location.href = result.redirect_url;
            } else if (response.ok) {
                window.location.href = '/order/success';
            } else {
                throw new Error(result.error || 'Ошибка при оформлении заказа');
            }
        } catch (error) {
            console.error('Ошибка:', error);
            alert(error.message);
        }
    });

    // Обработчик изменения чекбокса сохранения адреса
    if (saveAddressCheckbox) {
        saveAddressCheckbox.addEventListener('change', function() {
            document.getElementById('saveAddressHidden').value = this.checked ? 1 : 0;
        });
    }
});
