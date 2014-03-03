var wpPWidgets;
(function($) {

wpPWidgets = {

	init : function() {
		var rem, sidebars = $('div.widgets-sortables'), the_id;

		$('#widgets-right').children('.widgets-holder-wrap').children('.sidebar-name').click(function(){
			var c = $(this).siblings('.widgets-sortables'), p = $(this).parent();
			if ( !p.hasClass('closed') ) {
				c.sortable('disable');
				p.addClass('closed');
			} else {
				p.removeClass('closed');
				c.sortable('enable').sortable('refresh');
			}
		});

		$('#widgets-left').children('.widgets-holder-wrap').children('.sidebar-name').click(function() {
			$(this).siblings('.widget-holder').parent().toggleClass('closed');
		});

		sidebars.not('#wp_inactive_widgets').each(function(){
			var h = 50, H = $(this).children('.widget').length;
			h = h + parseInt(H * 48, 10);
			//$(this).css( 'minHeight', 50 + 'px' ); // Why h? CHO changed to 50
		});

		$('a.widget-action').live('click', function(){
			var css = {}, widget = $(this).closest('div.widget'), inside = widget.children('.widget-inside'), w = parseInt( widget.find('input.widget-width').val(), 10 );

			if ( inside.is(':hidden') ) {
				if ( w > 250 && inside.closest('div.widgets-sortables').length ) {
					css['width'] = w - 75 + 'px';
					if ( inside.closest('div.widget-liquid-right').length )
						css['marginLeft'] = 340 - w + 'px';
					widget.css(css);
				}
				wpPWidgets.fixLabels(widget);
				inside.slideDown('fast');
			} else {
				inside.slideUp('fast', function() {
					widget.css({'width':'','marginLeft':''});
				});
			}
			return false;
		});

		$('input.widget-control-save').live('click', function(){
			wpPWidgets.save( $(this).closest('div.widget'), 0, 1, 0 );
			return false;
		});

		$('a.widget-control-remove').live('click', function(){
			wpPWidgets.save( $(this).closest('div.widget'), 1, 1, 0 );
			return false;
		});

		$('a.widget-control-close').live('click', function(){
			wpPWidgets.close( $(this).closest('div.widget') );
			return false;
		});

		sidebars.children('.widget').each(function() {
			wpPWidgets.appendTitle(this);
			if ( $('p.widget-error', this).length )
				$('a.widget-action', this).click();
		});

		$('#widget-list').children('.widget').draggable({
			connectToSortable: 'div.widgets-sortables',
			handle: '> .widget-top > .widget-title',
			distance: 2,
			helper: 'clone',
			zIndex: 5,
			containment: 'document',
			start: function(e,ui) {
				wpPWidgets.fixWebkit(1);
				ui.helper.find('div.widget-description').hide();
				the_id = this.id;
			},
			stop: function(e,ui) {
				if ( rem )
					$(rem).hide();
				rem = '';
				wpPWidgets.fixWebkit();
			}
		});

		sidebars.sortable({
			placeholder: 'widget-placeholder',
			items: '> .widget',
			handle: '> .widget-top > .widget-title',
			cursor: 'move',
			distance: 2,
			containment: 'document',
			start: function(e,ui) {
				wpPWidgets.fixWebkit(1);
				ui.item.children('.widget-inside').hide();
				ui.item.css({'marginLeft':'','width':''});
			},
			stop: function(e,ui) {				
				if ( ui.item.hasClass('ui-draggable') && ui.item.data('draggable') ) {
					ui.item.draggable('destroy');					
				}
				
				// Remove style: display=block
				if ( ui.item.hasClass('ui-draggable') ) {
					ui.item.removeAttr('style');
				}
				
				if ( ui.item.hasClass('deleting') ) { // nay roi
					wpPWidgets.save( ui.item, 1, 0, 1 ); // delete widget
					ui.item.remove();
					return;
				}

				var add = ui.item.find('input.add_new').val(),
					n = ui.item.find('input.multi_number').val(),
					//id = ui.item.attr('id'),
					id = the_id,
					sb = $(this).attr('id');
//					console.log(ui.item);
				ui.item.css({'marginLeft':'','width':''});
				wpPWidgets.fixWebkit();
				if ( add ) {
					if ( 'multi' == add ) {
						ui.item.html( ui.item.html().replace(/<[^<>]+>/g, function(m){ return m.replace(/__i__|%i%/g, n); }) );
						ui.item.attr( 'id', id.replace(/__i__|%i%/g, n) );
						n++;
						$('div#' + id).find('input.multi_number').val(n);
					} else if ( 'single' == add ) {
						ui.item.attr( 'id', 'new-' + id );
						rem = 'div#' + id;
					}
					wpPWidgets.save( ui.item, 0, 0, 1 );
					ui.item.find('input.add_new').val('');
					ui.item.find('a.widget-action').click();
					return;
				}
				wpPWidgets.saveOrder(sb);
			},
			receive: function(e,ui) {
				if ( !$(this).is(':visible') )
					$(this).sortable('cancel');
			}
		}).sortable('option', 'connectWith', 'div.widgets-sortables').parent().filter('.closed').children('.widgets-sortables').sortable('disable');

		$('#available-widgets').droppable({
			tolerance: 'pointer',
			accept: function(o){
				return $(o).parent().attr('id') != 'widget-list';
			},
			drop: function(e,ui) {
				ui.draggable.addClass('deleting');
				$('#removing-widget').hide().children('span').html('');
			},
			over: function(e,ui) {
				ui.draggable.addClass('deleting');
				$('div.widget-placeholder').hide();

				if ( ui.draggable.hasClass('ui-sortable-helper') )
					$('#removing-widget').show().children('span')
					.html( ui.draggable.find('div.widget-title').children('h4').html() );
			},
			out: function(e,ui) {
				ui.draggable.removeClass('deleting');
				$('div.widget-placeholder').show();
				$('#removing-widget').hide().children('span').html('');
			}
		});
	},

	saveOrder : function(sb) {
		if ( sb )
			$('#' + sb).closest('div.widgets-holder-wrap').find('img.ajax-feedback').css('visibility', 'visible');
			// WP 3.8
			$('#' + sb).closest('div.widgets-holder-wrap').find('.spinner').css('display', 'inline-block');

		if($('#post_ID').length){
			var a = {
				action: 'pw-widgets-order',
				post_id: $('#post_ID').val(),
				savewidgets: $('#_wpnonce_widgets').val(),
				sidebars: []
			};	
		}
		
		// For search page
		else if ( $('#pw_search_page').length ) {
			var a = {
				action: 'pw-widgets-order',
				search_page: 'yes',
				savewidgets: $('#_wpnonce_widgets').val(),
				sidebars: []
			};
		}
		
		else if($('#tag_ID').length){
			var a = {
				action: 'pw-widgets-order',
				tag_id: $('#tag_ID').val(),
				taxonomy: $('#taxonomy').val(),
				savewidgets: $('#_wpnonce_widgets').val(),
				sidebars: []
			};	
		}

		$('div.widgets-sortables').each( function() {
			a['sidebars[' + $(this).attr('id') + ']'] = $(this).sortable('toArray').join(',');
		});

		$.post( ajaxurl, a, function() {
			$('img.ajax-feedback').css('visibility', 'hidden');
			$('.spinner').css('display', 'none');
		});

		this.resize();
	},

	save : function(widget, del, animate, order) {
		var sb = widget.closest('div.widgets-sortables').attr('id'), data = widget.find('form').serialize(), a;
		if(data == "")
		{
			wgIn = widget.find('.widget-inside');
			htmlInwpIn = wgIn.html();
			wgIn.html('');
			wgIn.append('<form method="post" action="">'+htmlInwpIn+'</form>');
			data = widget.find('form').serialize();
		}
		widget = $(widget);
		$('.ajax-feedback', widget).css('visibility', 'visible');
		$('.spinner', widget).css('display', 'inline-block');
		if($('#post_ID').length){
			a = {
				action: 'pw-save-widget',
				post_id: $('#post_ID').val(),
				savewidgets: $('#_wpnonce_widgets').val(),
				sidebar: sb
			};
		}
		
		// For search page
		else if ( $('#pw_search_page').length ) {
			a = {
				action: 'pw-save-widget',
				search_page: 'yes',
				savewidgets: $('#_wpnonce_widgets').val(),
				sidebar: sb
			};
		} 
		
		// For taxonomy page		
		else if($('#tag_ID').length){
			a = {
				action: 'pw-save-widget',
				tag_id: $('#tag_ID').val(),
				taxonomy: $('#taxonomy').val(),
				savewidgets: $('#_wpnonce_widgets').val(),
				sidebar: sb
			};	
		}

		if ( del )
			a['delete_widget'] = 1;

		data += '&' + $.param(a);

		$.post( ajaxurl, data, function(r){
			var id;

			if ( del ) {
				if ( !$('input.widget_number', widget).val() ) {
					id = $('input.widget-id', widget).val();
					$('#available-widgets').find('input.widget-id').each(function(){
						if ( $(this).val() == id )
							$(this).closest('div.widget').show();
					});
				}

				if ( animate ) {
					order = 0;
					widget.slideUp('fast', function(){
						$(this).remove();
						wpPWidgets.saveOrder();
					});
				} else {
					widget.remove();
					wpPWidgets.resize();
				}
			} else {
				$('.ajax-feedback').css('visibility', 'hidden');
				// WP 3.8
				$('.spinner').css('display', 'none');
				if ( r && r.length > 2 ) {
					$('div.widget-content', widget).html(r);
					wpPWidgets.appendTitle(widget);
					wpPWidgets.fixLabels(widget);
				}
			}
			if ( order )
				wpPWidgets.saveOrder();
		});
	},

	appendTitle : function(widget) {
		var title = $('input[id*="-title"]', widget);
		if ( title = title.val() ) {
			title = title.replace(/<[^<>]+>/g, '').replace(/</g, '&lt;').replace(/>/g, '&gt;');
			$(widget).children('.widget-top').children('.widget-title').children()
				.children('.in-widget-title').html(': ' + title);
		}
	},

	resize : function() {
		$('div.widgets-sortables').not('#wp_inactive_widgets').each(function(){
			var h = 50, H = $(this).children('.widget').length;
			h = h + parseInt(H * 48, 10);
			//$(this).css( 'minHeight', h + 'px' );
		});
	},

    fixWebkit : function(n) {
        n = n ? 'none' : '';
        $('body').css({
			WebkitUserSelect: n,
			KhtmlUserSelect: n
		});
    },

    fixLabels : function(widget) {
		widget.children('.widget-inside').find('label').each(function(){
			var f = $(this).attr('for');
			if ( f && f == $('input', this).attr('id') )
				$(this).removeAttr('for');
		});
	},

    close : function(widget) {
		widget.children('.widget-inside').slideUp('fast', function(){
			widget.css({'width':'','marginLeft':''});
		});
	}
};

$(document).ready(function($){
	/*if($("#addtag").length){
		var taxonomyAdd = $("input[name='taxonomy']", "#addtag").val();
		var data = { action: 'pw-get-taxonomy-widget', taxonomy: taxonomyAdd };
		$.ajax({
			url: ajaxurl,
			data: data,
			async: false,
			type: "POST",
			dataType: "html",
			success: function(data) {
				$(data).insertBefore("#addtag .submit");
			}
		});
	}*/
	wpPWidgets.init();

	$('.pw-toggle-customize').click(function(e) {
		if ( adminpage == 'post-new-php' ) return true;

		var t = this;
		if($('#post_ID').length){
			var post_id = $('#post_ID').val();
	
			$.post(ajaxurl, {action: 'pw-toggle-customize', post_id: post_id, 'pw-customize-sidebars': $(t).val()}, function() {
				
			});
		}
		
		// For search page
		else if ( $('#pw_search_page').length ) {
			$.post(ajaxurl, {action: 'pw-toggle-customize', search_page: 'yes', 'pw-customize-sidebars': $(t).val()}, function() {});
			
		} 
		
		// For taxonomy page
		else{
			var tag_id = $('#tag_ID').val();
			var taxonomy = $('#taxonomy').val();
	
			$.post(ajaxurl, {action: 'pw-toggle-customize', tag_id: tag_id, taxonomy: taxonomy, 'pw-customize-sidebars': $(t).val()}, function() {
				
			});	
		}

		return true;
	});
	
	if($("#edittag").length){
		$("#edittag").next().clone().appendTo("#edittag");
		$("#edittag").next().remove();
	}

});

})(jQuery);