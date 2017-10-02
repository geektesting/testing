import $ from '../../node_modules/jquery/';

/*eslint-disable */
function addSelector (){
	$.ajax({
		url: "/quizes/add/",
		success: function (data) {
			$("#rightTab .row").last().after(data);
		}
	});
}

function removeSelector (self){
	$(self.parentNode.parentNode.parentNode).remove();	
}