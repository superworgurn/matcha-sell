// ปุ่มกากบาท
const cartSection = document.getElementById('cart'); // เก็บ element #cart ไว้เหมือนเดิม
const closeCartButton = document.querySelector('.close-button'); // เปลี่ยน selector เป็น .close-button

closeCartButton.addEventListener('click', () => {
    cartSection.classList.add('hidden');
});