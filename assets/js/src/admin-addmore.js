(function($){
	
	$('.wpt-multiple-input-container').each(function(){
		var $multiContainer = $(this);
		var $inputs = $multiContainer.find('.wpt-muliple-input');
		var minInputs = Math.min(1, ($multiContainer.data('min-inputs') || 1));
		var maxInputs = Math.min(100, ($multiContainer.data('max-inputs') || 100));
		var $template = $inputs.eq(0).clone().find('input,textarea,select').val('');
		
		function wptReloadItems(){
			$inputs = $multiContainer.find('.wpt-muliple-input');
			if($inputs.length >= maxInputs){
				$('.wpt-muliple-input-add-more').hide();
			}
			else {
				$('.wpt-muliple-input-add-more').show();
			}
		}
		
		$('.wpt-muliple-input-add-more').on('click', function(ev){
			ev.preventDefault();
			$template.clone().appendTo($multiContainer);
			wptReloadItems();
		});
		
		$multiContainer.delegate('click', '.wpt-multiple-input-remove', function(ev){
			ev.preventDefault();
			$(this).parents('.wpt-muliple-input').remove();
			wptReloadItems();
		});
		
		wptReloadItems();
	});
	
})(jQuery);