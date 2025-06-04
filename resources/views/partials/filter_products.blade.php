<div class="product-filters mt-4">
    <div class="card profile-card">
       <div style="padding: 30px 30px;">
        <form action="{{ route('products.chainsaw') }}" method="GET" id="chainsawFilterForm">
            <!-- Фильтр по цене (оставляем как есть) -->
            <div class="filter-group">
                <h6 class="filter-title">Цена, ₽</h6>
                <div class="row">
                    <div class="col-md-6 ">
                        <input type="number" 
                               class="form-control" 
                               name="price_min" 
                               placeholder="От" 
                               value="{{ request('price_min') }}">
                    </div>
                    <div class="col-md-6">
                        <input type="number" 
                               class="form-control" 
                               name="price_max" 
                               placeholder="До" 
                               value="{{ request('price_max') }}">
                    </div>
                </div>
                <div class="price-slider mt-2">
                    <div id="price-range" class="slider"></div>
                </div>
            </div>

            <!-- Фильтр по производителю (radiobutton) -->
            <div class="filter-group mb-4">
                <h6 class="filter-title">Производитель</h6>
                
                <div class="form-check mb-2">
                    <input class="form-check-input" 
                           type="radio" 
                           name="brand" 
                           id="brand-all" 
                           value=""
                           {{ !request('brand') ? 'checked' : '' }}>
                    <label class="form-check-label" for="brand-all">
                        Все производители
                    </label>
                </div>
                
              @foreach($brands as $brand)
                <div class="form-check mb-2">
                    <input class="form-check-input brand-filter" 
                        type="radio" 
                        name="brand" 
                         id="brand-{{ $brand->id }}" 
                         value="{{ $brand->name }}"
                        {{ request('brand') == $brand ? 'checked' : '' }}>
                    <label class="form-check-label" for="brand-{{ $loop->index }}">
                        {{ $brand->name }}
                    </label>
                </div>
                @endforeach
            </div>

            <!-- Фильтр по мощности (radiobutton) -->
            <div class="filter-group mb-4">
                <h6 class="filter-title">Мощность, кВт</h6>
                
                <div class="form-check mb-2">
                    <input class="form-check-input" 
                           type="radio" 
                           name="power" 
                           id="power-all" 
                           value=""
                           {{ !request('power') ? 'checked' : '' }}>
                    <label class="form-check-label" for="power-all">
                        Любая мощность
                    </label>
                </div>
                
                <div class="form-check mb-2">
                    <input class="form-check-input" 
                           type="radio" 
                           name="power" 
                           id="power-1.5" 
                           value="1.5"
                           {{ request('power') == '1.5' ? 'checked' : '' }}>
                    <label class="form-check-label" for="power-1.5">
                        До 1.5 кВт
                    </label>
                </div>
                
                <div class="form-check mb-2">
                    <input class="form-check-input" 
                           type="radio" 
                           name="power" 
                           id="power-2.5" 
                           value="2.5"
                           {{ request('power') == '2.5' ? 'checked' : '' }}>
                    <label class="form-check-label" for="power-2.5">
                        1.5-2.5 кВт
                    </label>
                </div>
                
                <div class="form-check mb-2">
                    <input class="form-check-input" 
                           type="radio" 
                           name="power" 
                           id="power-3.5" 
                           value="3.5"
                           {{ request('power') == '3.5' ? 'checked' : '' }}>
                    <label class="form-check-label" for="power-3.5">
                        2.5-3.5 кВт
                    </label>
                </div>
                
                <div class="form-check mb-2">
                    <input class="form-check-input" 
                           type="radio" 
                           name="power" 
                           id="power-5" 
                           value="5"
                           {{ request('power') == '5' ? 'checked' : '' }}>
                    <label class="form-check-label" for="power-5">
                        Более 3.5 кВт
                    </label>
                </div>
            </div>

            <!-- Фильтр по весу (radiobutton) -->
            <div class="filter-group mb-4">
                <h6 class="filter-title">Вес, кг</h6>
                
                <div class="form-check mb-2">
                    <input class="form-check-input" 
                           type="radio" 
                           name="weight" 
                           id="weight-all" 
                           value=""
                           {{ !request('weight') ? 'checked' : '' }}>
                    <label class="form-check-label" for="weight-all">
                        Любой вес
                    </label>
                </div>
                
                <div class="form-check mb-2">
                    <input class="form-check-input" 
                           type="radio" 
                           name="weight" 
                           id="weight-4" 
                           value="4"
                           {{ request('weight') == '4' ? 'checked' : '' }}>
                    <label class="form-check-label" for="weight-4">
                        До 4 кг
                    </label>
                </div>
                
                <div class="form-check mb-2">
                    <input class="form-check-input" 
                           type="radio" 
                           name="weight" 
                           id="weight-5" 
                           value="5"
                           {{ request('weight') == '5' ? 'checked' : '' }}>
                    <label class="form-check-label" for="weight-5">
                        4-5 кг
                    </label>
                </div>
                
                <div class="form-check mb-2">
                    <input class="form-check-input" 
                           type="radio" 
                           name="weight" 
                           id="weight-6" 
                           value="6"
                           {{ request('weight') == '6' ? 'checked' : '' }}>
                    <label class="form-check-label" for="weight-6">
                        5-6 кг
                    </label>
                </div>
                
                <div class="form-check mb-2">
                    <input class="form-check-input" 
                           type="radio" 
                           name="weight" 
                           id="weight-7" 
                           value="7"
                           {{ request('weight') == '7' ? 'checked' : '' }}>
                    <label class="form-check-label" for="weight-7">
                        Более 6 кг
                    </label>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn-go">Применить</button>
                <a href="{{ route('products.chainsaw') }}" class="btn btn-outline-secondary rounded-pill">Сбросить</a>
            </div>
        </form>
    </div>
