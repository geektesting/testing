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

window.settings =()=>{
	
		render.count = 1;	
		settings.questions = [];
		settings.radio = 0;
		settings.checkbox = [];
		settings.qNumbers = 0;
		
		$(function () {
			var qId = $("#qId").val();
			$.ajax({
				url: '/quiz/questions/',
				async: false,
				data: "quizId=" + qId,
				dataType: 'json',
				method: "POST",
				success: function (result) {
				settings.questions = result;
				settings.qNumbers = settings.questions.length;
				settings.questions.push({id: "0"});
				}
			});
		});
	}

window.next =()=>{
		$(function () {
		
				switch( $("#qType").val() ){
				case  "1":
					settings.radio = $("input:checked").val();
					break;
				case "2":
					var checkboxes = $(":checkbox:checked");
					for (var i=0; i < checkboxes.length; i++){
						settings.checkbox[i] = checkboxes[i].value;
					}
				}
				
				var id = settings.questions.shift().id; 
				if(id != 0) {
					$("#qNumber").html("<strong>Вопрос " + render.count +"</strong><hr>");
				}
				else {
					$("#qNumber").html("<strong>Ваш результат</strong><hr>");
					$("#button").remove();
				}
				
				render(id);
			});
		}
		
window.render =(id)=>{
		render.count++;
		var qType = 0;
		if (render.count != 2) { 
			qType = $("#qType").val();
		}
		$.ajax({
			url: '/quiz/render/',
			data: "next=" + id + "&qType=" + qType + "&radio=" + settings.radio + "&checkbox=" + JSON.stringify(settings.checkbox),
			dataType: 'json',
			method: "POST",
			success: function (result) {
				if (id != "0"){
					$("#description").html(result);
				}
				else {
					$("#description").html(result + " из " + settings.qNumbers + " вопросов");
				}
			},
			error: function(result){
			console.dir(result);
			}
		});
	}
	
settings();
next();