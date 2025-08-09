// تحديث كمية منتج في السلة
function updateCartQuantity(productId, quantity) {
    fetch(`/cart/update/${productId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // تحديث الكمية والسعر في الواجهة بدون إعادة تحميل
            const input = document.querySelector(`.quantity-input[data-product-id='${productId}']`);
            if (input) input.value = quantity;
            const price = data.product_price || 0;
            const subtotal = price * quantity;
            const itemTotal = document.querySelector(`[data-item-total='${productId}']`);
            if (itemTotal) itemTotal.textContent = subtotal.toFixed(2) + ' ريال';
            // تحديث ملخص السلة
            if (data.totalQuantity !== undefined && data.totalPrice !== undefined) {
                const itemsCount = document.querySelector('.cart-items-count');
                const cartTotal = document.querySelectorAll('.cart-total');
                if (itemsCount) itemsCount.textContent = data.totalQuantity + ' منتج';
                cartTotal.forEach(el => el.textContent = data.totalPrice.toFixed(2) + ' ريال');
            }
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('حدث خطأ أثناء تحديث الكمية', 'error');
    });
}

// حذف منتج من السلة
function removeFromCart(productId) {
    fetch(`/cart/remove/${productId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // حذف العنصر من الواجهة
            const item = document.querySelector(`.cart-item[data-cart-item='${productId}']`);
            if (item) item.remove();
            // تحديث ملخص السلة
            if (data.totalQuantity !== undefined && data.totalPrice !== undefined) {
                const itemsCount = document.querySelector('.cart-items-count');
                const cartTotal = document.querySelectorAll('.cart-total');
                if (itemsCount) itemsCount.textContent = data.totalQuantity + ' منتج';
                cartTotal.forEach(el => el.textContent = data.totalPrice.toFixed(2) + ' ريال');
            }
            // إذا أصبحت السلة فارغة أظهر رسالة السلة الفارغة
            if (data.totalQuantity === 0) {
                document.querySelectorAll('.cart-items, .bg-white.rounded-xl.shadow-sm, .space-y-3').forEach(el => el.style.display = 'none');
                var emptyMsg = document.getElementById('empty-cart-message');
                if (emptyMsg) emptyMsg.style.display = 'block';
                updateCartCount(0);
            }
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('حدث خطأ أثناء حذف المنتج', 'error');
    });
}

// إفراغ السلة بالكامل
function clearCart() {
    fetch('/cart/clear', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // إخفاء عناصر السلة وعرض رسالة السلة الفارغة بدون تحديث الصفحة
            document.querySelectorAll('.cart-items, .bg-white.rounded-xl.shadow-sm, .space-y-3').forEach(el => el.style.display = 'none');
            var emptyMsg = document.getElementById('empty-cart-message');
            if (emptyMsg) emptyMsg.style.display = 'block';
            updateCartCount(0);
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('حدث خطأ أثناء إفراغ السلة', 'error');
    });
}
// إضافة منتج للسلة
function addToCart(productId, productName) {
    const button = document.querySelector(`[data-product-id="${productId}"]`);
    const buttonText = button.querySelector('.button-text');
    const loadingText = button.querySelector('.loading-text');
    
    // إظهار حالة التحميل
    if (buttonText) buttonText.style.display = 'none';
    if (loadingText) loadingText.style.display = 'inline-block';
    button.disabled = true;

    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // تحديث عداد السلة
            updateCartCount(data.cart_count);
            
            // إظهار رسالة نجاح
            showNotification(data.message, 'success');
            
            // إظهار حالة النجاح
            if (loadingText) loadingText.style.display = 'none';
            if (buttonText) {
                buttonText.innerHTML = '<i class="fas fa-check ml-2"></i>تمت الإضافة';
                buttonText.style.display = 'inline-block';
            }
            button.style.background = 'linear-gradient(135deg, #16a34a 0%, #15803d 100%)';
            
            // إعادة الحالة الأصلية بعد ثانيتين
            setTimeout(() => {
                if (buttonText) {
                    buttonText.innerHTML = '<i class="fas fa-cart-plus ml-2"></i>إضافة للسلة';
                }
                button.style.background = '';
                button.disabled = false;
            }, 2000);
        } else {
            showNotification(data.message, 'error');
            // إعادة الحالة الأصلية في حالة الخطأ
            if (loadingText) loadingText.style.display = 'none';
            if (buttonText) buttonText.style.display = 'inline-block';
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('حدث خطأ أثناء إضافة المنتج', 'error');
        // إعادة الحالة الأصلية في حالة الخطأ
        if (loadingText) loadingText.style.display = 'none';
        if (buttonText) buttonText.style.display = 'inline-block';
        button.disabled = false;
    });
}

// تحديث عداد السلة
function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
        element.textContent = count;
        if (count > 0) {
            element.classList.remove('hidden');
        } else {
            element.classList.add('hidden');
        }
    });
}

// إظهار إشعار
function showNotification(message, type = 'success') {
    // إنشاء الإشعار
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
    
    if (type === 'success') {
        notification.classList.add('bg-green-500', 'text-white');
        notification.innerHTML = `<i class="fas fa-check-circle ml-2"></i>${message}`;
    } else {
        notification.classList.add('bg-red-500', 'text-white');
        notification.innerHTML = `<i class="fas fa-exclamation-circle ml-2"></i>${message}`;
    }
    
    document.body.appendChild(notification);
    
    // إظهار الإشعار
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // إخفاء الإشعار بعد 3 ثوان
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// تحميل عداد السلة عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            updateCartCount(data.count);
        })
        .catch(error => {
            console.error('Error loading cart count:', error);
        });
});

// إضافة event listeners لأزرار إضافة للسلة
document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            addToCart(productId, productName);
        });
    });
});
