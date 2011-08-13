function URL(name, href) {
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec(href ? href : window.location.href );

	if( results == null ) {
		return false;
	} else {
		return results[1];
	}
}