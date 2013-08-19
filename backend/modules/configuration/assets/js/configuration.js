$(function () {
	$(document).on('change', '#configuration-type', function (event) {
		var that = this;
		$.ajax({
			'type':'POST',
			'data': $(that).parents('form').serialize(),
			'beforeSend': function (jqXHR, settings) {$(that).attr('disabled', true);},
			'complete': function (jqXHR, textStatus) {$(that).attr('disabled', false);},
			'success': function(response) {parseResponse(response);},
			'error': function(response) {alert(response.responseText);},
			'url': $(that).data('url'),
			'cache': false,
			'dataType': 'json'
		});
	});
})
