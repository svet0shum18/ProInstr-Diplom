@extends('layouts.main')

@section('title', 'Личный кабинет')

@section('content')
    <div class="body_container">
         <!-- Хлебные крошки -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <!-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Профиль</a></li> -->
            @if(isset($breadcrumb))
                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb }}</li>
            @endif
        </ol>
    </nav>
        <h2 class="zag-section mt-4">Настройки профиля</h2>

        <div class="row">
            <!-- Левое меню -->
            <div class="col-md-3 mb-4">
                <div class="card profile-card">
                    <div class="card-body">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('order.orderuser') }}">Заказы</a>
                                <a class="nav-link" href="{{ route('favorite.index') }}">Избранное</a>
                                <a class="nav-link" href="#">Мои отзывы</a>
                                <a class="nav-link" href="#">Персональные данные</a>
                                <a class="nav-link" href="#">Достижения</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Основное содержимое -->
            <div class="col-md-9">
                <div class="card profile-card">
                    <div class="card-body">
                        <div class="profile-info">
                            <h3>{{ Auth::user()->name }}</h3>
                            <p class="text-muted">Дата регистрации: {{ Auth::user()->created_at->format('d.m.Y') }}</p>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Имя</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name }}" id="name-input"
                                    placeholder="Введите ваше имя">
                                <div id="name-status" class="mt-2 small"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Электронная почта</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->email }}">
                                    <div id="name-status" class="mt-2 small"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">

                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <!-- Кнопка удаления профиля с модальным окном -->
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteProfileModal">
                                Удалить профиль
                            </button>

                            <!-- Форма выхода -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-secondary">Выйти</button>
                            </form>
                        </div>

                        <div class="modal fade" id="deleteProfileModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">Удаление профиля</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="fw-bold">Вы уверены, что хотите удалить свой профиль?</p>
                                        <p class="text-muted">Все ваши данные будут безвозвратно удалены.</p>

                                        <form id="deleteProfileForm" method="POST" action="{{ route('profile.destroy') }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="mb-3">
                                                <label for="confirmPassword" class="form-label">Подтвердите пароль:</label>
                                                <input type="password" class="form-control" id="confirmPassword"
                                                    name="password" required>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Отмена</button>
                                        <button type="submit" class="btn btn-danger"
                                            form="deleteProfileForm">Удалить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('name-input').addEventListener('change', function () {
            const newName = this.value;
            const statusElement = document.getElementById('name-status');

            // Показываем статус "Сохранение..."
            statusElement.textContent = 'Сохранение...';
            statusElement.className = 'mt-2 small text-info';

            fetch('{{ route("dashboard.update.name") }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name: newName })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        statusElement.textContent = 'Успешно сохранено!';
                        statusElement.className = 'mt-2 small text-success';

                        // Через 3 секунды убираем сообщение
                        setTimeout(() => {
                            statusElement.textContent = '';
                        }, 3000);

                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        statusElement.textContent = data.message || 'Ошибка сохранения';
                        statusElement.className = 'mt-2 small text-danger';
                    }
                })
                .catch(error => {
                    statusElement.textContent = 'Ошибка сети';
                    statusElement.className = 'mt-2 small text-danger';
                });
        });


        document.addEventListener('DOMContentLoaded', function () {
            // Инициализация модального окна
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteProfileModal'));

            // Гарантированное удаление backdrop при скрытии
            deleteModal._element.addEventListener('hidden.bs.modal', function () {
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
            });

            // Обработчик ошибок при отправке формы
            document.getElementById('deleteProfileForm').addEventListener('submit', function (e) {
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        password: this.password.value,
                        _method: 'DELETE'
                    })
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Ошибка удаления');
                        deleteModal.hide();
                        window.location.href = '/'; // Перенаправление после удаления
                    })
                    .catch(error => {
                        alert(error.message);
                    });

                e.preventDefault();
            });
        });
    </script>
@endsection