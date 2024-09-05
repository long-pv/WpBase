// <div id="categoryBlock" class="categoryBlock" data-label="Categories:">
// <div class="selecDropdownCate">
// <ul class="categoryBlock__list">
// <li id="catItem-all" class="categoryBlock__item active">
// <a class="categoryBlock__link active" href="#">
// View all
// </a>
// </li>
// <li id="catItem-22" class="categoryBlock__item ">
// <a class="categoryBlock__link " href="#">
// Blog
// </a>
// </li>
// <li id="catItem-24" class="categoryBlock__item ">
// <a class="categoryBlock__link " href="#">
// News
// </a>
// </li>
// </ul>
// </div>
// </div>

// style: assets/scss/contents/dropdown_ul

(function ($, window) {
	var selectDropdownCat = $(".selectDropdownCat ul");
	if ($(window).width() < 992 && selectDropdownCat.length > 0) {
		let category_label = $(".categoryBlock").data("label");

		selectDropdownCat.each(function () {
			let li_first_child = $(this).find("li").has("a.active");
			let htmlDropdown = "";

			if (li_first_child.length === 0) {
				htmlDropdown = $("<a href='javascript:void(0);'></a>")
					.html(contentCategory)
					.addClass("categoryBlock__link selected active");
			} else {
				let content = li_first_child.find("a.active").text();
				htmlDropdown = $("<a href='javascript:void(0);'></a>")
					.html(content)
					.addClass("categoryBlock__link selected active");
			}

			let first_option = $("<li></li>", {
				class: "categoryBlock__item init",
			});

			let label = '<span class="label"><span>' + category_label + "</span></span>";
			$(this).prepend(first_option.append(htmlDropdown.prepend(label)));
		});

		selectDropdownCat.on("click", ".init", function () {
			$(this).closest("ul").children("li:not(.init)").toggle();
			$(this).toggleClass("active");
		});

		selectDropdownCat.on("click", "li:not(.init)", function () {
			let allOptions = $(this).closest("ul").children("li:not(.init)");
			allOptions.removeClass("selected");
			$(this).addClass("selected");
		});

		$(document).on("click", function (event) {
			if (!$(event.target).closest(selectDropdownCat).length) {
				selectDropdownCat.find("li:not(.init)").hide();
				selectDropdownCat.find(".init").removeClass("active");
			}
		});
	}
})(jQuery, window);
