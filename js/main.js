$(document).ready(function () {

	/*  Show/Hidden Submenus */
	$('.nav-btn-submenu').on('click', function (e) {
		e.preventDefault();
		var SubMenu = $(this).next('ul');
		var iconBtn = $(this).children('.fa-chevron-down');
		if (SubMenu.hasClass('show-nav-lateral-submenu')) {
			$(this).removeClass('active');
			iconBtn.removeClass('fa-rotate-180');
			SubMenu.removeClass('show-nav-lateral-submenu');
		} else {
			$(this).addClass('active');
			iconBtn.addClass('fa-rotate-180');
			SubMenu.addClass('show-nav-lateral-submenu');
		}
	});

	/*  Show/Hidden Nav Lateral */
	$('.show-nav-lateral').on('click', function (e) {
		e.preventDefault();
		var NavLateral = $('.nav-lateral');
		var PageConten = $('.page-content');
		if (NavLateral.hasClass('active')) {
			NavLateral.removeClass('active');
			PageConten.removeClass('active');
		} else {
			NavLateral.addClass('active');
			PageConten.addClass('active');
		}
	});

	/*  Exit system buttom */
	$('.btn-exit-system').on('click', function (e) {
		e.preventDefault();
		swal({
			title: "Está seguro?",
			text: "Realmente desea cerrar la sesión y salir del sistema?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Si",
			cancelButtonText: "No",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function (isConfirm) {
			if (isConfirm) {
				window.location.replace("../controlador/LogOutController.php");
			} else {
				swal("Cancelado", "Su sesión esta activa :)", "info");
			}
		});
	});
});
(function ($) {
	$(window).on("load", function () {
		$(".nav-lateral-content").mCustomScrollbar({
			theme: "light-thin",
			scrollbarPosition: "inside",
			autoHideScrollbar: true,
			scrollButtons: { enable: true }
		});
		$(".page-content").mCustomScrollbar({
			theme: "dark-thin",
			scrollbarPosition: "inside",
			autoHideScrollbar: true,
			scrollButtons: { enable: true }
		});
	});
})(jQuery);