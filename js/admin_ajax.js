function ajax_area() {
	$("body").append('<div id="shadow"></div><div id="info"></div>')
	$("#shadow").fadeTo(400, 0.6);
	$("#info").fadeIn(400);



	$("#shadow").click(function () {
		$("#shadow").remove();
		$("#info").fadeOut();
	});
}


function add_course() {
	ajax_area();
	$.ajax({
		type: 'POST',
		url: './forms.php',
		data: {
			object: 'course',
			action: 'add'
		},
		success: function (data) {
			$("#info").html(data);
			$("form[name=add_course]").submit(function () {
				$.ajax({
					type: 'POST',
					url: './handler.php',
					data: {
						object: 'course',
						action: 'add',
						course_name: $("input[name=course_name]").val()
					},
					success: function (data) {
						if (data == 'true') {
							$("input[name=course_name]").val(null);
							$("#response").html('<span style="color: green; display: none;">Успешно добавлено</span>');
							$("#response span").fadeIn(500);
							$("#response span").fadeOut(1000);
						} else {
							$("#response").html(data);
						}
					}
				});
				return false;
			});
		}
	});
}


function add_group() {
	var id = URL('id', $(this).attr('href'));
	ajax_area();
	$.ajax({
		type: 'POST',
		url: './forms.php',
		data: {
			object: 'group',
			action: 'add'
		},
		success: function (data) {
			$("#info").html(data);
			$("form[name=add_group]").submit(function () {
				$.ajax({
					type: 'POST',
					url: './handler.php',
					data: {
						object: 'group',
						action: 'add',
						course_id: id,
						group_name: $("input[name=group_name]").val()
					},
					success: function (data) {
						if (data == 'true') {
							$("input[name=group_name]").val(null);
							$("#response").html('<span style="color: green; display: none;">Успешно добавлено</span>');
							$("#response span").fadeIn(500);
							$("#response span").fadeOut(1000);
						} else {
							$("#response").html(data);
						}
					}
				});
				return false;
			});
		}
	});
	return false;
}


function add_subject() {
	var id = URL('id');
	var id2 = URL('id2');
	var e = $(this);
	ajax_area();
	$("#info").animate({top: '3%'}, 300);
	$.ajax({
		type: 'POST',
		url: './forms.php',
		data: {
			object: 'subject',
			action: 'add'
		},
		success: function (data) {
			if ($(e).is(".item")) {
				var t = $(e).parent(".items").prev(".header").text();
				$("#info").html(data);
				switch (t) {
					case 'Понедельник':
						$("select[name=day]").val(1);
						break;
					case 'Вторник':
						$("select[name=day]").val(2);
						break;
					case 'Среда':
						$("select[name=day]").val(3);
						break;
					case 'Четверг':
						$("select[name=day]").val(4);
						break;
					case 'Пятница':
						$("select[name=day]").val(5);
						break;
					case 'Суббота':
						$("select[name=day]").val(6);
						break;
					case 'Воскресенье':
						$("select[name=day]").val(7);
						break;
				}
			} else {
				$("#info").html(data);
			}
			$("form[name=add_subject]").submit(function () {
				var bth = $("input[name=bth]").val();
				var btm = $("input[name=btm]").val();
				if (bth !== '00' && bth !== '01' && bth !== '02' && bth !== '03' && bth !== '04'
					&&
				    bth !== '05' && bth !== '06' && bth !== '07' && bth !== '08' && bth !== '09') {
					bth = bth * 1;
					if (bth < 10) {
						bth = null;
					}
				}
				if (btm !== '00' && btm !== '01' && btm !== '02' && btm !== '03' && btm !== '04'
					&&
				    btm !== '05' && btm !== '06' && btm !== '07' && btm !== '08' && btm !== '09') {
					btm = btm * 1;
					if (btm < 10) {
						btm = null;
					}
				}
				if (bth && btm) {
					var begin_time = bth + ':' + btm;
				} else {
					var begin_time = null;
				}

				var eth = $("input[name=eth]").val();
				var etm = $("input[name=etm]").val();
				if (eth !== '00' && eth !== '01' && eth !== '02' && eth !== '03' && eth !== '04'
					&&
				    eth !== '05' && eth !== '06' && eth !== '07' && eth !== '08' && eth !== '09') {
					eth = eth * 1;
					if (eth < 10) {
						eth = null;
					}
				}
				if (etm !== '00' && etm !== '01' && etm !== '02' && etm !== '03' && etm !== '04'
					&&
				    etm !== '05' && etm !== '06' && etm !== '07' && etm !== '08' && etm !== '09') {
					etm = etm * 1;
					if (etm < 10) {
						etm = null;
					}
				}
				if (eth && etm) {
					var end_time = eth + ':' + etm;
				} else {
					var end_time = null;
				}

				$.ajax({
					type: 'POST',
					url: './handler.php',
					data: {
						object: 'subject',
						action: 'add',
						course_id: id,
						group_id: id2,
						day_id: $("select[name=day]").val(),
						subject: $("input[name=subject]").val(),
						type_1: $("select[name=type_1]").val(),
						type_2: $("select[name=type_2]").val(),
						lecturer: $("input[name=lecturer]").val(),
						auditory: $("input[name=auditory]").val(),
						begin_time: begin_time,
						end_time: end_time
					},
					success: function (data) {
						if (data == 'true') {
							$("form select").val(null);
							$("form input").not("[type=submit]").val(null);
							$("#response").html('<span style="color: green; display: none;">Успешно добавлено</span>');
							$("#response span").fadeIn(500);
							$("#response span").fadeOut(1000);
						} else {
							$("#response").html(data);
						}
					}
				});
				return false;
			});
		}
	});
	return false;
}


