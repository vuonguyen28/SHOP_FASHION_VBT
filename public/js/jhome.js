$(document).ready(function () {
    $('.slick-carousel').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 1
            }
        }]
    });
});

// xử lý animation left cho trending title khi cuộn tới
// Hàm kiểm tra khi phần tử hiện ra trong viewport
function isElementInViewport(el) {
    var rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Hàm xử lý sự kiện cuộn trang
function handleScroll() {
    var trendingTitle = document.getElementById("trending_title");
    var trendingSeeMore = document.getElementById("trending_seemore");
    var trendingSlide = document.getElementById("trending_slide");

    if (isElementInViewport(trendingTitle) && isElementInViewport(trendingSeeMore) && isElementInViewport(trendingSlide)) {
        trendingTitle.classList.add("slide-left");
        trendingSeeMore.classList.add("slide-bottom");
        trendingSlide.classList.add("slide-right");
    }
    // else {
    //     trendingTitle.classList.remove("slide-left");
    //     trendingSeeMore.classList.remove("slide-bottom");
    //     trendingSlide.classList.remove("slide-right");
    // }
}

// Thêm sự kiện cuộn trang
//   window.addEventListener("scroll", handleScroll);
// Đăng ký sự kiện scroll
window.addEventListener('scroll', function () {
    handleScroll();
});

//xử lý scroll hình ảnh san phẩm nổi bật
$(document).ready(function () {
    var slider = $('.trending__product--slider');
    // Khởi tạo thanh trượt nếu chưa tồn tại
    if (!slider.hasClass('slick-initialized')) {
        slider.slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            prevArrow: '<button type="button" class="slick-prev custom-prev"><</button>', // Nút prev
            nextArrow: '<button type="button" class="slick-next custom-next">></button>', // Nút next

            responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

    }
});
