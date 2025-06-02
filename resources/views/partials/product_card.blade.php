      <div class="product-card h-100" style="width: auto;"> <!-- Добавляем h-100 для одинаковой высоты -->
      <img src="{{ asset('assets/img/products/' . $product->image) }}" alt="{{ $product->name }}"
        class="product-image img-fluid">
      <div class="product-info">
        <a href="{{ route('products.show', ['name' => $product->toolType->name, 'id' => $product->id]) }}">
        <h3 class="product-name">{{ $product->name }}</h3>
        </a>
        <p class="product-description">{{ $product->short_description }}</p>
        <p class="product-price">Цена: {{ number_format($product->price, 0, '', ' ') }} ₽</p>
      </div>
      <div class="product-actions">
        <form action="{{ route('favorite.add', ['product' => $product->id]) }}" method="POST">
        @csrf
        <button type="submit" data-product-id="{{ $product->id }}" class="add-to-fav">
        <i class="fa-solid fa-heart solid-heart fa-xl"></i>
        </button>
        </form>
        <form action="{{ route('cart.add', $product->id) }}" method="POST">
        @csrf
        <button type="submit" class="add-to-cart" data-id="{{ $product->id }}">
        <i class="fa-solid fa-cart-shopping"></i>
        </button>
        </form>
      </div>
      </div>