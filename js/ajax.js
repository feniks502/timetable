//shows AJAX area
function ajax_area() {
	$("body").append('<div id="shadow"></div><div id="info"></div>');
	$("#shadow").fadeTo(400, 0.6);
	$("#info").fadeIn(400);



	$("#shadow").click(function () {
		$("#shadow").remove();
		$("#info").fadeOut();
	});
}


function info() {
	ajax_area();
	sub_id = URL('id3', $(this).attr('href'));
	$.ajax({
		type: 'POST',
		url: './Modules/Info.php',
		data: {
			action: 'load',
			subject_id: sub_id
		},
		success: function (data) {
			$("#info").html(data);
			$("textarea").one('keydown', add_hw);
		}
	});
	return false;
}


function add_hw() {
	$("input[type=submit]").fadeIn(1000);
	$("input[type=submit]").click(function () {
		$.ajax({
			type: 'POST',
			url: './Modules/Info.php',
			data: {
				action: 'add_hw',
				subject_id: sub_id,
				hwk: $("textarea").val()
			},
			success: function (data) {
				if (data == 'true') {
					$("#response").html('<span style="color: green; display: none;">Сохранено.</span>');
					$("#response span").fadeIn(500);
					$("#response span").fadeOut(1000);
				} else {
					$("#response").html(data);
				}
			}
		});
	});
}


$(document).ready(function () {

//shows AJAX area
	$(".seminar .link, .lecture .link, .elective .link").click(info);
});