function edit_item () {
	var href = $(this).attr('href');

	var id = URL('id', href);
	var id2 = URL('id2', href);
	var id3 = URL('id3', href);

	if (id && id2 && id3) {
		ajax_area();
		$("#info").animate({top: '3%'}, 300);
		$.ajax({
			type: 'POST',
			url: './forms.php',
			data: {
				object: 'subject',
				action: 'edit',
				subject_id: id3
			},
			success: function (data) {
				$("#info").html(data);
				$("form[name=edit_subject]").submit(function () {
					var bth = $("input[name=bth]").val();
					var btm = $("input[name=btm]").val();
					if (bth !== '00' && bth !== '01' && bth !== '02' && bth !== '03' && bth !== '04'
						&&
					    bth !== '05' && bth !== '06' && bth !== '07' && bth !== '08' && bth !== '09') {
						bth = bth * 1;
						if (bth < 10) {
							bth = null;
						}
					}
					if (btm !== '00' && btm !== '01' && btm !== '02' && btm !== '03' && btm !== '04'
						&&
					    btm !== '05' && btm !== '06' && btm !== '07' && btm !== '08' && btm !== '09') {
						btm = btm * 1;
						if (btm < 10) {
							btm = null;
						}
					}
					if (bth && btm) {
						var begin_time = bth + ':' + btm;
					} else {
						var begin_time = null;
					}

					var eth = $("input[name=eth]").val();
					var etm = $("input[name=etm]").val();
					if (eth !== '00' && eth !== '01' && eth !== '02' && eth !== '03' && eth !== '04'
						&&
					    eth !== '05' && eth !== '06' && eth !== '07' && eth !== '08' && eth !== '09') {
						eth = eth * 1;
						if (eth < 10) {
							eth = null;
						}
					}
					if (etm !== '00' && etm !== '01' && etm !== '02' && etm !== '03' && etm !== '04'
						&&
					    etm !== '05' && etm !== '06' && etm !== '07' && etm !== '08' && etm !== '09') {
						etm = etm * 1;
						if (etm < 10) {
							etm = null;
						}
					}
					if (eth && etm) {
						var end_time = eth + ':' + etm;
					} else {
						var end_time = null;
					}

					$.ajax({
						type: 'POST',
						url: './handler.php',
						data: {
							object: 'subject',
							action: 'edit',
							subject_id: id3,
							day_id: $("select[name=day]").val(),
							subject: $("input[name=subject]").val(),
							type_1: $("select[name=type_1]").val(),
							type_2: $("select[name=type_2]").val(),
							lecturer: $("input[name=lecturer]").val(),
							auditory: $("input[name=auditory]").val(),
							begin_time: begin_time,
							end_time: end_time
						},
						success: function (data) {
							if (data == 'true') {
								$("#response").html('<span style="color: green; display: none;">Успешно изменено</span>');
								$("#response span").fadeIn(500);
								$("#response span").fadeOut(1000);
							} else {
								$("#response").html(data);
							}
						}
					});
					return false;
				});
			}
		});
	} else if (id && id2) {
		ajax_area();
		$.ajax({
			type: 'POST',
			url: './forms.php',
			data: {
				object: 'group',
				action: 'edit',
				group_id: id2
			},
			success: function (data) {
				$("#info").html(data);
				$("form[name=edit_group]").submit(function () {
					$.ajax({
						type: 'POST',
						url: './handler.php',
						data: {
							object: 'group',
							action: 'edit',
							group_id: id2,
							group_name: $("input[name=group_name]").val()
						},
						success: function (data) {
							if (data == 'true') {
								$("#response").html('<span style="color: green; display: none;">Успешно изменено</span>');
								$("#response span").fadeIn(500);
								$("#response span").fadeOut(1000);
							} else {
								$("#response").html(data);
							}
						}
					});
					return false;
				});
			}
		});
	} else if (id) {
		alert ('В разработке:)');
	} else {
		alert('Wrong parameters:)) Nothing will be done!!! :)');
	}
	return false;
}


