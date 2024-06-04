
//XỬ LÝ SCROLL IMG PHỤ
$(document).ready(function () {
    var slider = $('.detail__product--img-slider');

    if (!slider.hasClass('slick-initialized')) {
        slider.slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            prevArrow: '<button type="button" class="slick-prev custom-prev"><</button>',
            nextArrow: '<button type="button" class="slick-next custom-next">></button>',
            responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    }
                }
            ]
        });
    }
});


//XỬ LÝ CLICK IMG PHỤ => LOAD LÊN IMG MAIN
$(document).ready(function(){
    $('.detail__product--img-slider img').on('click', function(){
        var imgSrc = $(this).attr('src'); //lấy được dẫn img được click
        $('#main-product-img').attr('src', imgSrc); //thay đổi đường dẫn trên img main

        //set active cho hình ảnh phụ được chọn
        $('.detail__product--img-slider img').removeClass('active');
        $(this).addClass('active')
    });
});

//xử lý số lương input 
const quantityInput = document.querySelector('.detail_product--quantity input');
const reduceBtn = document.getElementById('btn_reduce');
const increaseBtn = document.getElementById('btn_increase');

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