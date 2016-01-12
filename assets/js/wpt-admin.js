// src/admin-addmore.js Handle Multiple Inputs
!function(a){a(".wpt-multiple-input-container").each(function(){function g(){c=b.find(".wpt-muliple-input"),c.length>=e?a(".wpt-muliple-input-add-more").hide():a(".wpt-muliple-input-add-more").show(),c.length>1?c.find(".wpt-multiple-input-remove").show():c.find(".wpt-multiple-input-remove").hide()}var b=a(this),c=b.find(".wpt-muliple-input");Math.min(1,b.data("min-inputs")||1);var e=Math.min(100,b.data("max-inputs")||100),f=c.eq(0).clone();f.find("input,textarea,select").val(""),a(".wpt-muliple-input-add-more").on("click",function(a){a.preventDefault(),f.clone().insertAfter(c.last()),g()}),b.delegate(".wpt-multiple-input-remove","click",function(b){b.preventDefault(),a(this).parents(".wpt-muliple-input").remove(),g()}),g()})}(jQuery);


(function($){

	if(typeof $.fn.wpColorPicker === 'function'){
		$('.wpt-input-colorpicker').each(function(){$(this).wpColorPicker();});
	}
	if(typeof $.fn.datepicker === 'function'){
		$('.wpt-input-datepicker').each(function(){
			var input = $(this);
			var format = input.attr('data-format') || 'yy-mm-dd';
			input.datepicker({dateFormat: format});
		});
	}

})(jQuery);