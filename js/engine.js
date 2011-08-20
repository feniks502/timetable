function border_remove() {
	$(".simple:not(.elective)").next(".simple:not(.elective)").css('border-top', 'none');

	$(".odd").next(".even").css({
		'border-top' : 'none',
		'margin-top' : '0px'
	});
	$(".even").prev(".odd").css({
		'border-bottom' : '#afafaf dashed 1px',
		'margin-bottom' : '0px'
	});

	$(".even").next(".odd").css({
		'border-top' : 'none',
		'margin-top' : '0px'
	});
	$(".odd").prev(".even").css({
		'border-bottom' : '#afafaf dashed 1px',
		'margin-bottom' : '0px'
	});
}


function subject_type() {
	$(".seminar .link").append('<small>(Семинар)</small>');
	$(".lecture .link").append('<small>(Лекция)</small>');
	$(".elective .link").append('<small>(Факультатив)</small>');
	$(".odd .link").append('<small style="color: #999; float: right;">(нечет.)</small><div style="clear: both;"></div>');
	$(".even .link").append('<small style="color: #999; float: right;">(чет.)</small><div style="clear: both;"></div>');
}


function pos() {
	$(".info_msg").each(function () {
		$(this).data('top', $(this).offset().top);
		$(this).data('left', $(this).offset().left);
		$(this).data('right', $(this).offset().left + $(this).outerWidth());
	});
}


function slide_menu() {
	var i = $(".header").index(this);

	var o = $(".items:eq(" + i + ")");
	var c = $(".items:not(:eq(" + i + "))");

	o.slideDown(200, function () {
		if (!o.data('top')) {
			o.data('top', o.offset().top + o.height());
			o.data('left', o.offset().left);
			o.data('right', o.offset().left + o.outerWidth());
		}

		$(".info_msg").each(function () {
			if (o.data('top') >= $(this).data('top')
					&& ((
				o.data('left') >= $(this).data('left')
					&&
				o.data('left') <= $(this).data('right')
					) || (
				o.data('right') >= $(this).data('left')
					&&
				o.data('right') <= $(this).data('right')
					))
				) {
				$(this).fadeOut(200);
			} else {
				$(this).fadeIn(300);
			}
		});
	});
	c.slideUp(300);
}


function scrollShow() {
	if ($(".column").length > 5) {
		pos_l = 0;
		pos_r = 4;
		$("#wrap").after('<div id="scrollLeft">«</div><div id="scrollRight">»</div>');
	}
}


function scrollRight() {
	if (pos_l >= 0 && pos_r != ($(".column").length - 1)) {
		var w = document.width / 100 * 20;
		$("#wrap").animate({'margin-left' : "-=20%"}, 500);
		$("#scrollLeft").fadeIn();
		pos_l++;
		pos_r++;
	}
	if (pos_r == $(".column").length -1) {
		$("#scrollRight").fadeOut();
	}
}


function scrollLeft() {
	if (pos_l > 0) {
		$("#wrap").animate({'margin-left' : "+=20%"}, 500);
		$("#scrollRight").fadeIn();
		pos_l--;
		pos_r--;
	}
	if (pos_l == 0) {
		$("#scrollLeft").fadeOut();
	}
}


$(document).ready(function () {
	border_remove();
	subject_type();
	scrollShow();
	pos();
	$(".header").mouseenter(slide_menu);
	$(".header").click(slide_menu);
	$("#scrollLeft").click(scrollLeft);
	$("#scrollRight").click(scrollRight);
});