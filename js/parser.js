$.extend({
	UrlVars: function (){
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1, window.location.href.indexOf('#')).split('&');

		for(var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	},
	getUrlVar: function (name){
		return $.getUrlVars()[name];
	}
});

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