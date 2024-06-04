//xử lý button tăng, giảm số lượng sản phẩm

//dùng forEach để duyệt tất cả các sản phẩm trong giỏ
document.querySelectorAll('.cart__details').forEach(function (cartDetails) {
    const quantityInput = cartDetails.querySelector('.cart__details--quantity input');
    const reduceBtn = cartDetails.querySelector('#btn_reduce');
    const increaseBtn = cartDetails.querySelector('#btn_increase');

    // Xử lý sự kiện khi nhấn nút giảm số lượng
    reduceBtn.addEventListener('click', function () {
        // Lấy giá trị hiện tại của input
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    // Xử lý sự kiện khi nhấn nút tăng số lượng
    increaseBtn.addEventListener('click', function () {
        // Lấy giá trị hiện tại của input
        let currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
    });

});

