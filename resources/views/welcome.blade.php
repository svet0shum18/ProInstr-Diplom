@extends('layouts.main')

@section('title', 'Главная страница')

@section('content')

<main class="main">
    <div class="body_container">
      <section class="welcome-page mt-4">
        <div class="slider">
          <div class="slides">
            <img src="assets/img/slider/img1.png" class="slide" alt="img1">
            <img src="assets/img/slider/img2.png" class="slide" alt="img2">
            <img src="assets/img/slider/img3.png" class="slide" alt="img3">
          </div>
          <button class="prev" onclick="prevSlide()">&#10094;</button>
          <button class="next" onclick="nextSlide()">&#10095;</button>
        </div>
        <div class="aboutUs">
          <h2 class="zag-section mt-4">Почему выбирают именно нас?</h2>

          <div class="aboutUs-cards mt-4 d-flex">
            <!-- Карточка раз-->
            <div class="aboutUs-cardinfo">
              <div class="card-icon mt-2">
              <img src="assets/img/icons/boxes.png" alt="big_assortment">
              </div>
              <div class="card-header">
                <h4 class="mt-4 h4-cardinfo" onclick="openModal('modal1')">Большой ассортимент</h4>
              </div>
              <p class="card-short mt-2">Найдется, что угодно</p>
            </div>
            
            <!-- Модальное окно -->
            <div id="modal1" class="modal">
              <div class="modal-content">
                <span class="close" onclick="closeModal('modal1')">&times;</span>
                <h3>Большой ассортимент</h3>
                <p>Мы предлагаем широкий выбор товаров, чтобы каждый клиент мог найти именно то, что ему нужно. 
                  Наш ассортимент включает более 1000 наименований продукции, которые удовлетворяют различные потребности и вкусы. 
                  Независимо от того, ищете ли вы что-то для дома, офиса или для профессиональных нужд — у нас есть все!
                  Мы регулярно обновляем каталог, чтобы предложить самые актуальные и востребованные товары, а также лучшие новинки рынка.

                </p>
              </div>
            </div>
              <!-- Карточка два -->
            <div class="aboutUs-cardinfo">
              <div class="card-icon mt-2">
              <img src="assets/img/icons/truck.png" alt="big_assortment">
              </div>
              <div class="card-header">
                <h4 class="mt-4 h4-cardinfo" onclick="openModal('modal2')">Доставка товаров</h4>
              </div>
              <p class="card-short mt-2">Привезем в кратчайшие сроки</p>
            </div>
            
            <!-- Модальное окно -->
            <div id="modal2" class="modal">
              <div class="modal-content">
                <span class="close" onclick="closeModal('modal2')">&times;</span>
                <h3>Доставка товаров</h3>
                <p>Мы гарантируем быструю и надежную доставку всех заказанных товаров прямо к вашему порогу. Независимо от того, где вы находитесь, мы обеспечим доставку в удобное для вас время.

                  Мы предлагаем несколько вариантов доставки:
                  
                      Стандартная доставка — доступна по всей территории страны с возможностью отслеживания посылки.
                  
                      Экспресс-доставка — для срочных заказов с минимальными сроками доставки.
                  
                      Самовывоз — закажите онлайн и заберите товар в удобном пункте самовывоза.
                  
                  Все товары тщательно упакованы, чтобы избежать повреждений в процессе транспортировки..

                </p>
              </div>
            </div>
            <!-- Карточка три -->
            <div class="aboutUs-cardinfo">
              <div class="card-icon mt-2">
              <img src="assets/img/icons/quality.png" alt="big_assortment">
              </div>
              <div class="card-header">
                <h4 class="mt-4 h4-cardinfo" onclick="openModal('modal3')">Качественные товары</h4>
              </div>
              <p class="card-short mt-2">Проверенные инструменты</p>
            </div>
            
            <!-- Модальное окно -->
            <div id="modal3" class="modal">
              <div class="modal-content">
                <span class="close" onclick="closeModal('modal3')">&times;</span>
                <h3>Товары наилучшего качества</h3>
                <p>Мы предлагаем только высококачественные товары от проверенных производителей. 
                  Каждый продукт проходит строгую проверку на соответствие стандартам и требованиям, 
                  что гарантирует долговечность и надежность. Мы уверены в качестве нашей продукции, 
                  и это подтверждается отзывами довольных клиентов и сертификатами качества.
                  Вы можете быть уверены, что покупаете товар, который прослужит долго и оправдает все ожидания.</p>
              </div>
            </div>

             <!-- Карточка четрые -->
             <div class="aboutUs-cardinfo">
              <div class="card-icon mt-2">
              <img src="assets/img/icons/discount.png" alt="big_assortment">
              </div>
              <div class="card-header">
                <h4 class="mt-4 h4-cardinfo" onclick="openModal('modal4')">Наличие скидок</h4>
              </div>
              <p class="card-short mt-2">Частые акции для Вас</p>
            </div>
            
            <!-- Модальное окно -->
            <div id="modal4" class="modal">
              <div class="modal-content">
                <span class="close" onclick="closeModal('modal4')">&times;</span>
                <h3>Наличие скидок</h3>
                <p>Мы регулярно проводим акции и предлагаем скидки на широкий ассортимент товаров. 
                  Наши клиенты могут воспользоваться выгодными предложениями и приобрести качественную продукцию по сниженным ценам. 
                  Следите за обновлениями на нашем сайте, чтобы не упустить лучшие скидки и акции!
                  Покупать у нас — это не только удобно, но и выгодно!
                </p>
              </div>
            </div>
        </div>
        
      </section><!-- ./Section welcome -->

      <section class="brands">
        <h2 class="zag-section mt-4">Мы сотрудничаем с популярными брендами</h2>
        <div class="d-flex align-items-center" style="position: relative; border-radius: 50px;">
          <!-- Кнопка влево -->
          <button id="scrollLeft" class="prev">
            &#10094;
          </button>
          <!-- Слайдер брендов -->
          <div id="brandSlider" class="d-flex overflow-hidden mt-4" style="scroll-behavior: smooth; flex-wrap: nowrap;">
            <!-- Бренды -->
            <a href="#" class="brand-card flex-shrink-0 text-center mx-2">
              <img src="assets/img/brands/aeg.jpg" alt="aeg">
            </a>
            <a href="#" class="brand-card flex-shrink-0 text-center mx-2">
              <img src="assets/img/brands/fubag.jpg" alt="fubag">
            </a>
            <a href="#" class="brand-card flex-shrink-0 text-center mx-2">
              <img src="assets/img/brands/gigant.jpg" alt="Brand 3">
            </a>
            <a href="#" class="brand-card flex-shrink-0 text-center mx-2">
              <img src="assets/img/brands/inforce.jpg" alt="Brand 4">
            </a>
            <a href="#" class="brand-card flex-shrink-0 text-center mx-2">
              <img src="assets/img/brands/kbt.jpg" alt="Brand 5">
            </a>
            <a href="#" class="brand-card flex-shrink-0 text-center mx-2">
              <img src="assets/img/brands/kendo.jpg" alt="Brand 6">
            </a>
            <a href="#" class="brand-card flex-shrink-0 text-center mx-2">
              <img src="assets/img/brands/keyang.jpg" alt="Brand 7">
            </a>
            <a href="#" class="brand-card flex-shrink-0 text-center mx-2">
              <img src="assets/img/brands/makita.jpg" alt="Brand 8">
            </a>
            <a href="#" class="brand-card flex-shrink-0 text-center mx-2">
              <img src="assets/img/brands/patriot.jpg" alt="Brand 9">
            </a>
            <a href="#" class="brand-card flex-shrink-0 text-center mx-2">
              <img src="assets/img/brands/qbrick.jpg" alt="Brand 10">
            </a>
            <a href="#" class="brand-card flex-shrink-0 text-center mx-2">
              <img src="assets/img/brands/ryobi.jpg" alt="Brand 11">
            </a>
          </div>
          <!-- Кнопка вправо -->
          <button id="scrollRight" class="next">
            &#10095;
          </button>
        </div>
      </section><!-- ./Section brands -->

      <section class="popular_product">
        <h2 class="zag-section mt-4">Популярные товары</h2>
        <div class="product-container mt-4">
        @foreach($products as $product)

          <div class="product-card">
           <img src="{{ asset('assets/img/product/' . $product->image) }}" alt="Product 1" class="product-image">
              <div class="product-info">
                <a href="#"><h3 class="product-name">{{ $product->name }}</h3></a>
                <p class="product-description">{{ $product->description }}</p>
                <p class="product-price">Цена:  {{ $product->price }} ₽</p>
                <!-- <p class="product-price">Количество:  {{ $product->quantity }} шт.</p> -->
              </div>
              <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="add-to-cart" data-id="{{ $product->id }}"><i class="fa-solid fa-cart-shopping"></i></button>
                </form>
            </div>
            @endforeach
      </div>
    </section><!-- ./Section popular -->
    </div>
  </main>

  @endsection
 