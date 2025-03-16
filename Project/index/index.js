const buyButtons = document.querySelectorAll('.buy-button');
const cartDisplay = document.getElementById('cart-items');
const totalPriceDisplay = document.getElementById('total-price');

buyButtons.forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');

        fetch('/add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `product_id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
                // แสดงข้อผิดพลาดให้ผู้ใช้ทราบ
            } else {
                updateCartDisplay(data.cart_items);
                updateTotalPrice(data.total_price);
            }
        })
        .catch(error => {
            console.error('There was an error:', error);
        });
    });
});

function updateCartDisplay(cartItems) {
    cartDisplay.innerHTML = '';
    if (cartItems && cartItems.length > 0) {
        cartItems.forEach(item => {
            const listItem = document.createElement('li');
            listItem.textContent = `${item.product_name} (จำนวน: ${item.quantity}) - ${parseFloat(item.price * item.quantity).toFixed(2)} บาท`;
            cartDisplay.appendChild(listItem);
        });
    } else {
        cartDisplay.textContent = 'ตะกร้าสินค้าของคุณว่างเปล่า';
    }
}

function updateTotalPrice(totalPrice) {
    totalPriceDisplay.textContent = parseFloat(totalPrice).toFixed(2);
}