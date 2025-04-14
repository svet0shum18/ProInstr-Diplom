
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
