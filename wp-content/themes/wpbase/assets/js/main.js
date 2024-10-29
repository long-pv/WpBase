(function ($, window) {
	// Open and close the mobile menu
	$(".header .header__toggleItem").on("click", function () {
		menu_open_sp();
	});

	$(".mainBodyContent").on("click", function () {
		if (!$(this).hasClass("menu__openSp")) return;
		menu_open_sp();
	});

	function menu_open_sp() {
		$("body").toggleClass("mobile-menu-open");
		$(".header__menusp").toggleClass("active");
		$(".header__toggleItem").toggle();
		$(".mainBodyContent").toggleClass("menu__openSp");
	}
	// end mobile menu

	// wpadminbar
	if ($("#wpadminbar").length > 0) {
		$(".header").css("margin-top", $("#wpadminbar").outerHeight(true));
	}

	// slick hiển thị arrow ngay cả khi có quá ít item
	function calculateSlidesToShow(selector, itemClass) {
		var item = $(selector).find(itemClass);
		item.css("display", "inline-block");
		var itemCount = item.length;
		var totalItemWidth = 0;
		item.each(function () {
			totalItemWidth += $(this).outerWidth(true);
		});
		var sliderWidth = 0;
		var slidesToShowCount = 0;
		sliderWidth = $(selector).width();
		slidesToShowCount = totalItemWidth < sliderWidth ? itemCount : Math.floor(sliderWidth / item.outerWidth(true));
		return slidesToShowCount;
	}

	function setupCustomNavigation(selector) {
		$(selector).on("init", function (event, slick) {
			var prevButton = $('<button class="slick-prev slick-arrow"></button>');
			var nextButton = $('<button class="slick-next slick-arrow"></button>');
			$(selector).append(prevButton, nextButton);

			prevButton.on("click", function () {
				var currentSlide = slick.slickCurrentSlide();
				$(selector + ' .slick-slide[data-slick-index="' + (currentSlide - 1) + '"]').click();
			});

			nextButton.on("click", function () {
				var currentSlide = slick.slickCurrentSlide();
				$(selector + ' .slick-slide[data-slick-index="' + (currentSlide + 1) + '"]').click();
			});
		});
	}

	setupCustomNavigation(".slideGalleryAll");
	$(".slideGalleryAll").slick({
		variableWidth: true,
		slidesToScroll: 1,
		adaptiveHeight: true,
		focusOnSelect: true,
		infinite: true,
		arrows: false,
		slidesToShow: calculateSlidesToShow(".slideGalleryAll", ".slideGallery__item"),
	});
	// end -- slick hiển thị arrow ngay cả khi có quá ít item

	$(document).on("click", ".favorite_posts", function (e) {
		e.preventDefault(); // Ngăn chặn hành động mặc định nếu có
		let $this = $(this);
		let post_id = $this.data("post_id");

		$.ajax({
			url: url_ajax,
			type: "POST",
			data: {
				action: "favorite_posts",
				post_id: post_id,
			},
			beforeSend: function () {
				$("body").append('<div id="ajax-loader"><div class="spinner"></div></div>');
			},
			success: function (response) {
				if (response.success) {
					if (response.data.status === "added") {
						$('.favorite_posts[data-post_id="' + post_id + '"]').addClass("active");
					} else if (response.data.status === "removed") {
						$('.favorite_posts[data-post_id="' + post_id + '"]').removeClass("active");
					}
				} else {
					alert(response.data.message);
				}
			},
			error: function () {
				alert("Something went wrong.");
			},
			complete: function () {
				$("body #ajax-loader").remove();
			},
		});
	});
})(jQuery, window);
