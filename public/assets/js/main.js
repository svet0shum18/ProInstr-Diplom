
  let currentIndex = 0;
  const slides = document.querySelectorAll('.slide');
  const slidesContainer = document.querySelector('.slides');
  const totalSlides = slides.length;
  let slideInterval = setInterval(nextSlide, 3000); // авто

  function updateSlidePosition() {
    slidesContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides;
    updateSlidePosition();
  }

  function prevSlide() {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    updateSlidePosition();
  }

  // Останавливаем авто-перелистывание при наведении
  document.querySelector('.slider').addEventListener('mouseenter', () => {
    clearInterval(slideInterval);
  });

  // Возобновляем при уходе мыши
  document.querySelector('.slider').addEventListener('mouseleave', () => {
    slideInterval = setInterval(nextSlide, 3000);
  });

  // Инициализация меню
    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = document.querySelector('.dropdown');
        const megaMenu = document.querySelector('.mega-menu');
        
        dropdown.addEventListener('mouseenter', function() {
            this.querySelector('.dropdown-toggle').click();
        });
        
        dropdown.addEventListener('mouseleave', function(e) {
            if (!megaMenu.contains(e.relatedTarget)) {
                this.querySelector('.dropdown-toggle').click();
            }
        });
        
        megaMenu.addEventListener('mouseleave', function(e) {
            if (!dropdown.contains(e.relatedTarget)) {
                dropdown.querySelector('.dropdown-toggle').click();
            }
        });
    });

// МОДАЛЬНОЕ ОКНО
 // Функция для открытия модального окна
function openModal(modalId) {
  var modal = document.getElementById(modalId);
  modal.style.display = "block";
}

// Функция для закрытия модального окна
function closeModal(modalId) {
  var modal = document.getElementById(modalId);
  modal.style.display = "none";
}

// Закрытие модального окна при клике вне его
window.onclick = function(event) {
  if (event.target.classList.contains('modal')) {
    closeModal(event.target.id);
  }
}


const slider = document.getElementById('brandSlider');
  const scrollLeftBtn = document.getElementById('scrollLeft');
  const scrollRightBtn = document.getElementById('scrollRight');
  const scrollStep = 160; // ширина одного бренда + отступы

  scrollLeftBtn.addEventListener('click', () => {
    slider.scrollBy({ left: -scrollStep, behavior: 'smooth' });
  });

  scrollRightBtn.addEventListener('click', () => {
    slider.scrollBy({ left: scrollStep, behavior: 'smooth' });
  });

  // Отображение пароля
  function togglePassword(inputId, toggleIcon) {
    const input = document.getElementById(inputId);
    const icon = toggleIcon.querySelector('i');

    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }



  // КОРЗИНА
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();

        const productId = this.dataset.id;

        // Прямо создаём URL вручную
        const url = `/cart/add/${productId}`;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => {
            if (!response.ok) throw new Error("HTTP error " + response.status);
            return response.json();
        })
        .then(data => {
            alert(data.message);
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при добавлении товара в корзину.');
        });
    });
});



function changeQuantity(itemId, changeValue) {
  fetch(`/cart/update/${itemId}`, {
      method: 'POST',
      headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Content-Type': 'application/json'
      },
      body: JSON.stringify({ change: changeValue })
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          // Обновляем количество товара в корзине
          document.getElementById(`quantity-${itemId}`).textContent = data.new_quantity;
          // Обновляем итоговую сумму
          document.getElementById(`total-${itemId}`).textContent = data.new_total + ' ₽';
          // Обновляем итоговую сумму всех товаров
          document.getElementById('total-sum').textContent = data.total_sum + ' ₽';
      } else {
          console.error('Ошибка:', data.message || 'Не удалось обновить количество');
          alert('Ошибка при изменении количества товара');
      }
  })
  .catch(error => {
      console.error('Ошибка:', error);
      alert('Что-то пошло не так!');
  });
}


$(document).ready(function() {
  // Обработчик удаления товара из корзины
  $('.delete-form').on('submit', function(e) {
      e.preventDefault();
      var form = $(this);
      var itemId = form.closest('tr').attr('id').split('-')[2]; // Получаем ID товара из строки таблицы

      $.ajax({
          url: form.attr('action'),
          method: 'POST',
          data: form.serialize(), // Отправляем данные формы (CSRF токен и метод DELETE)
          success: function(response) {
              if (response.success) {
                  // Удаляем товар из таблицы
                  $('#cart-item-' + itemId).remove();

                  // Обновляем общую сумму корзины
                  $('#total-sum').text(response.total_sum + ' ₽');
              } else {
                  alert('Ошибка при удалении товара');
              }
          },
          error: function() {
              alert('Произошла ошибка');
          }
      });
  });
});


// ИЗБРАННОЕ
// document.querySelectorAll('.add-to-fav').forEach(button => {
//   button.addEventListener('click', function (e) {
//       e.preventDefault();
      
//       const productId = this.getAttribute('data-id');
//       console.log('Clicked button, product ID:', productId); // Проверка ID
      
//       if (!productId) {
//           console.error('ID товара не найден');
//           alert('Ошибка: ID товара не найден.');
//           return;
//       }

//       // Пример запроса:
//       fetch(`/favorite/${productId}`, {
//           method: 'POST',
//           headers: {
//               'Content-Type': 'application/json',
//               'X-CSRF-TOKEN': csrfToken
//           },
//           body: JSON.stringify({})
//       })
//       .then(response => response.json())
//       .then(data => {
//           alert(data.message);  // Показываем сообщение
//       })
//       .catch(error => {
//           console.error('Ошибка:', error);
//           alert('Ошибка при добавлении в избранное.');
//       });
//   });
// });


// НОВОСТИ

document.addEventListener('DOMContentLoaded', function() {
    const categoryLinks = document.querySelectorAll('.news-links a');
    const allNewsItems = document.querySelectorAll('.news-item');

    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Удаляем активный класс у всех ссылок
            categoryLinks.forEach(el => el.classList.remove('active'));
            // Добавляем активный класс текущей ссылке
            this.classList.add('active');
            
            const categoryId = this.dataset.category;
            
            // Фильтрация новостей
            allNewsItems.forEach(item => {
                if (categoryId === 'all' || item.dataset.category === categoryId) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Перезапускаем слайдер после фильтрации
            const carousel = new bootstrap.Carousel(document.getElementById('newsSlider'));
            carousel.to(0); // Переходим к первому слайду
        });
    });
});


//Отзывы
document.addEventListener('DOMContentLoaded', function() {
    const editReviewModal = document.getElementById('editReviewModal');
    
    if (editReviewModal) {
        editReviewModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const reviewId = button.getAttribute('data-review-id');
            const form = document.getElementById('editReviewForm');
            
            // Устанавливаем правильный action для формы
            form.action = `{{ route('reviews.update', ':id') }}`.replace(':id', reviewId);
            
            // Заполняем данные
            document.getElementById('editReviewId').value = reviewId;
            document.getElementById('editReviewComment').value = button.getAttribute('data-comment');
            
            // Устанавливаем рейтинг
            const rating = button.getAttribute('data-rating');
            document.querySelector(`input[name="rating"][value="${rating}"]`).checked = true;
        });
    }
    
    // Обработка отправки формы
    const form = document.getElementById('editReviewForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Стандартная отправка формы
            this.submit();
        });
    }
});

