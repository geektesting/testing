import $ from 'jquery';

/*eslint-disable */
window.addSelector = () => {
	$.ajax({
		url: '/quizes/add/',
		success: function (data) {
			$('#rightTab .row').last().after(data);
		}
	});
};

window.removeSelector = (self) => {
	$(self.parentNode.parentNode.parentNode).remove();
};
