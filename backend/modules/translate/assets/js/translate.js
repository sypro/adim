$(function() {
	function loadLanguage () {
		var val_code = $('#language_code_select').val();
		var val_id = $('#language_id_select').val();
		var url = '/translate/message/message';
		if (val_code && val_id) {
			var data = {language: val_code, id: val_id};
			$.ajax({'cache': false, 'type': 'POST', 'dataType': 'text', 'data':data, 'success': function (response) {
				$('#language_translate_text').val(response);
				$('#language_send_button').attr('disabled', false);
				$('#language_send_button').removeClass('disabled');
			}, 'error': function (response) {
				alert(response.responseText);
			}, 'beforeSend': function() {
				$('#language_send_button').attr('disabled', true);
				$('#language_send_button').addClass('disabled');
			}, 'complete': function() {
			}, 'url': url});
		}
	}
	$(document).on('change', '.language_selects', loadLanguage);
});
