<?php
/**
 * Theme dashboard 
 *
 * @package SKT Coming Soon
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * Point 3 - Top-level menu named after the active theme
 * ---------------------------------------------------------------------- */
function skt_coming_soon_dashboard_menu() {
	$name = skt_coming_soon_theme_name();
	add_menu_page(
		$name,
		$name,
		'manage_options',
		skt_coming_soon_page_slug(),
		'skt_coming_soon_page_display',
		get_template_directory_uri() . '/images/theme-info/menu-icon.svg',
		59
	);
}
add_action( 'admin_menu', 'skt_coming_soon_dashboard_menu' );

/**
 * Styles + scripts for notices, menu and the dashboard page.
 */
function skt_coming_soon_admin_assets() {
	$ver = wp_get_theme( get_template() )->get( 'Version' );

	wp_enqueue_style( 'skt-coming-soon-theme-info', get_template_directory_uri() . '/css/theme-info-admin.css', array(), $ver );

	// Highlight the menu item (its id depends on the active theme slug).
	$id = '#toplevel_page_' . skt_coming_soon_page_slug();
	$css = "#adminmenu li{$id}>a{background:linear-gradient(90deg,#4f43d1 0,#19b7f0 100%) !important;color:#fff !important;}"
	 . "#adminmenu li{$id}>a:hover,#adminmenu li{$id}.current>a,#adminmenu li{$id}>a:focus{background:linear-gradient(90deg,#19b7f0 0,#4f43d1 100%) !important;color:#fff !important;}"
	 . "#adminmenu li{$id} .wp-menu-image img{width:18px;height:18px;opacity:1;padding-top:7px;}";
	wp_add_inline_style( 'skt-coming-soon-theme-info', $css );

	wp_enqueue_script( 'skt-coming-soon-theme-info', get_template_directory_uri() . '/js/theme-info-admin.js', array( 'jquery' ), $ver, true );
	wp_localize_script(
		'skt-coming-soon-theme-info',
		'sktcomingsoonTI',
		array(
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'nonce'      => wp_create_nonce( 'skt_coming_soon_nonce' ),
			'installing' => esc_html__( 'Installing & Activating...', 'skt-coming-soon' ),
			'activated'  => esc_html__( 'Activated', 'skt-coming-soon' ),
			'tryAgain'   => esc_html__( 'Try Again', 'skt-coming-soon' ),
			'failed'     => esc_html__( 'Failed to install or activate the plugin.', 'skt-coming-soon' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'skt_coming_soon_admin_assets' );

/**
 * Free vs Premium comparison rows. Values: true = yes, false = no, string = text.
 */
function skt_coming_soon_feature_rows() {
	return apply_filters(
		'skt_coming_soon_feature_rows',
		array(
			array( __( 'Logo Upload', 'skt-coming-soon' ), true, true ),
			array( __( 'Color Changes', 'skt-coming-soon' ), false, true ),
			array( __( 'Font Family', 'skt-coming-soon' ), false, __( '650 Google Fonts', 'skt-coming-soon' ) ),
			array( __( 'Font Size Options', 'skt-coming-soon' ), false, true ),
			array( __( 'Layout Settings', 'skt-coming-soon' ), false, true ),
			array( __( 'Shortcodes', 'skt-coming-soon' ), false, true ),
			array( __( 'Slider Settings', 'skt-coming-soon' ), false, true ),
			array( __( 'More Widgets', 'skt-coming-soon' ), false, true ),
			array( __( 'Page Templates', 'skt-coming-soon' ), '3', '8' ),
			array( __( 'Better Responsive', 'skt-coming-soon' ), false, true ),
			array( __( 'More Homepage Section', 'skt-coming-soon' ), false, true ),
			array( __( 'Inner Page Header', 'skt-coming-soon' ), false, true ),
			array( __( 'Default Contact Form', 'skt-coming-soon' ), false, true ),
			array( __( 'Default Gallery', 'skt-coming-soon' ), false, true ),
			array( __( 'Blog Layouts', 'skt-coming-soon' ), false, true ),
			array( __( 'Header/Footer Widgets', 'skt-coming-soon' ), false, true ),
			array( __( 'Icons Pack', 'skt-coming-soon' ), false, true ),
			array( __( 'Full Documentation', 'skt-coming-soon' ), false, true ),
			array( __( 'Email/ Support', 'skt-coming-soon' ), false, true ),
		)
	);
}

/* -------------------------------------------------------------------------
 * Point 4 - Dashboard page
 * ---------------------------------------------------------------------- */
function skt_coming_soon_page_display() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$links      = skt_coming_soon_links();
	$theme      = wp_get_theme();
	$theme_name = $theme->get( 'Name' );
	$img        = get_template_directory_uri() . '/images/theme-info/';
	$shot       = get_template_directory_uri() . '/screenshot.png';

	include_once ABSPATH . 'wp-admin/includes/plugin.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
	$companion_active = is_plugin_active( $links['companion_file'] );

	// Premium-only features (free = false) for the Pro box.
	$pro_only = array();
	foreach ( skt_coming_soon_feature_rows() as $row ) {
		if ( false === $row[1] && true === $row[2] ) {
			$pro_only[] = $row[0];
		}
	}
	$pro_only = array_slice( $pro_only, 0, 4 );

	$tabs = array(
		'lite_theme' => array( 'dashicons-admin-home', __( 'Getting Started', 'skt-coming-soon' ) ),
		'get_bundle' => array( 'dashicons-screenoptions', __( 'WordPress Themes Bundle', 'skt-coming-soon' ) ),
	);
	?>
<div class="wrap skt-coming-soon-wrap">
	<h1 class="screen-reader-text"><?php echo esc_html( $theme_name ); ?></h1>

	<!-- Top bar -->
	<header class="pti-topbar">
		<div class="pti-topbar__id">			 
			<div>
				<h2 class="pti-topbar__name"><?php echo esc_html( $theme_name ); ?></h2>
				<span class="pti-badge"><?php
					/* translators: %s: theme version */
					printf( esc_html__( 'v%s', 'skt-coming-soon' ), esc_html( $theme->get( 'Version' ) ) );
				?></span>
			</div>
		</div>
		<nav class="pti-topbar__nav" aria-label="<?php esc_attr_e( 'Quick links', 'skt-coming-soon' ); ?>">
			<a href="<?php echo esc_url( $links['free_doc'] ); ?>" target="_blank" rel="noopener"><span class="dashicons dashicons-book-alt" aria-hidden="true"></span><?php esc_html_e( 'Docs', 'skt-coming-soon' ); ?></a>
			<a href="<?php echo esc_url( $links['support'] ); ?>" target="_blank" rel="noopener"><span class="dashicons dashicons-sos" aria-hidden="true"></span><?php esc_html_e( 'Support', 'skt-coming-soon' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank"><span class="dashicons dashicons-external" aria-hidden="true"></span><?php esc_html_e( 'View site', 'skt-coming-soon' ); ?></a>
			<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="pti-btn pti-btn--primary pti-btn--sm"><?php esc_html_e( 'Customize', 'skt-coming-soon' ); ?></a>
		</nav>
	</header>

	<div class="pti-layout">

		<!-- Left: tabs -->
		<div class="pti-layout__main">
			<!-- Tabbed content -->
			<div class="wrapper-info pti-card">
				<div class="tab-sec">
					<div class="tab pti-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Theme dashboard sections', 'skt-coming-soon' ); ?>">
						<?php $first = true; foreach ( $tabs as $tab_id => $tab ) : ?>
							<button type="button" role="tab" class="tablinks<?php echo $first ? ' active' : ''; ?>" data-tab="<?php echo esc_attr( $tab_id ); ?>" aria-controls="<?php echo esc_attr( $tab_id ); ?>">
								<span class="dashicons <?php echo esc_attr( $tab[0] ); ?>" aria-hidden="true"></span><?php echo esc_html( $tab[1] ); ?>
							</button>
						<?php $first = false; endforeach; ?>
					</div>

					<!-- Getting started -->
					<section id="lite_theme" class="tabcontent open" role="tabpanel">
						<div class="pti-cols">
							<div class="pti-cols__main">
								<h3 class="pti-h"><?php
									/* translators: %s: theme name */
									printf( esc_html__( 'Getting started with %s', 'skt-coming-soon' ), esc_html( $theme_name ) );
								?></h3>
								<p class="pti-prose"><?php
									/* translators: %s: theme name */
									printf( esc_html__( '%s is a next generation multipurpose theme which comes with loads of options. It provides a multilingual and RTL experience and is compatible with WooCommerce, contact form, SEO and page builder plugins like Gutenberg, Elementor, Brizy, Beaver Builder, SiteOrigin and others. It comes with 150+ ready to import templates through the free SKT Templates plugin, which means you have unlimited possibilities to create your next website in any industry such as charity, construction, computer, software, agency, portfolio or business. The theme options in the Customizer let you change colors, typography, header, footer, blog and layout settings without touching code. Simple, flexible, easy to use and fully documented.', 'skt-coming-soon' ), esc_html( $theme_name ) );
								?></p>
							</div>
							<div class="pti-cols__side">
								<h4 class="pti-label"><?php esc_html_e( 'Quick actions', 'skt-coming-soon' ); ?></h4>
								<ul class="pti-steps">
									<li>
										<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" target="_blank">
											<span class="dashicons dashicons-admin-customizer" aria-hidden="true"></span>
											<span><strong><?php esc_html_e( 'Edit your site', 'skt-coming-soon' ); ?></strong><small><?php esc_html_e( 'Colors, typography, header and footer', 'skt-coming-soon' ); ?></small></span>
										</a>
									</li>
									<?php if ( $companion_active ) : ?>
									<li>
										<a href="<?php echo esc_url( admin_url( 'admin.php?page=skt_template_directory' ) ); ?>">
											<span class="dashicons dashicons-download" aria-hidden="true"></span>
											<span><strong><?php esc_html_e( 'Import templates', 'skt-coming-soon' ); ?></strong><small><?php esc_html_e( 'Start from a ready-made design', 'skt-coming-soon' ); ?></small></span>
										</a>
									</li>
									<?php endif; ?>
									<li>
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank">
											<span class="dashicons dashicons-visibility" aria-hidden="true"></span>
											<span><strong><?php esc_html_e( 'Visit your site', 'skt-coming-soon' ); ?></strong><small><?php esc_html_e( 'See how it looks right now', 'skt-coming-soon' ); ?></small></span>
										</a>
									</li>
								</ul>
							</div>
						</div>

						<div class="pti-help">
							<div class="pti-help__item">
								<span class="pti-help__icon dashicons dashicons-sos" aria-hidden="true"></span>
								<h4><?php esc_html_e( 'Need support?', 'skt-coming-soon' ); ?></h4>
								<p><?php esc_html_e( 'Our team is ready to help with any questions about the theme.', 'skt-coming-soon' ); ?></p>
								<a href="<?php echo esc_url( $links['support'] ); ?>" class="pti-link" target="_blank" rel="noopener"><?php esc_html_e( 'Support forum', 'skt-coming-soon' ); ?></a>
							</div>							 
							<div class="pti-help__item">
								<span class="pti-help__icon dashicons dashicons-book-alt" aria-hidden="true"></span>
								<h4><?php esc_html_e( 'Documentation', 'skt-coming-soon' ); ?></h4>
								<p><?php esc_html_e( 'Step-by-step guides for setting up and configuring the theme.', 'skt-coming-soon' ); ?></p>
								<a href="<?php echo esc_url( $links['free_doc'] ); ?>" class="pti-link" target="_blank" rel="noopener"><?php esc_html_e( 'Read the docs', 'skt-coming-soon' ); ?></a>
							</div>
						</div>
					</section>
					<!-- Bundle -->
					<section id="get_bundle" class="tabcontent" role="tabpanel">
						<div class="pti-cols">
							<div class="pti-cols__main">
								<h3 class="pti-h"><?php esc_html_e( 'WordPress Themes Bundle', 'skt-coming-soon' ); ?></h3>
								<p class="pti-prose"><?php
									/* translators: %s: number of themes */
									printf( esc_html__( 'Enhance your website effortlessly with our WordPress Themes Bundle. Get access to %s premium WordPress themes, all designed to meet diverse business needs. Enjoy seamless integration with popular plugins, ultimate customization flexibility, and regular updates to keep your site current and secure. Plus, benefit from our dedicated customer support, ensuring a smooth and professional web experience.', 'skt-coming-soon' ), esc_html( $links['theme_count'] ) );
								?></p>
								<div class="pti-actions">
									<a href="<?php echo esc_url( $links['bundle_buy'] ); ?>" target="_blank" rel="noopener" class="pti-btn pti-btn--primary"><?php
										/* translators: %s: price */
										printf( esc_html__( 'Get the bundle for %s', 'skt-coming-soon' ), esc_html( $links['bundle_price'] ) );
									?></a>									 
								</div>
							</div>
							<div class="pti-cols__side">
								<div class="pti-shot pti-scroll" style="background-image:url('<?php echo esc_url( $img . 'bundle-preview.jpg' ); ?>');" role="img" aria-label="<?php esc_attr_e( 'WordPress Themes Bundle preview', 'skt-coming-soon' ); ?>"></div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>

		<!-- Right: bundle + pro -->
		<aside class="pti-layout__side">
            <!-- WordPress Themes Bundle -->
            <section class="pti-hero" aria-labelledby="pti-hero-title">
				<div class="pti-hero__content">
					<span class="pti-hero__pill"><?php
						/* translators: %s: number of themes */
						printf( esc_html__( '%s premium themes', 'skt-coming-soon' ), esc_html( $links['theme_count'] ) );
					?></span>
					<h2 id="pti-hero-title" class="pti-hero__title"><?php esc_html_e( 'WordPress Themes Bundle', 'skt-coming-soon' ); ?></h2>
					<p class="pti-hero__lede"><?php
						/* translators: %s: number of themes */
						printf( esc_html__( 'Get access to %s premium WordPress themes for every kind of business, with regular updates and dedicated support.', 'skt-coming-soon' ), esc_html( $links['theme_count'] ) );
					?></p>

					<ul class="pti-hero__points">
						<li><?php esc_html_e( 'Customization flexibility', 'skt-coming-soon' ); ?></li>
						<li><?php esc_html_e( 'Dedicated support', 'skt-coming-soon' ); ?></li>
					</ul>

					<div class="pti-plans">
						<div class="pti-plan">
							<div class="pti-plan__head">
								<span class="pti-plan__name"><?php esc_html_e( 'All Themes', 'skt-coming-soon' ); ?></span>
								<span class="pti-plan__price"><?php echo esc_html( $links['bundle_price'] ); ?></span>
							</div>
							<p class="pti-plan__term"><?php esc_html_e( '1 year of updates & support', 'skt-coming-soon' ); ?></p>
							<a href="<?php echo esc_url( $links['bundle_buy'] ); ?>" target="_blank" rel="noopener" class="pti-btn pti-btn--primary pti-btn--block"><?php esc_html_e( 'Buy Now', 'skt-coming-soon' ); ?></a>
						</div>
						<div class="pti-plan">
							<div class="pti-plan__head">
								<span class="pti-plan__name"><?php esc_html_e( 'Lifetime', 'skt-coming-soon' ); ?></span>
								<span class="pti-plan__price"><?php echo esc_html( $links['lifetime_price'] ); ?></span>
							</div>
							<p class="pti-plan__term"><?php esc_html_e( 'Lifetime updates & support', 'skt-coming-soon' ); ?></p>
							<a href="<?php echo esc_url( $links['bundle_lifetime'] ); ?>" target="_blank" rel="noopener" class="pti-btn pti-btn--primary pti-btn--block"><?php esc_html_e( 'Buy Now', 'skt-coming-soon' ); ?></a>
						</div>
					</div>
				</div>
				<div class="pti-hero__media">
					<img src="<?php echo esc_url( $img . 'bundle-notice.png' ); ?>" alt="<?php esc_attr_e( 'WordPress Themes Bundle', 'skt-coming-soon' ); ?>" />
				</div>
			</section>             
		</aside>


	</div>
</div>
	<?php
}