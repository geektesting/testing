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
	$(self).parents().eq(2).remove();
};
