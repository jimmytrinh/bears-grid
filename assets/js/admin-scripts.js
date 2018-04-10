!(function($) {
  'use strict';

	var bg_admin_scripts = {

		init: function () {
			// call metaTabs()
			bg_admin_scripts.metaTabs();
			
			// call niceSelect()
			bg_admin_scripts.niceSelect();
			
			// call galleryField()
			bg_admin_scripts.galleryField();
			
			// call addmoreField()
			bg_admin_scripts.addmoreField();
			
			// call colorField()
			bg_admin_scripts.colorField();
		},

		/*
		 * Tab for meta boxes
		 */
		metaTabs: function () {
			var self = this,
				$metaWrapper = $('.bg-meta-boxes-wrapper');

			$metaWrapper.on('click', '.bg-tab-item a', function () {
				var tab = $(this).data('tab');
				
				$(this).parent().addClass('active').siblings().removeClass('active');
				
				$(this).parents('.bg-meta-boxes-inner').find(tab).addClass('active').siblings().removeClass('active');
            })
		},
		
		/*
		 * nice select
		 */
		niceSelect: function () {
			var self = this;
			
			$('select.bg-select').niceSelect();
		},
		
		/*
		 * field gallery
		 */
		galleryField: function () {
			var _this = this,
				$views = $('.bg-files-views');
				
				
			/* addFiesHandle */
			this.addFilesHandle = function () {
				$views.on('click', '.bg-add-files', function() {
					var self = this,
						$status = $(this).parents('.bg-files-views').find('.bg-status span'),
						$input = $(this).parents('.bg-files-views').find('.bg-files'),
						$items = $(this).parents('.bg-files-views').find('.bg-item'),
						multi = $(this).parents('.bg-files-views').data('multiple'),
						max_files = $(this).parents('.bg-files-views').data('max-files'),
						type = $(this).parents('.bg-files-views').data('type'),
						file_frame, attachments, fileID, files_list = "", files_select = "";

					if( multi == false) {
						max_files = 1;
					}

					if( $items.length >= max_files ) {
							alert('Limited ^^ ');
							return;
					}

					if( $items.length > 0 ){
						$items.each(function(){
							files_list += $(this).data('id') + ',';
						});
					}

					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media({
						title: 'Select Files',
						button: {
							text: 'Select Files',
						},
						multiple: multi,
						allowLocalEdits: true,
						displaySettings: true,
						displayUserSettings: true,
						type : 'image'
					});

					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						// We set multiple to false so only get one image from the uploader
						attachments = file_frame.state().get('selection').toJSON();
						var media_select_obj = [];
						if(! attachments) return;

						for(var i=0; i < attachments.length; i++) {
							if(i == (attachments.length - 1)) {
								files_list += attachments[i].id;
								files_select += attachments[i].id;
							} else {
								 files_list += attachments[i].id + ',';
								 files_select += attachments[i].id + ',';
							}
						}
						
						/* update status */
						if( $items.length + attachments.length > max_files ){
							alert('Limited ^^ ');
							return;
						}
						$status.text($items.length + attachments.length);

						$input.val(files_list);

						$.ajax({
							type: "POST",
							url: admin_ajax_call.ajax_url,
							data: {
								'action': 'bg_ajax_get_uploaded_data',
								'files_select': files_select,
								'type': type,
							},
							beforeSend: function () {
								//jQuery('#submit-client-site').val('Saving...');
							},
							success: function (data) {
								console.log(data);
								//$views.find('.bg-files-list').append(data);
								$(self).parents('.bg-files-views').find('.bg-files-list').append(data);
							}

						});

					});

					file_frame.open();
				});
			}
			
			/* sortable */
			this.sortableHandle = function () {
				$views.find('.bg-files-list').sortable({
					opacity: 0.6,
					cursor: 'move',
					scrollSensitivity: 40,
					update: function( event, ui ) {
						var $input = ui.item.parents('.bg-files-views').find('.bg-files'),
							$items = ui.item.parents('.bg-files-views').find('.bg-item'),
							list_item = "";

						 /* updateHandle */
						$items.each(function( index, item ) {
							 list_item += $(item).data('id') + ',';
						});

						$input.val(list_item.slice(0, -1));
					}
				});
			}
			
			/* removeHandle */
			this.removeHandle = function () {
				$views.on('click', '.bg-delete-file', function(e) {
					e.preventDefault();

					var $status = $(this).parents('.bg-files-views').find('.bg-status span'),
						$input = $(this).parents('.bg-files-views').find('.bg-files'),
						$items = $(this).parents('.bg-files-views').find('.bg-item'),
						count_item = $(this).parents('.bg-files-views').find('.bg-item').length,
						current_id = $(this).parents('.bg-item').data('id'),
						list_item = "",
						item_index = $(this).parents('.bg-item').index();

					
					$(this).parents('.bg-item').remove();

					/* status */
					$status.text(count_item - 1);
					
					/* updateHandle */
					console.log($items.length);
					$items.each(function( index, item ) {
						var item_id = $(item).data('id');

						if( index != item_index ) {
								list_item += $(item).data('id') + ',';
						}
					});

					$input.val(list_item.slice(0, -1));
				})
			}
			
			if($views.length > 0) {
				/* call addFiesHandle */
				this.addFilesHandle();
				
				/* call sortableHandle */
				this.sortableHandle();
				
				/* call removeHandle */
				this.removeHandle();
			}
		},
		
		/*
		 * field Add more
		 */
		addmoreField: function () {
			var _this = this,
				$views = $('.bg-addmore-views');
				
			/* addFiesHandle */
			this.addMoreHandle = function () {
				$views.on('click', '.bg-add-files', function() {
					var self = this,
					$container = $(this).parents('.bg-addmore-views').find('.bg-addmore-container'),
					number = $(this).parents('.bg-addmore-views').find('.bg-ordinal-numbers').val(),
					field = $(this).parents('.bg-addmore-views').data('field'),
					id = $(this).parents('.bg-addmore-views').data('id');
					
					$.ajax({
						type: "POST",
						url: admin_ajax_call.ajax_url,
						data: {
							'action': 'bg_ajax_render_addmore_item',
							'params': {
								'field': field,
								'id': id,
								'number': number
							}
						},
						beforeSend: function () {
							//jQuery('#submit-client-site').val('Saving...');
						},
						success: function (data) {
							$container.append(data);
							$(self).parents('.bg-addmore-views').find('.bg-ordinal-numbers').val(parseInt(number)+1);
							bg_admin_scripts.colorField();
						}

					});
					
				})
			}
			
			/* sortable */
			this.sortableHandle = function () {
				$views.find('.bg-addmore-container').sortable({
					handle: ".bg-addmore-drag",
					cursor: 'move',
					axis: "y",
					scrollSensitivity: 40,
				});
			}
			
			/* removeHandle */
			this.removeHandle = function () {
				$views.find('.bg-addmore-container').on('click', '.bg-addmore-remove', function(e) {
					e.preventDefault();

					$(this).parents('.bg-addmore-item').remove();
				})
			}
			
			if($views.length > 0) {
				/* call sortableHandle */
				this.sortableHandle();
				
				/* call removeHandle */
				this.removeHandle();
				
				/* call removeHandle */
				this.addMoreHandle();
			}
		},
		
		/*
		 * choose color
		 */
		colorField: function () {
			var self = this;
			console.log($('input.bg-color').length);
			$('input.bg-color').each(function(){
				$(this).on('focus', function(event){
					event.preventDefault();
				})
				$(this).wpColorPicker();
				
            });
		},
	}
	
	
	
	/* end vu js */
	
	
	/* DOM Ready */
	$(function() {
		bg_admin_scripts.init();

	})
})(jQuery)

