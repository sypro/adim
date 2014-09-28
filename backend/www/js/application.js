function parseResponse(response)
{
	if (response.error) {
		showError(response.error);
	}
	if (response.refresh) {
		window.location.reload(true);
	}
	if (response.redirect) {
		window.location.href = response.redirect;
	}
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
	jsFunctionsAssign();
}
function jsFunctionsAssign()
{

}
function showError(error)
{
	alert(error);
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
// yii submit form
function submitForm (element, url, params) {
	var f = $(element).parents('form')[0];
	if (!f) {
		f = document.createElement('form');
		f.style.display = 'none';
		element.parentNode.appendChild(f);
		f.method = 'POST';
	}
	if (typeof url == 'string' && url != '') {
		f.action = url;
	}
	if (element.target != null) {
		f.target = element.target;
	}

	var inputs = [];
	$.each(params, function(name, value) {
		var input = document.createElement("input");
		input.setAttribute("type", "hidden");
		input.setAttribute("name", name);
		input.setAttribute("value", value);
		f.appendChild(input);
		inputs.push(input);
	});

	// remember who triggers the form submission
	// this is used by jquery.yiiactiveform.js
	$(f).data('submitObject', $(element));

	$(f).trigger('submit');

	$.each(inputs, function() {
		f.removeChild(this);
	});
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
	$(document).on('submit', 'form.ajax-form', function (event) {
		event.preventDefault();
		var that = this;
		jQuery.ajax({'cache': false, 'type': 'POST', 'dataType': 'json', 'data':$(that).serialize(), 'success': function (response) {
			parseResponse(response);
		}, 'error': function (response) {
			alert(response.responseText);
		}, 'beforeSend': function() {

		}, 'complete': function() {

		}, 'url': this.action});
		return false;
	});
	$(document).on('click', 'a.submit-form-link', function (event) {
		var that = this;
		if(!$(that).data('confirm') || confirm($(that).data('confirm'))) {
			submitForm(
				that,
				that.href,
				$(that).data('params')
			);
			return false;
		} else {
			return false;
		}
	});
	$(document).on('click', 'a.ajax-link', function (event) {
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
