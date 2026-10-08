/* theme dashboard + admin notices */
(function ($) {
	'use strict';
	if (typeof sktcomingsoonTI === 'undefined') { return; }

	// Tabs on the theme dashboard page.
	$(document).on('click', '.skt-coming-soon-wrap .tablinks', function () {
		var $btn = $(this), $wrap = $btn.closest('.skt-coming-soon-wrap');
		$wrap.find('.tabcontent').hide().removeClass('open');
		$wrap.find('.tablinks').removeClass('active');
		$wrap.find('#' + $btn.data('tab')).show().addClass('open');
		$btn.addClass('active');
	});

	function dismiss(which) {
		$.post(sktcomingsoonTI.ajaxurl, { action: 'skt_coming_soon_dismiss_notice', notice: which, nonce: sktcomingsoonTI.nonce });
	}

	// Welcome notice: WordPress core adds the "X" button for .is-dismissible.
	$(document).on('click', '.skt-coming-soon-welcome .notice-dismiss', function () {
		dismiss('welcome');
	});

	// Bundle notice.
	$(document).on('click', '.skt-coming-soon-bundle-dismiss', function () {
		$(this).closest('.skt-coming-soon-bundle-notice').fadeOut(200);
		dismiss('bundle');
	});

	// GET STARTED: install + activate SKT Templates, then open the theme dashboard.
	$(document).on('click', '#skt-coming-soon-get-started', function (e) {
		e.preventDefault();
		var $btn = $(this);
		if ($btn.hasClass('is-busy')) { return; }
		$btn.addClass('is-busy').text(sktcomingsoonTI.installing).css('pointer-events', 'none');

		$.post(sktcomingsoonTI.ajaxurl, { action: 'skt_coming_soon_install_companion', nonce: sktcomingsoonTI.nonce })
			.done(function (res) {
				if (res && res.success) {
					$btn.text(sktcomingsoonTI.activated);
					window.location.href = res.data.redirect;
				} else {
					window.alert((res && res.data && res.data.message) || sktcomingsoonTI.failed);
					$btn.removeClass('is-busy').text(sktcomingsoonTI.tryAgain).css('pointer-events', 'auto');
				}
			})
			.fail(function () {
				window.alert(sktcomingsoonTI.failed);
				$btn.removeClass('is-busy').text(sktcomingsoonTI.tryAgain).css('pointer-events', 'auto');
			});
	});
})(jQuery);