function delete_item() {
	var e = $(this);
	var href = $(this).attr('href');

	var id = URL('id', href);
	var id2 = URL('id2', href);
	var id3 = URL('id3', href);

	if (id && id2 && id3) {
		$.ajax({
			type: 'POST',
			url: './handler.php',
			data: {
				object: 'subject',
				action: 'delete',
				subject_id: id3
			},
			success: function (data) {
				if (data == 'true') {
					e.removeAttr('href').text('Удалено').css('color', '#469f45');
					e.prevAll().removeAttr('href').fadeOut(500);
				} else {
					e.html(data);
				}
			}
		});
	} else if (id && id2) {
		$.ajax({
			type: 'POST',
			url: './handler.php',
			data: {
				object: 'group',
				action: 'delete',
				group_id: id2
			},
			success: function (data) {
				if (data == 'true') {
					e.removeAttr('href').text('Удалено').css('color', '#469f45');
					e.prevAll().removeAttr('href').fadeOut(500);
				} else {
					e.html(data);
				}
			}
		});
	} else if (id) {
		alert('В разработке:)');
	} else {
		alert('Wrong parameters:)) Nothing will be done!!! :)');
	}
	return false;
}


function move_up() {
	var x = $(this);

	var pi = $(this).parents(".column").index();
	var xi = $(".column:eq(" + pi + ") .move_up").index(this);
	var yi = xi - 1;

	var y = $(".column:eq(" + pi + ") .move_up:eq(" + yi + ")");

	var xel = $(".column:eq(" + pi + ") .item:eq(" + xi + ")");
	var yel = $(".column:eq(" + pi + ") .item:eq(" + yi + ")");

	var xhref = x.attr('href');
	var yhref = y.attr('href');

	var xid = URL('id', xhref);
	var xid2 = URL('id2', xhref);
	var xid3 = URL('id3', xhref);
	var xid4 = URL('id4', xhref);

	var yid = URL('id', yhref);
	var yid2 = URL('id2', yhref);
	var yid3 = URL('id3', yhref);
	var yid4 = URL('id4', yhref);

	if (xid && xid2 && xid3 && xid4 && yid && yid2 && yid3 && yid4) {
		$.ajax({
			type: 'POST',
			url: './handler.php',
			data: {
				object: 'subject',
				action: 'move',
				xid3: xid3,
				yid3: yid3,
				xid4: xid4,
				yid4: yid4
			},
			success: function (data) {
				if (data == 'true') {
					x.next(".move_down").andSelf().attr('href', './?id=' + xid + '&id2=' + xid2 + '&id3=' + xid3 + '&id4=' + yid4);
					y.next(".move_down").andSelf().attr('href', './?id=' + yid + '&id2=' + yid2 + '&id3=' + yid3 + '&id4=' + xid4);
					$(".column:eq(" + pi + ") .item").removeAttr('style');
					xel.after(yel);
					border_remove();
				} else {
					alert(data);
				}
			}
		});
	} else if (xid && xid2 && xid4 && yid && yid2 && yid4) {
		$.ajax({
			type: 'POST',
			url: './handler.php',
			data: {
				object: 'group',
				action: 'move',
				xid2: xid2,
				yid2: yid2,
				xid4: xid4,
				yid4: yid4
			},
			success: function (data) {
				if (data = 'true') {
					x.next(".move_down").andSelf().attr('href', './?id=' + xid + '&id2=' + xid2 + '&id4=' + yid4);
					y.next(".move_down").andSelf().attr('href', './?id=' + yid + '&id2=' + yid2 + '&id4=' + xid4);
					$(".column:eq(" + pi + ") .item").removeAttr('style');
					xel.after(yel);
					border_remove();
				} else {
					alert(data);
				}
			}
		});
	}
	return false;
}


