(function($) {
	$(function() {
		var jcarousel = $('.jcarousel');

		jcarousel
				.on('jcarousel:reload jcarousel:create', function () {
					var width = jcarousel.innerWidth();

					if (width >= 600) {
						width = width / 4;
					}else if (width >= 400) {
						width = width / 3;
					} else if (width >= 200) {
						width = width / 2;
					}

					jcarousel.jcarousel('items').css('width', width + 'px')
					.('.thumbnail').css('width', width + 'px');
				})
				.jcarousel({
					wrap: 'circular'
				});

		$('.jcarousel-control-prev')
				.jcarouselControl({
					target: '-=1'
				});

		$('.jcarousel-control-next')
				.jcarouselControl({
					target: '+=1'
				});

		$('.jcarousel-pagination')
				.on('jcarouselpagination:active', 'a', function() {
					$(this).addClass('active');
				})
				.on('jcarouselpagination:inactive', 'a', function() {
					$(this).removeClass('active');
				})
				.on('click', function(e) {
					e.preventDefault();
				})
				.jcarouselPagination({
					perPage: 1,
					item: function(page) {
						return '<a href="#' + page + '" role="button" tabindex="0">' + page + '</a>';
					}
				});
	});
})(jQuery);