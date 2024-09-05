// <a class="btnFancybox" href="url_img" data-fancybox="gallery"><img src="url_img" alt=""></a>

(function ($, window) {
	if ($('[data-fancybox="gallery"]').length > 0) {
		$('[data-fancybox="gallery"]').fancybox({
			buttons: ["close"],
			loop: true,
			protect: true,
		});
	}
})(jQuery, window);
