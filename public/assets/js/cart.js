document.addEventListener('DOMContentLoaded', function() {
    // Обработчик для кнопки на странице бензопил
    document.getElementById('cart-chainsaw')?.addEventListener('click', async function(e) {
        e.preventDefault();
        
        const button = this;
        const productId = button.dataset.productId;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        // Показываем лоадер
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        try {
            const response = await fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ product_id: productId })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Перенаправляем в корзину
                window.location.href = '/cart';
            } else {
                alert(data.message || 'Ошибка при добавлении');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Произошла ошибка');
        } finally {
            // Восстанавливаем кнопку
            button.innerHTML = '<i class="fa-solid fa-cart-shopping"></i>';
            button.disabled = false;
        }
    });
}); 