</div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Элементы DOM
    const filterForm = document.getElementById('chainsawFilterForm');
    const productsContainer = document.querySelector('.col-md-9 .row');
    const loadingIndicator = document.getElementById('loadingIndicator');
    
    // Инициализация слайдера цены
    const initPriceSlider = () => {
        const priceRange = document.getElementById('price-range');
        if (priceRange) {
            noUiSlider.create(priceRange, {
                start: [
                    parseInt(document.querySelector('input[name="price_min"]').value || 0),
                    parseInt(document.querySelector('input[name="price_max"]').value || 100000)
                ],
                connect: true,
                range: {
                    'min': 0,
                    'max': 100000
                }
            });

            priceRange.noUiSlider.on('update', function(values, handle) {
                const value = Math.round(values[handle]);
                if (handle) {
                    document.querySelector('input[name="price_max"]').value = value;
                } else {
                    document.querySelector('input[name="price_min"]').value = value;
                }
                // Триггерим событие изменения для немедленной фильтрации
                const event = new Event('change');
                document.querySelector('input[name="price_min"]').dispatchEvent(event);
                document.querySelector('input[name="price_max"]').dispatchEvent(event);
            });
        }
    };

    // Загрузка товаров через AJAX
    const loadProducts = async (url = null) => {
        try {
            if (loadingIndicator) loadingIndicator.style.display = 'block';
            
            const targetUrl = url || filterForm.action;
            const formData = new FormData(filterForm);
            
            // Для радио-кнопок брендов добавляем только выбранное значение
            const selectedBrand = document.querySelector('input[name="brand"]:checked');
            if (selectedBrand) {
                formData.set('brand', selectedBrand.value);
            } else {
                formData.delete('brand');
            }
            
            const params = new URLSearchParams(formData);
            
            const response = await fetch(`${targetUrl}?${params}`);
            
            if (!response.ok) throw new Error('Network response was not ok');
            
            const html = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Обновляем контейнер с товарами
            if (productsContainer) {
                const newProducts = doc.querySelector('.col-md-9 .row');
                if (newProducts) {
                    productsContainer.innerHTML = newProducts.innerHTML;
                }
            }
            
            // Обновляем пагинацию
            const newPagination = doc.querySelector('.pagination');
            if (newPagination) {
                document.querySelector('.pagination').innerHTML = newPagination.innerHTML;
            }
            
            // Обновляем счетчик товаров
            const newCount = doc.querySelector('#productsCount');
            if (newCount) {
                document.querySelector('#productsCount').innerHTML = newCount.innerHTML;
            }
            
            // Обновляем URL без перезагрузки страницы
            history.pushState({}, '', `${targetUrl}?${params}`);
            
        } catch (error) {
            console.error('Ошибка при загрузке товаров:', error);
            if (productsContainer) {
                productsContainer.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-danger">Произошла ошибка при загрузке товаров. Пожалуйста, попробуйте позже.</div>
                    </div>
                `;
            }
        } finally {
            if (loadingIndicator) loadingIndicator.style.display = 'none';
        }
    };
    
    // Обработка изменения фильтров
    const handleFilterChange = (event) => {
        // Для радио-кнопок брендов применяем фильтры сразу
        if (event.target.matches('input[name="brand"]')) {
            loadProducts();
        }
        // Для полей ввода - после небольшой задержки
        else if (event.target.matches('input[type="number"], input[type="text"], select')) {
            clearTimeout(window.filterTimeout);
            window.filterTimeout = setTimeout(() => {
                loadProducts();
            }, 500);
        }
    };
    
    // Обработка пагинации
    const handlePaginationClick = async (event) => {
        if (event.target.closest('.pagination a')) {
            event.preventDefault();
            await loadProducts(event.target.closest('a').href);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    };
    
    // Сброс фильтров
    const handleResetFilters = (event) => {
        if (event.target.classList.contains('btn-reset')) {
            event.preventDefault();
            // Сбрасываем все поля формы
            filterForm.reset();
            // Сбрасываем выбор бренда
            document.querySelectorAll('input[name="brand"]').forEach(radio => {
                radio.checked = false;
            });
            // Сбрасываем слайдер
            if (window.priceSlider) {
                window.priceSlider.set([0, 100000]);
            }
            // Загружаем товары
            loadProducts();
        }
    };
    
    // Инициализация обработчиков событий
    const initEventListeners = () => {
        // Фильтры
        filterForm.addEventListener('change', handleFilterChange);
        filterForm.addEventListener('input', handleFilterChange);
        
        // Пагинация (делегирование событий)
        document.addEventListener('click', handlePaginationClick);
        
        // Кнопка сброса
        document.addEventListener('click', handleResetFilters);
        
        // Обработка кнопки "Назад" в браузере
        window.addEventListener('popstate', () => {
            loadProducts(window.location.href);
        });
    };
    
    // Инициализация при загрузке
    initPriceSlider();
    initEventListeners();
});
</script>
@endsection