function move_down() {
	var x = $(this);

	var pi = $(this).parents(".column").index();
	var xi = $(".column:eq(" + pi + ") .move_down").index(this);
	var yi = xi + 1;

	var y = $(".column:eq(" + pi + ") .move_down:eq(" + yi + ")");

	var xel = $(".column:eq(" + pi + ") .item:eq(" + xi + ")");
	var yel = $(".column:eq(" + pi + ") .item:eq(" + yi + ")");
	
	var xhref = x.attr('href');
	var yhref = y.attr('href');
	
	var xid = URL('id', xhref);
	var xid2 = URL('id2', xhref);
	var xid3 = URL('id3', xhref);
	var xid4 = URL('id4', xhref);

	var yid = URL('id', yhref);
	var yid2 = URL('id2', yhref);
	var yid3 = URL('id3', yhref);
	var yid4 = URL('id4', yhref);

	if (xid && xid2 && xid3 && xid4 && yid && yid2 && yid3 && yid4) {
		$.ajax({
			type: 'POST',
			url: './handler.php',
			data: {
				object: 'subject',
				action: 'move',
				xid3: xid3,
				yid3: yid3,
				xid4: xid4,
				yid4: yid4
			},
			success: function (data) {
				if (data == 'true') {
					x.prev(".move_up").andSelf().attr('href', './?id=' + xid + '&id2=' + xid2 + '&id3=' + xid3 + '&id4=' + yid4);
					y.prev(".move_up").andSelf().attr('href', './?id=' + yid + '&id2=' + yid2 + '&id3=' + yid3 + '&id4=' + xid4);
					$(".column:eq(" + pi + ") .item").removeAttr('style');
					xel.before(yel);
					border_remove();
				} else {
					alert(data);
				}
			}
		});
	} else if (xid && xid2 && xid4 && yid && yid2 && yid4) {
		$.ajax({
			type: 'POST',
			url: './handler.php',
			data: {
				object: 'group',
				action: 'move',
				xid2: xid2,
				yid2: yid2,
				xid4: xid4,
				yid4: yid4
			},
			success: function (data) {
				if (data = 'true') {
					x.prev(".move_up").andSelf().attr('href', './?id=' + xid + '&id2=' + xid2 + '&id4=' + yid4);
					y.prev(".move_up").andSelf().attr('href', './?id=' + yid + '&id2=' + yid2 + '&id4=' + xid4);
					$(".column:eq(" + pi + ") .item").removeAttr('style');
					xel.before(yel);
					border_remove();
				} else {
					alert(data);
				}
			}
		});
	}
	return false;
}


function info() {
	ajax_area();
	sub_id = URL('id3', $(this).attr('href'));
	$.ajax({
		type: 'POST',
		url: '../Modules/Info.php',
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
			url: '../Modules/Info.php',
			data: {
				action: 'add_hw',
				subject_id: sub_id,
				home_work: $("textarea").val()
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
	$("#add_course").click(add_course);
	$(".add_group .link").click(add_group);
	$(".add_subject").click(add_subject);
	$(".edit").click(edit_item);
	$(".delete").click(delete_item);
	$(".move_up").click(move_up);
	$(".move_down").click(move_down);
	$(".seminar .link, .lecture .link, .elective .link").click(info);
});