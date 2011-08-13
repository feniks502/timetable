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
	$(".seminar a").append('<small>(Семинар)</small>');
	$(".lecture a").append('<small>(Лекция)</small>');
	$(".elective a").append('<small>(Факультатив)</small>');
	$(".odd a").append('<small style="color: #999; float: right;">(нечет.)</small><div style="clear: both;"></div>');
	$(".even a").append('<small style="color: #999; float: right;">(чет.)</small><div style="clear: both;"></div>');
}


function slide_menu() {
	i = $(".header").index(this);

	$(".items:eq(" + i + ")").slideDown(200);
	$(".items:not(:eq(" + i + "))").slideUp(300);
}


$(document).ready(function () {
	border_remove();
	subject_type();
	$(".header").click(slide_menu);
});