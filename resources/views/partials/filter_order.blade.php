<div class="card-filter mt-4">
  <h2 class="zag-section">Фильтр заказов</h2>
  <div class="card profile-card">
    <form action="{{ route('order.index') }}" method="GET" id="ordersFilterForm">
      <div style="padding: 20px 30px;">
        <label class="form-label fw-bold d-block mb-2 h5">Статус заказа</label>
        
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="status" id="statusAll" value="" 
                 {{ !request()->has('status') ? 'checked' : '' }}>
          <label class="form-check-label" for="statusAll">
            Все заказы
          </label>
        </div>
        
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="status" id="statusNew" value="new"
                 {{ request('status') == 'new' ? 'checked' : '' }}>
          <label class="form-check-label" for="statusNew">
            Новые
          </label>
        </div>
        
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="status" id="statusProcessing" value="processing"
                 {{ request('status') == 'processing' ? 'checked' : '' }}>
          <label class="form-check-label" for="statusProcessing">
            В обработке
          </label>
        </div>
        
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="status" id="statusCompleted" value="completed"
                 {{ request('status') == 'completed' ? 'checked' : '' }}>
          <label class="form-check-label" for="statusCompleted">
            Завершенные
          </label>
        </div>
        
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="status" id="statusCancelled" value="cancelled"
                 {{ request('status') == 'cancelled' ? 'checked' : '' }}>
          <label class="form-check-label" for="statusCancelled">
            Отмененные
          </label>
        </div>
      </div>

      <div style="padding: 0 30px 20px;">
        <label class="form-label fw-bold d-block mb-2 h5">Период</label>
        
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="period" id="periodAll" value=""
                 {{ !request()->has('period') ? 'checked' : '' }}>
          <label class="form-check-label" for="periodAll">
            За все время
          </label>
        </div>
        
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="period" id="periodMonth" value="month"
                 {{ request('period') == 'month' ? 'checked' : '' }}>
          <label class="form-check-label" for="periodMonth">
            За последний месяц
          </label>
        </div>
        
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="period" id="period3Months" value="3months"
                 {{ request('period') == '3months' ? 'checked' : '' }}>
          <label class="form-check-label" for="period3Months">
            За 3 месяца
          </label>
        </div>
        
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="period" id="periodYear" value="year"
                 {{ request('period') == 'year' ? 'checked' : '' }}>
          <label class="form-check-label" for="periodYear">
            За год
          </label>
        </div>
      </div>

      <div class="d-grid gap-2" style="padding: 0 30px 20px;">
        <button type="submit" class="btn-go">Применить</button>
        @if(request()->has('status') || request()->has('period'))
          <a href="{{ route('order.index') }}" class="btn btn-outline-secondary rounded-pill">Сбросить</a>
        @endif
      </div>
    </form>
  </div>
</div>
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Элементы DOM
    const filterForm = document.getElementById('ordersFilterForm');
    const ordersContainer = document.querySelector('.col-md-9');
    const loadingIndicator = document.getElementById('loadingIndicator');
    
    // Обработка отправки формы
    if (filterForm) {
        filterForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            await loadOrders();
        });
        
        // Обработка изменения radio-кнопок (авто-фильтрация)
        document.querySelectorAll('#ordersFilterForm input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', async function() {
                await loadOrders();
            });
        });
    }
    
    // Загрузка заказов через AJAX
    async function loadOrders() {
        try {
            // Показываем индикатор загрузки
            if (loadingIndicator) loadingIndicator.style.display = 'block';
            
            // Получаем параметры формы
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);
            
            // AJAX-запрос
            const response = await fetch(`{{ route('order.index') }}?${params}`);
            const html = await response.text();
            
            // Обновляем контент
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            ordersContainer.innerHTML = doc.querySelector('.col-md-9').innerHTML;
            
            // Обновляем URL без перезагрузки
            history.pushState({}, '', `{{ route('order.index') }}?${params}`);
            
            // Инициализируем обработчики для пагинации
            initPagination();
        } catch (error) {
            console.error('Ошибка загрузки:', error);
        } finally {
            if (loadingIndicator) loadingIndicator.style.display = 'none';
        }
    }
    
    // Обработка кликов по пагинации
    function initPagination() {
        document.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', async function(e) {
                e.preventDefault();
                try {
                    if (loadingIndicator) loadingIndicator.style.display = 'block';
                    const response = await fetch(this.href);
                    const html = await response.text();
                    ordersContainer.innerHTML = html;
                    initPagination();
                } catch (error) {
                    console.error('Ошибка пагинации:', error);
                } finally {
                    if (loadingIndicator) loadingIndicator.style.display = 'none';
                }
            });
        });
    }
    
    // Инициализация при загрузке
    initPagination();
    
    // Обработка кнопки "Сбросить"
    document.querySelector('.btn-reset-filter')?.addEventListener('click', async function(e) {
        e.preventDefault();
        window.location.href = "{{ route('order.index') }}";
    });
    
    // Обработка кнопки "Назад" в браузере
    window.addEventListener('popstate', function() {
        loadOrders();
    });
});
</script>
@endsection