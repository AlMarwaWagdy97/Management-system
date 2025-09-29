$(function () {

	"use strict";
	// new PerfectScrollbar(".app-container"),
	// new PerfectScrollbar(".header-message-list"),
	// new PerfectScrollbar(".header-notifications-list"),
	let headerColorVal = "";
	let sideColorVal = "";
	let modeVal = "";
	let url = window.location.origin + '/admin/';

	$(".mobile-search-icon").on("click", function () {
		$(".search-bar").addClass("full-search-bar")
	}),

		$(".search-close").on("click", function () {
			$(".search-bar").removeClass("full-search-bar")
		}),

		$(".mobile-toggle-menu").on("click", function () {
			$(".wrapper").addClass("toggled")
		}),




		$(".dark-mode").on("click", function () {

			if ($(".dark-mode-icon i").attr("class") == 'bx bx-sun') {
				$(".dark-mode-icon i").attr("class", "bx bx-moon");
				$("html").attr("class", "light-theme");
				$.ajax({
					url: url + 'switch-dark-mode',
					type: 'GET',
					data: {
						'mode': "light-theme",
					},
					success: function (result) {
					}
				});
			} else {
				$(".dark-mode-icon i").attr("class", "bx bx-sun");
				$("html").attr("class", "dark-theme");
				$.ajax({
					url: url + 'switch-dark-mode',
					type: 'GET',
					data: {
						'mode': "dark-theme",
					},
					success: function (result) {
					}
				});
			}

		}),


		$(".toggle-icon").click(function () {
			$(".wrapper").hasClass("toggled") ? ($(".wrapper").removeClass("toggled"), $(".sidebar-wrapper").unbind("hover")) : ($(".wrapper").addClass("toggled"), $(".sidebar-wrapper").hover(function () {
				$(".wrapper").addClass("sidebar-hovered")
			}, function () {
				$(".wrapper").removeClass("sidebar-hovered")
			}))
		}),
		$(document).ready(function () {
			$(window).on("scroll", function () {
				$(this).scrollTop() > 300 ? $(".back-to-top").fadeIn() : $(".back-to-top").fadeOut()
			}), $(".back-to-top").on("click", function () {
				return $("html, body").animate({
					scrollTop: 0
				}, 600), !1
			})
		}),

		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		}),

		$(function () {
			for (var e = window.location, o = $(".metismenu li a").filter(function () {
				return this.href == e
			}).addClass("").parent().addClass("mm-active"); o.is("li");) o = o.parent("").addClass("mm-show").parent("").addClass("mm-active")
		}),


		$(function () {
			$("#menu").metisMenu()
		}),

		$(".chat-toggle-btn").on("click", function () {
			$(".chat-wrapper").toggleClass("chat-toggled")
		}), $(".chat-toggle-btn-mobile").on("click", function () {
			$(".chat-wrapper").removeClass("chat-toggled")
		}),


		$(".email-toggle-btn").on("click", function () {
			$(".email-wrapper").toggleClass("email-toggled")
		}), $(".email-toggle-btn-mobile").on("click", function () {
			$(".email-wrapper").removeClass("email-toggled")
		}), $(".compose-mail-btn").on("click", function () {
			$(".compose-mail-popup").show()
		}), $(".compose-mail-close").on("click", function () {
			$(".compose-mail-popup").hide()
		}),

		$(".switcher-btn").on("click", function () {
			$(".switcher-wrapper").toggleClass("switcher-toggled")
		}), $(".close-switcher").on("click", function () {
			$(".switcher-wrapper").removeClass("switcher-toggled")
		}),
		$("#lightmode").on("click", function () {
			$("html").attr("class", "light-theme");
			modeVal = "light-theme"; changeMode();
		}), $("#darkmode").on("click", function () {
			$("html").attr("class", "dark-theme");
			modeVal = "dark-theme"; changeMode();
		}), $("#semidark").on("click", function () {
			$("html").attr("class", "semi-dark");
			modeVal = "semi-dark"; changeMode();
		}), $("#minimaltheme").on("click", function () {
			$("html").attr("class", "minimal-theme")
		}), $("#headercolor1").on("click", function () {
			headerColorVal = "color-header headercolor1"; changeheaderColor();
			$("html").addClass("color-header headercolor1"), $("html").removeClass("headercolor2 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8");
		}), $("#headercolor2").on("click", function () {
			headerColorVal = "color-header headercolor2"; changeheaderColor();
			$("html").addClass("color-header headercolor2"), $("html").removeClass("headercolor1 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8")
		}), $("#headercolor3").on("click", function () {
			headerColorVal = "color-header headercolor3"; changeheaderColor();
			$("html").addClass("color-header headercolor3"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8")
		}), $("#headercolor4").on("click", function () {
			headerColorVal = "color-header headercolor4"; changeheaderColor();
			$("html").addClass("color-header headercolor4"), $("html").removeClass("headercolor1 headercolor2 headercolor3 headercolor5 headercolor6 headercolor7 headercolor8")
		}), $("#headercolor5").on("click", function () {
			headerColorVal = "color-header headercolor5"; changeheaderColor();
			$("html").addClass("color-header headercolor5"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor3 headercolor6 headercolor7 headercolor8")
		}), $("#headercolor6").on("click", function () {
			headerColorVal = "color-header headercolor6"; changeheaderColor();
			$("html").addClass("color-header headercolor6"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor3 headercolor7 headercolor8")
		}), $("#headercolor7").on("click", function () {
			headerColorVal = "color-header headercolor7"; changeheaderColor();
			$("html").addClass("color-header headercolor7"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor3 headercolor8")
		}), $("#headercolor8").on("click", function () {
			headerColorVal = "color-header headercolor8"; changeheaderColor();
			$("html").addClass("color-header headercolor8"), $("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor3")
		}), $("#reset-headercolor").on("click", function () {
			headerColorVal = "reset"; changeheaderColor();
			$("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor3 headercolor8")
		})

	function changeheaderColor() {
		$.ajax({
			url: url + "update-color-header",
			type: 'GET',
			data: {
				'color': headerColorVal,
			},
			success: function (result) {
			}
		});
	}

	function changeMode() {
		$.ajax({
			url: url + "switch-dark-mode",
			type: 'GET',
			data: {
				'mode': modeVal,
			},
			success: function (result) {
			}
		});
	}


	// sidebar colors 
	$('#sidebarcolor1').click(theme1);
	$('#sidebarcolor2').click(theme2);
	$('#sidebarcolor3').click(theme3);
	$('#sidebarcolor4').click(theme4);
	$('#sidebarcolor5').click(theme5);
	$('#sidebarcolor6').click(theme6);
	$('#sidebarcolor7').click(theme7);
	$('#sidebarcolor8').click(theme8);
	$('#reset-sidercolor').click(function () {
		sideColorVal = "reset";
		$('html').attr('class', '');
		changeSideColor();
	});

	function theme1() {
		$('html').attr('class', 'color-sidebar sidebarcolor1');
		sideColorVal = 'color-sidebar sidebarcolor1'; changeSideColor();
	}

	function theme2() {
		$('html').attr('class', 'color-sidebar sidebarcolor2');
		sideColorVal = 'color-sidebar sidebarcolor2'; changeSideColor();
	}

	function theme3() {
		$('html').attr('class', 'color-sidebar sidebarcolor3');
		sideColorVal = 'color-sidebar sidebarcolor3'; changeSideColor();
	}

	function theme4() {
		$('html').attr('class', 'color-sidebar sidebarcolor4');
		sideColorVal = 'color-sidebar sidebarcolor4'; changeSideColor();
	}

	function theme5() {
		$('html').attr('class', 'color-sidebar sidebarcolor5');
		sideColorVal = 'color-sidebar sidebarcolor5'; changeSideColor();
	}

	function theme6() {
		$('html').attr('class', 'color-sidebar sidebarcolor6');
		sideColorVal = 'color-sidebar sidebarcolor6'; changeSideColor();
	}

	function theme7() {
		$('html').attr('class', 'color-sidebar sidebarcolor7');
		sideColorVal = 'color-sidebar sidebarcolor7'; changeSideColor();
	}

	function theme8() {
		$('html').attr('class', 'color-sidebar sidebarcolor8');
		sideColorVal = 'color-sidebar sidebarcolor8'; changeSideColor();
	}
	// reset-sidercolor

	function changeSideColor() {
		$.ajax({
			url: url + "update-color-side",
			type: 'GET',
			data: {
				'color': sideColorVal,
			},
			success: function (result) {
			}
		});
	}


});




