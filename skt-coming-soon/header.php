<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="container">
 *
 * @package SKT Coming Soon
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<a class="skip-link screen-reader-text" href="#content_navigator">
<?php esc_html_e( 'Skip to content', 'skt-coming-soon' ); ?>
</a>
<!--HEADER INFO AREA STARTS-->
<?php 
$fb_link = get_theme_mod('hdr_fb_link'); 
$twitt_link = get_theme_mod('hdr_twitt_link');
$instagram_link = get_theme_mod('hdr_instagram_link');
$linkedin_link = get_theme_mod('hdr_linkedin_link');
$header_trans = get_theme_mod('one_header_transparent', 1);
$topsocial = get_theme_mod('hide_header_social_icons', 1);
?>
<!--HEADER INFO AREA ENDS-->
<div class="header <?php if( !is_home() && is_front_page() && $header_trans == '') { echo esc_html('transheader'); } ?>">
  <div class="container">
    <div class="logo">
		<?php skt_coming_soon_the_custom_logo(); ?>
        <div class="clear"></div>
		<?php	
        $description = get_bloginfo( 'description', 'display' );
        ?>
        <div id="logo-main">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <h2 class="site-title"><?php bloginfo('name'); ?></h2>
        <?php if ( $description || is_customize_preview() ) :?>
        <p class="site-description"><?php echo esc_html($description); ?></p>                          
        <?php endif; ?>
        </a>
        </div>
    </div> 
    	<?php 
		if ( has_nav_menu( 'primary' ) ) {
		?>
        <div id="navigation"><nav id="site-navigation" class="main-navigation">
				<button type="button" class="menu-toggle">
					<span></span>
					<span></span>
					<span></span>
				</button>
		<?php wp_nav_menu( array('theme_location' => 'primary', 'container' => 'ul', 'menu_id' => 'primary', 'menu_class' => 'primary-menu menu' ) ); ?>
			</nav></div>
        <?php } ?>
        <?php if( $topsocial == '') { ?>
        <div id="top-social">
        	<div class="social-icons">
    		<?php 
            if (!empty($fb_link)) { ?><a title="<?php echo esc_attr__('Facebook','skt-coming-soon'); ?>" class="fb" target="_blank" href="<?php echo esc_url($fb_link); ?>"></a><?php } if (!empty($twitt_link)) { ?><a title="<?php echo esc_attr__('Twitter','skt-coming-soon'); ?>" class="tw" target="_blank" href="<?php echo esc_url($twitt_link); ?>"></a><?php } if (!empty($instagram_link)) { ?><a title="<?php echo esc_attr__('Instagram','skt-coming-soon'); ?>" class="insta" target="_blank" href="<?php echo esc_url($instagram_link); ?>"></a> <?php } if (!empty($linkedin_link)) { ?><a title="<?php echo esc_attr__('Linkedin','skt-coming-soon'); ?>" class="in" target="_blank" href="<?php echo esc_url($linkedin_link); ?>"></a> 
            <?php } ?>   
            </div>
        </div>
        <?php } ?>
        <div class="clear"></div>    
    </div> <!-- container --> 
    <div class="clear"></div>  
  </div>
  <div class="clear"></div> 