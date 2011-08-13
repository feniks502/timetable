//shows AJAX area
function ajax_area() {
	$("#info").css('display', 'block');
	$(window).scrollTop(0);
}


function info() {
	var i = $(".link").index(this);
	var link = $(".link:eq(" + i + ")");
	link.css('background-color', '#d3d7cf');
	$(".link:not(:eq(" + i + "))").css('background-color', '#eee');
	ajax_area();
	sub_id = URL('id3', $(this).attr('href'));
	$.ajax({
		type: 'POST',
		url: './Info.php',
		data: {
			action: 'load',
			subject_id: sub_id
		},
		success: function (data) {
			$("#info").html(data);
			$("input[type=button]").click(function () {
				$("#info").css('display', 'none');
				link.css('background-color', '#eee');
				$("#info").html(null);
			});
			$("input[type=submit]").click(add_hw)
		}
	});
	return false;
}


function add_hw() {
	$.ajax({
		type: 'POST',
		url: './Info.php',
		data: {
			action: 'add_hw',
			subject_id: sub_id,
			home_work: $("textarea").val()
		},
		success: function (data) {
			if (data == 'true') {
				$("#response").html('<span style="color: green;">Сохранено.</span>');
			} else {
				$("#response").html(data);
			}
		}
	});
}


$(document).ready(function () {

//shows AJAX area
	$(".seminar .link, .lecture .link, .elective .link").click(info);
});
