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
			$("input[name=sg]").click(function () {
				$(".h").slideToggle();
			});
			$("form[name=add_subject]").submit(function () {
				var bth1 = $("input[name=bth1]").val();
				var btm1 = $("input[name=btm1]").val();
				if (bth1 !== '00' && bth1 !== '01' && bth1 !== '02' && bth1 !== '03' && bth1 !== '04'
					&&
				    bth1 !== '05' && bth1 !== '06' && bth1 !== '07' && bth1 !== '08' && bth1 !== '09') {
					bth1 = bth1 * 1;
					if (bth1 < 10) {
						bth1 = null;
					}
				}
				if (btm1 !== '00' && btm1 !== '01' && btm1 !== '02' && btm1 !== '03' && btm1 !== '04'
					&&
				    btm1 !== '05' && btm1 !== '06' && btm1 !== '07' && btm1 !== '08' && btm1 !== '09') {
					btm1 = btm1 * 1;
					if (btm1 < 10) {
						btm1 = null;
					}
				}
				if (bth1 && btm1) {
					var bt1 = bth1 + ':' + btm1;
				} else {
					var bt1 = null;
				}

				var eth1 = $("input[name=eth1]").val();
				var etm1 = $("input[name=etm1]").val();
				if (eth1 !== '00' && eth1 !== '01' && eth1 !== '02' && eth1 !== '03' && eth1 !== '04'
					&&
				    eth1 !== '05' && eth1 !== '06' && eth1 !== '07' && eth1 !== '08' && eth1 !== '09') {
					eth1 = eth1 * 1;
					if (eth1 < 10) {
						eth1 = null;
					}
				}
				if (etm1 !== '00' && etm1 !== '01' && etm1 !== '02' && etm1 !== '03' && etm1 !== '04'
					&&
				    etm1 !== '05' && etm1 !== '06' && etm1 !== '07' && etm1 !== '08' && etm1 !== '09') {
					etm1 = etm1 * 1;
					if (etm1 < 10) {
						etm1 = null;
					}
				}
				if (eth1 && etm1) {
					var et1 = eth1 + ':' + etm1;
				} else {
					var et1 = null;
				}

				if ($("input[name=sg]").is(':checked')) {
					var bth2 = $("input[name=bth2]").val();
					var btm2 = $("input[name=btm2]").val();
					if (bth2 !== '00' && bth2 !== '02' && bth2 !== '02' && bth2 !== '03' && bth2 !== '04'
						&&
					    bth2 !== '05' && bth2 !== '06' && bth2 !== '07' && bth2 !== '08' && bth2 !== '09') {
						bth2 = bth2 * 1;
						if (bth2 < 10) {
							bth2 = null;
						}
					}
					if (btm2 !== '00' && btm2 !== '02' && btm2 !== '02' && btm2 !== '03' && btm2 !== '04'
						&&
					    btm2 !== '05' && btm2 !== '06' && btm2 !== '07' && btm2 !== '08' && btm2 !== '09') {
						btm2 = btm2 * 1;
						if (btm2 < 10) {
							btm2 = null;
						}
					}
					if (bth2 && btm2) {
						var bt2 = bth2 + ':' + btm2;
					} else {
						var bt2 = null;
					}

					var eth2 = $("input[name=eth2]").val();
					var etm2 = $("input[name=etm2]").val();
					if (eth2 !== '00' && eth2 !== '02' && eth2 !== '02' && eth2 !== '03' && eth2 !== '04'
						&&
					    eth2 !== '05' && eth2 !== '06' && eth2 !== '07' && eth2 !== '08' && eth2 !== '09') {
						eth2 = eth2 * 1;
						if (eth2 < 10) {
							eth2 = null;
						}
					}
					if (etm2 !== '00' && etm2 !== '02' && etm2 !== '02' && etm2 !== '03' && etm2 !== '04'
						&&
					    etm2 !== '05' && etm2 !== '06' && etm2 !== '07' && etm2 !== '08' && etm2 !== '09') {
						etm2 = etm2 * 1;
						if (etm2 < 10) {
							etm2 = null;
						}
					}
					if (eth2 && etm2) {
						var et2 = eth2 + ':' + etm2;
					} else {
						var et2 = null;
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
							chk: 1,
							lec1: $("input[name=lec1]").val(),
							lec2: $("input[name=lec2]").val(),
							aud1: $("input[name=aud1]").val(),
							aud2: $("input[name=aud2]").val(),
							bt1: bt1,
							et1: et1,
							bt2: bt2,
							et2: et2
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
				} else {
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
							lec1: $("input[name=lec1]").val(),
							aud1: $("input[name=aud1]").val(),
							bt1: bt1,
							et1: et1
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
				}
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
					var bth1 = $("input[name=bth1]").val();
					var btm1 = $("input[name=btm1]").val();
					if (bth1 !== '00' && bth1 !== '01' && bth1 !== '02' && bth1 !== '03' && bth1 !== '04'
						&&
					    bth1 !== '05' && bth1 !== '06' && bth1 !== '07' && bth1 !== '08' && bth1 !== '09') {
						bth1 = bth1 * 1;
						if (bth1 < 10) {
							bth1 = null;
						}
					}
					if (btm1 !== '00' && btm1 !== '01' && btm1 !== '02' && btm1 !== '03' && btm1 !== '04'
						&&
					    btm1 !== '05' && btm1 !== '06' && btm1 !== '07' && btm1 !== '08' && btm1 !== '09') {
						btm1 = btm1 * 1;
						if (btm1 < 10) {
							btm1 = null;
						}
					}
					if (bth1 && btm1) {
						var bt1 = bth1 + ':' + btm1;
					} else {
						var bt1 = null;
					}

					var eth1 = $("input[name=eth1]").val();
					var etm1 = $("input[name=eth1]").val();
					if (eth1 !== '00' && eth1 !== '01' && eth1 !== '02' && eth1 !== '03' && eth1 !== '04'
						&&
					    eth1 !== '05' && eth1 !== '06' && eth1 !== '07' && eth1 !== '08' && eth1 !== '09') {
						eth1 = eth1 * 1;
						if (eth1 < 10) {
							eth1 = null;
						}
					}
					if (etm1 !== '00' && etm1 !== '01' && etm1 !== '02' && etm1 !== '03' && etm1 !== '04'
						&&
					    etm1 !== '05' && etm1 !== '06' && etm1 !== '07' && etm1 !== '08' && etm1 !== '09') {
						etm1 = etm1 * 1;
						if (etm1 < 10) {
							etm1 = null;
						}
					}
					if (eth1 && etm1) {
						var et1 = eth1 + ':' + etm1;
					} else {
						var et1 = null;
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
							lec1: $("input[name=lec1]").val(),
							aud1: $("input[name=aud1]").val(),
							bt1: bt1,
							et1: et1
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