function parseResponse(response)
{
	if(response.replaces instanceof Array)
	{
		for(var i = 0, ilen = response.replaces.length; i < ilen; i++)
		{
			$(response.replaces[i].what).replaceWith(response.replaces[i].data);
		}
	}
	if(response.append instanceof Array)
	{
		for(i = 0, ilen = response.append.length; i < ilen; i++)
		{
			$(response.append[i].what).append(response.append[i].data);
		}
	}
	if(response.js)
	{
		$("body").append(response.js);
	}
}
function fixedFormActions(el, elBottom) {
	var windowTop = $(window).scrollTop();
	var windowBottom = windowTop + $(window).height();

	if (windowBottom < elBottom) {
		el.addClass('form-actions-fixed');
	} else {
		el.removeClass('form-actions-fixed');
	}
}
$(function() {
	$(document).on('change', '.do-change-value', function(event) {
		event.preventDefault();
		var that = this;

		var url = $(that).data('url');

		jQuery.ajax({'cache': false, 'type': 'POST', 'dataType': 'json', 'data':{value: 1 * that.checked}, 'success': function (response) {
			parseResponse(response);
		}, 'error': function (response) {
			alert(response.responseText);
		}, 'beforeSend': function() {
			$(that).attr('disabled', true);
		}, 'complete': function() {
			//$(that).attr('disabled', false);
		}, 'url': url});
	});
	$(document).on('click', '.toggle-item', function(event) {
		event.preventDefault();
		var that = this;
		$('#' + $(that).data('id')).toggle();
	});
	$(document).on('change', '.dependent-dropdown', function(event) {
		event.preventDefault();
		var that = this;
		var url = $(that).data('url');
		jQuery.ajax({'cache': false, 'type': 'POST', 'dataType': 'json', 'data': $.extend($(that).data(), {id: that.value}), 'success': function (response) {
			$('.dependent-dropdown').attr('disabled', false);
			parseResponse(response);
		}, 'error': function (response) {
			alert(response.responseText);
		}, 'beforeSend': function() {
			$('.dependent-dropdown').attr('disabled', true);
		}, 'complete': function() {
			//$('.dependent-dropdown').attr('disabled', false);
		}, 'url': url});
	});
	$(document).on('click', 'a.change-item', function (event) {
		event.preventDefault();
		var that = this;
		var value;
		if (value = prompt('Введите значение', '0')) {
			var href = that.href;
			console.log(href);

			jQuery.ajax({'cache': false, 'type': 'POST', 'dataType': 'json', 'data': {value: value}, 'success': function (response) {
				parseResponse(response);
			}, 'error': function (response) {
				alert(response.responseText);
			}, 'beforeSend': function () {
				$(that).attr('disabled', true);
			}, 'complete': function () {
				//$(that).attr('disabled', false);
			}, 'url': href});
		}
		return false;
	});
	$(document).on('click', '.ajax-link', function (event) {
		event.preventDefault();
		var that = this;
		if($(that).data('confirm') && !confirm($(that).data('confirm'))) {
			return false;
		}
		jQuery.ajax({'cache': false, 'type': 'POST', 'dataType': 'json', 'data':$(that).data('params'), 'success': function (response) {
			parseResponse(response);
		}, 'error': function (response) {
			alert(response.responseText);
		}, 'beforeSend': function() {

		}, 'complete': function() {

		}, 'url': that.href});
		return false;
	});

	var formActions = $('.form-actions');
	if(formActions.length > 0) {
		var elTop = formActions.offset().top;
		var elBottom = elTop + formActions.height() + 4;

		$(window).scroll(function () {
			fixedFormActions(formActions, elBottom);
		});

		fixedFormActions(formActions, elBottom);
	}
});
