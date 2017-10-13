/*eslint-disable */

window.addAnswer =()=>{ 
	var type = $("#qType :selected").val();
	var $last = $(".row.answers").last().attr("id")[1];
	$.ajax({
		url: '/questions/add/',
		data: "lastid=" + $last + "&type=" + type,
		method: "POST",
		success: function (result) {
			$(".row.answers").last().after(result);
		}
	});
};

window.removeAnswer =(self)=>{
	$(self).parents().eq(2).remove();
	var  rows = $(".row.answers");
	for (var i=0; i<rows.length; i++){
		$(rows[i]).find("input").val(i+1);
		$(rows[i]).find(".answerId").html(i+1);
		$(rows[i]).attr("id","r"+(i+1));
	}
};

window.toggleAnswer =(self)=>{
	var type = self.options[self.selectedIndex].value;
	var  rows = $(".row.answers");
	for (var i=0; i<rows.length; i++){
		rows[i].remove();
	}
	$.ajax({
		url: '/questions/toggle/',
		data: "type=" + type,
		method: "POST",
		success: function (result) {
			$(".answerLabel").after(result);
		}
	});
};