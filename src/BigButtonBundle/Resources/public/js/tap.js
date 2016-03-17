$(function(){

	function createCookie(name, value, days) {
	    var expires;

	    if (days) {
	        var date = new Date();
	        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
	        expires = "; expires=" + date.toGMTString();
	    } else {
	        expires = "";
	    }
	    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
	}
	$("#saveuser").click(function(){
		createCookie("ajout","user:"+$("#user").val(),1);
	});


	$("#savetask").click(function(){
		createCookie("ajout","task:"+$("#task").val(),1);
	});

})