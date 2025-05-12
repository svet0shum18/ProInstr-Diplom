document.addEventListener('DOMContentLoaded', function() {
    // Элементы DOM
    const filterForm = document.getElementById('chainsawFilterForm');
    const productsContainer = document.querySelector('.col-md-9 .row');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const paginationLinks = document.querySelectorAll('.pagination a');
    
    // Инициализация слайдера цены
    const initPriceSlider = () => {
        const priceRange = document.getElementById('price-range');
        if (priceRange && typeof noUiSlider !== 'undefined') {
            noUiSlider.create(priceRange, {
                start: [
                    parseInt(priceRange.dataset.min || 0), 
                    parseInt(priceRange.dataset.max || 100000)
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
            });
        }
    };
    
    // Загрузка товаров через AJAX
    const loadProducts = async (url = null) => {
        try {
            if (loadingIndicator) loadingIndicator.style.display = 'block';
            
            const targetUrl = url || filterForm.action;
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);
            
            // Добавляем параметры пагинации, если это переход по страницам
            if (url) {
                const urlObj = new URL(url);
                urlObj.searchParams.forEach((value, key) => {
                    params.append(key, value);
                });
            }
            
            const response = await fetch(`${targetUrl}?${params}`);
            
            if (!response.ok) throw new Error('Network response was not ok');
            
            const html = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Обновляем только контейнер с товарами
            if (productsContainer) {
                productsContainer.innerHTML = doc.querySelector('.col-md-9 .row').innerHTML;
            }
            
            // Обновляем пагинацию
            const newPagination = doc.querySelector('.pagination');
            if (newPagination) {
                document.querySelector('.pagination').innerHTML = newPagination.innerHTML;
            }
            
            // Обновляем счетчик товаров
            const newCount = doc.querySelector('h1 .badge');
            if (newCount) {
                document.querySelector('h1 .badge').textContent = newCount.textContent;
            }
            
            // Обновляем URL без перезагрузки страницы
            history.pushState({}, '', `${targetUrl}?${params}`);
            
            // Инициализируем обработчики для новых элементов
            initEventListeners();
            
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
        // Для радио-кнопок и чекбоксов применяем фильтры сразу
        if (event.target.matches('input[type="radio"], input[type="checkbox"]')) {
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
        event.preventDefault();
        await loadProducts(event.target.href);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
    
    // Сброс фильтров
    const handleResetFilters = (event) => {
        if (event.target.matches('.btn-reset')) {
            event.preventDefault();
            // Сбрасываем все поля формы
            filterForm.reset();
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
        
        // Пагинация
        document.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', handlePaginationClick);
        });
        
        // Кнопка сброса
        document.addEventListener('click', handleResetFilters);
        
        // Обработка кнопки "Назад" в браузере
        window.addEventListener('popstate', () => {
            loadProducts(window.location.href);
        });
    };
  });
