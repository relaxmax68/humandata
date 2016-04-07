$(document).ready(function() {

	$.fn.animateRotate = function(angle, duration, easing, complete) {
	  var args = $.speed(duration, easing, complete);
	  var step = args.step;
	  return this.each(function(i, e) {
		args.complete = $.proxy(args.complete, e);
		args.step = function(now) {
		  $.style(e, 'transform', 'rotate(' + now + 'deg)');
		  if (step) return step.apply(e, arguments);
		};

		$({deg: 0}).animate({deg: angle}, args);
	  });
	};
//affichage de la page de la page de garde
	$("#main-page").css("background-color", "#e74c3c");
	$("#main-page").css("height", "100vh");
	$("#main-page").css("width", "100%");
	$("#main-page").fadeIn();
	$(".maincontent").fadeIn();

// animation de fermeture de la page de garde et envoi vers la page web
	$(".weblink").on("click", function() {
		$(".maincontent").fadeOut();
		$("#main-page").animate({
			width: "25px",
			height: "375px"
		}, function() {
			$(this).animateRotate(90);
		});
		setTimeout(function() {
			$("#main-page").fadeOut();
		}, 2000);
		window.location.replace("/Symfony/web/app.php/accueil");
	});

// animation de fermeture de la page de garde et envoi vers la page app
		$(".applink").on("click", function() {
			$(".maincontent").fadeOut();
			$("#main-page").animate({
				width: "25px",
				height: "375px"
			}, function() {
				$(this).animateRotate(90);
			});
			setTimeout(function() {
				$("#main-page").fadeOut();
			}, 2000);
			window.location.replace("/Symfony/web/app.php/button");
		});

//ouverture de la page web

		setTimeout(function() {
			$("#web-page").animateRotate(0, 0);
			$("#web-page").css("height", "25px");
			$("#web-page").css("width", "375px");
			$("#web-page").fadeIn();
			$("#web-page").animate({
				backgroundColor: "#27ae60"
			}, function() {
				$(this).animate({
					height: "100vh"
				}, function() {
					$(this).animate({
						width: "100%"
					}, function() {
						$(".webcontent").fadeIn(300);
					});
				});
			});
		}, 800);

		//ouverture de la page app

				setTimeout(function() {
					$("#app-page").animateRotate(0, 0);
					$("#app-page").css("height", "25px");
					$("#app-page").css("width", "375px");
					$("#app-page").fadeIn();
					$("#app-page").animate({
						backgroundColor: "#27ae60"
					}, function() {
						$(this).animate({
							height: "100vh"
						}, function() {
							$(this).animate({
								width: "100%"
							}, function() {
								$(".appcontent").fadeIn(300);
							});
						});
					});
				}, 800);


});
