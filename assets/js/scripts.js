!(function($) {
    "use strict";

    var bg_scripts = {

		init: function () {
			// call singleTabs()
			bg_scripts.singleTabs();
			
			// call owlCarousel()
			bg_scripts.Carousel();
			
			// call lightGallery()
			bg_scripts.lightGallery();
			
			// call skillEffect()
			bg_scripts.skillEffect();
			
			// call Masonry()
			bg_scripts.Masonry();
			
			// call instagramPopup()
			bg_scripts.instagramPopup();
			
			// call Masonry()
			bg_scripts.Filter();
			
			// call loadMore()
			bg_scripts.loadMore();
			
			// call teamHover()
			bg_scripts.teamHover();
		},
		
		/*
		 * owlCarousel
		 */
		Carousel: function () {
			var self = this,
				$wrap = $('.bg-owl-carousel');

			$wrap.each(function(){
				var $thisEl = $(this);
					
				/* trigger event */
				$thisEl.on({
					'_do_carousel' (e) {
						var atts = $(this).parents('.bg--wrapper').data('atts');
						
						$(this).owlCarousel({
							margin: parseInt(atts.space.replace('px', '')),
							loop: true,
							dots: atts.dots,
							autoplay: atts.autoplay,
							autoplayTimeout: atts.autoplayTimeout, 
							autoplaySpeed: atts.autoplaySpeed,
							autoplayHoverPause: atts.autoplayHoverPause,
							navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
							responsive: {
								0: {
									items: 1
								},
								600: {
									items: 2
								},
								1000: {
									items: parseInt(atts.column)
								}
							}
						})
					},
					'_destroy_carousel' (e) {
						$(this).trigger('destroy.owl.carousel');
					},
					'_carousel_new_content' (e, content) {
						$(this).find('.bg--item').remove()
						
						$(this).html(content)
						
					},
				})
				
				setTimeout(function(){
					$thisEl.trigger('_do_carousel')
				}, 500)
			});
			
		},
		
		/*
		 * Tab for single
		 */
		singleTabs: function () {
			var self = this,
				$tabs = $('.bg-tabs-wrap');

			$tabs.on('click', '.bg-nav-tabs a', function (event) {
				event.preventDefault();
				var tab = $(this).attr('href');
				
				$(this).parent().addClass('active').siblings().removeClass('active');
				
				$(this).parents('.bg-tabs-wrap').find(tab).addClass('active').siblings().removeClass('active');
				
				bg_scripts.skillEffect();
			})
		},
		
		/*
		 * lightGallery
		 */
		lightGallery: function () {
			var self = this,
				$wrap = $('.bg-light-gallery');
			
			$wrap.each(function(){
				
				var $thisEl = $(this);
				
				/* trigger event */
				$thisEl.on({
					'_do_light_gallery' (e) {
						$(this).lightGallery({
							selector: '.bg-gallery-item'
						});
					},
					'_destroy_light_gallery' (e) {
						$(this).data('lightGallery').destroy(true);
					},
					'_refresh_light_gallery' (e) {
						$(this)
							.trigger('_destroy_light_gallery')
							.trigger('_do_light_gallery')
							
					},
				}).trigger('_do_light_gallery')
				
			});
		},
		
		/*
		 * skillEffect
		 */
		skillEffect: function () {
			var self = this,
			$wrap = $('.bg-skill');
			if(  $wrap.parent().is(":visible") == true ){
				$wrap.find('.item-skills').each(function(){
					var elems = $(this);
					var level = $(this).data('percent');
					elems.css('transition', 'all 0s ease');
					elems.css('width', '10%');
					
					
					setTimeout(function(){
						elems.css('transition', 'all 1s ease');
						elems.css('width', level+'%');
					}, 50);
				});    
			}
		},
		
		/*
		 * Masonry
		 */
		Masonry: function () {
			var self = this,
				$wrap = $('.bg-masonry-items');
			
			$wrap.each(function(){
				
				var $thisEl = $(this);
				
				/* trigger event */
				$thisEl.on({
					'_do_masonry' (e) {
						var isotope_obj = $(this).isotope({
							masonry: {
								columnWidth: '.grid-sizer',
								gutter: '.gutter-sizer'
							},
							itemSelector: '.bg--item',
							percentPosition: true
						});
						
						$(this).data('grid_isotope_obj', isotope_obj)
					},
					'_masonry_after_ajax' (e) {
						var $grid_isotope = $(this).data('grid_isotope_obj');
						$grid_isotope.isotope('layout').delay(500).queue(function() {
							$grid_isotope.isotope('layout');
							$(this).dequeue();
						});
					},
					'_masonry_new_content' (e, content) {
						$(this).find('.bg--item').remove()
						
						var $grid_isotope = $(this).data('grid_isotope_obj');
						var $content = $(content);
						
						$grid_isotope
						.append( $content )
						.isotope( 'appended', $content );
					},
					'_masonry_add_content' (e, content) {
						var $grid_isotope = $(this).data('grid_isotope_obj');
						var $content = $(content);
						
						$grid_isotope
						.append( $content )
						.isotope( 'appended', $content );
					},
				}).trigger('_do_masonry')
				
			});
		},
		
		/*
		 * Filter
		 */
		Filter: function () {
			var self = this,
				$wrap = $('.bg--wrapper');
			
			$wrap.each(function(){
				var _wrap = $(this);
				 
				_wrap.find('.bg--filter').on('click', '.filter-item', function(){
					var _this = $(this),
						itemsElem = _this.parents('.bg--wrapper').find('.bg--items'),
						atts = _this.parents('.bg--wrapper').data('atts'),
						cat = _this.data('cat');
						
					_this.parents('.bg--filter').find('.filter-item').removeClass('is-active');
					_this.addClass('is-active');
					_this.parents('.bg--wrapper').find('.bg--actions').find('.load-more').data('offset', atts.number);
					
					
					$.ajax({
						type: "POST",
						url: ajax_call.ajax_url,
						data: {
							'action':  'bg_ajax_get_data',
							'atts': atts,
							'cat_id': cat
						},
						beforeSend: function() {
							_this.parents('.bg--wrapper').addClass('is-filtering');
						},
						success: function(data){
							_this.parents('.bg--wrapper').removeClass('is-filtering');
							
							var _data = JSON.parse(data);
							
							itemsElem
								.trigger('_masonry_new_content', [_data.html])
								.trigger('_masonry_after_ajax')
								.trigger('_destroy_carousel')
								.trigger('_carousel_new_content', [_data.html])
								.trigger('_do_carousel')
								.trigger('_refresh_light_gallery')
								
							bg_scripts.teamHover();
						
							if(_data.more == 0) {
								_this.parents('.bg--wrapper').find('.bg--actions').find('.load-more').hide();
							} else {
								_this.parents('.bg--wrapper').find('.bg--actions').find('.load-more').show();
							}
						},
						error: function(error){
							console.log(error);
						}
					});
				})
			});
		},
		
		/*
		 * Load more
		 */
		loadMore: function () {
			var self = this,
				$wrap = $('.bg--wrapper');
			
			$wrap.each(function(){
				var _wrap = $(this);
				 
				_wrap.find('.bg--actions').on('click', '.load-more', function(){
					var _this = $(this),
						itemsElem = _this.parents('.bg--wrapper').find('.bg--items'),
						atts = _this.parents('.bg--wrapper').data('atts'),
						cat = _this.parents('.bg--wrapper').find('.bg--filter').find('.is-active').data('cat'),
						offset = _this.data('offset'),
						nextid = _this.data('nextid'),
						nexturl = _this.data('nexturl');
					
					$.ajax({
						type: "POST",
						url: ajax_call.ajax_url,
						data: {
							'action':  'bg_ajax_get_data',
							'atts': atts,
							'cat_id': cat,
							'offset': offset,
							'nextid': nextid,
							'nexturl': nexturl,
						},
						beforeSend: function() {
							_this.parents('.bg--wrapper').addClass('is-filtering');
						},
						success: function(data){
							_this.parents('.bg--wrapper').removeClass('is-filtering');
							
							var _data = JSON.parse(data);
							var _more = JSON.parse(_data.more);
							console.log(_data);
							itemsElem
								.trigger('_masonry_add_content', [_data.html])
								.trigger('_masonry_after_ajax')
								.trigger('_refresh_light_gallery')
						
							_this.data('offset', (parseInt(offset) + parseInt(atts.number)));
							
							_this.data('nextid', _more.nextid);
							_this.data('nexturl', _more.nexturl);
							
							bg_scripts.teamHover();
							bg_scripts.instagramPopup();
							
							if(_data.more == 0) {
								_this.hide();
							}
						},
						error: function(error){
							console.log(error);
						}
					});
				})
			});
		},
		
		/*
		 * teamHover
		 */
		teamHover: function () {
			var self = this,
			$wrap = $('.bg-team-wrapper');
			
			$wrap.each(function(){
				var $thisEl = $(this);
				
				$thisEl.find('.bg--item').on('hover', function(){
					bg_scripts.skillEffect();
				})
				
			})
		},
		
		/*
		 * instagramPopup
		 */
		instagramPopup: function () {
			var self = this,
			$wrap = $('.bg-instagram-wrapper');
			
			$wrap.each(function(){
				var $thisEl = $(this);
				var $popup = $thisEl.find('.bg-popup-wrapper');
				var $overlayElem = $thisEl.find('.bg-popup-overlay');
				
				// Popup trigger event
				$popup.on({
					'_open' () {
						$(this).addClass('active');
						$overlayElem.addClass('active');
					},
					'_close' () {
						$(this).removeClass('active');
						$overlayElem.removeClass('active');
					},
					'_replace_content' (e, data) {
						$(this).find('.bg-popup-media').css('background-image', 'url('+ data.img +')');
						$(this).find('.bg-popup-info-user-image a').attr({'href': 'https://www.instagram.com/' + data.username, 'title': data.username});
						$(this).find('.bg-popup-info-user-image img').attr({'src': data.avatar, 'alt': data.username});
						$(this).find('.bg-popup-info-user-name a').text(data.username).attr({'href': 'https://www.instagram.com/' + data.username, 'title': data.username});
						$(this).find('.bg-popup-info-user-actions a').attr({'href': 'https://www.instagram.com/' + data.username, 'title': data.username});
						
						$(this).find('.bg-popup-info-feed a').attr('href', data.link);
						$(this).find('.bg-popup-info-feed a.bg-instagram-created-time').text(data.created_time);
						$(this).find('.bg-instagram-likes span').text(data.like);
						$(this).find('.bg-instagram-comments span').text(data.comment);
						
						var comments = '';
						$.each( data.comments, function( key, value ) {
							comments += '<div class="bg-popup-comment"><a href="https://www.instagram.com/'+ value.username +'">'+ value.username +'</a><span>'+ value.text +'</span></div>';
						});
						$popup.find('.bg-popup-info-comments').html(comments);
						
					}
				})
				
				$thisEl.find('.bg--item').on('click', function(){
					var data = $(this).data('popup');
					
					console.log(data);
					// 
					$popup
					.trigger('_open')
					.trigger('_replace_content', [data])
					
				})
				
				
				/* close popup */
				$thisEl.find('.bg-popup-overlay').on('click', function(){
					$popup.trigger('_close');
				})
				
				$thisEl.find('.bg-popup-wrapper').on('click', '.bg-popup-close', function(event){
					event.preventDefault();
					$popup.trigger('_close');
				})
				
			})
		},
		
	}
	 
	
	
    /* DOM Ready */
    $(function() {
        bg_scripts.init();
		
		

    })


	
})(jQuery)


