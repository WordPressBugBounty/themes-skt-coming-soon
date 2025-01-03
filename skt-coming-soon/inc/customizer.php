<?php
/**
 * SKT Coming Soon Theme Customizer
 *
 * @package SKT Coming Soon
 */
function skt_coming_soon_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'skt_coming_soon_custom_header_args', array(
		'default-text-color'     => '949494',
		'width'                  => 1600,
		'height'                 => 230,
		'wp-head-callback'       => 'skt_coming_soon_header_style',
 		'default-text-color' => false,
 		'header-text' => false,
	) ) );
}
add_action( 'after_setup_theme', 'skt_coming_soon_custom_header_setup' );
if ( ! function_exists( 'skt_coming_soon_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see skt_coming_soon_custom_header_setup().
 */
function skt_coming_soon_header_style() {
		$hideheaderborder = esc_html(get_theme_mod( 'hide_header_border' )); 
		$hidefooterborder = esc_html(get_theme_mod( 'hide_footer_border' ));
	?>    
	<style type="text/css">
	<?php
		//Check if user has defined any header image.
		if ( get_header_image() ) :
	?>
		.header {
			background: url(<?php echo esc_url(get_header_image()); ?>) no-repeat;
			background-position: center top;
			background-size:cover;
		}
	<?php endif; ?>	
	<?php
		if($hideheaderborder == '1') {
		?>
		.transheader{
			border-bottom:none !important;
		}
		<?php	
		}
		if($hidefooterborder == '1') {
		?>
		.transfooter{
			border-top:none !important;
		}
		<?php	
		}
	?> 		
	</style>
	<?php
}
endif; // skt_coming_soon_header_style 
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */ 
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function skt_coming_soon_customize_register( $wp_customize ) {
	//Add a class for titles
    class skt_coming_soon_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
			<h3 style="text-decoration: underline; color: #DA4141; text-transform: uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->add_setting('color_scheme',array(
			'default'	=> '#ffdf14',
			'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'color_scheme',array(
			'label' => esc_html__('Color Scheme','skt-coming-soon'),			
			'section' => 'colors',
			'settings' => 'color_scheme'
		))
	);
	
		$wp_customize->add_setting('header_bg_color',array(
			'default'	=> '#222933',
			'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'header_bg_color',array(
			'label' => esc_html__('Heder Background Color','skt-coming-soon'),				
			'section' => 'colors',
			'settings' => 'header_bg_color'
		))
	);
	
		$wp_customize->add_setting('footer_bg_color',array(
			'default'	=> '#222933',
			'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'footer_bg_color',array(
			'label' => esc_html__('Footer Background Color','skt-coming-soon'),				
			'section' => 'colors',
			'settings' => 'footer_bg_color'
		))
	);	

		$wp_customize->add_setting('header_border_color',array(
			'default'	=> '#e6c94d',
			'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'header_border_color',array(
			'label' => esc_html__('Frontpage Transparent Header Border Color','skt-coming-soon'),				
			'section' => 'colors',
			'settings' => 'header_border_color'
		))
	);	
	
		$wp_customize->add_setting('footer_border_color',array(
			'default'	=> '#e6c94d',
			'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'footer_border_color',array(
			'label' => esc_html__('Frontpage Transparent Footer Border Color','skt-coming-soon'),				
			'section' => 'colors',
			'settings' => 'footer_border_color'
		))
	);	
	
		$wp_customize->add_setting('footer_text_color',array(
			'default'	=> '#ffffff',
			'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'footer_text_color',array(
			'label' => esc_html__('Footer Text Color','skt-coming-soon'),				
			'section' => 'colors',
			'settings' => 'footer_text_color'
		))
	);	
	
	$wp_customize->add_section('footer_text_copyright',array(
			'title'	=> esc_html__('Footer Copyright Text','skt-coming-soon'),				
			'priority'		=> null
	));
	
	$wp_customize->add_setting('footer_text',array(
			'default'	=> null,
			'sanitize_callback'	=> 'sanitize_text_field'	
	));
	$wp_customize->add_control('footer_text',array(
			'label'	=> esc_html__('Add Copyright Text Here','skt-coming-soon'),
			'section'	=> 'footer_text_copyright',
			'setting'	=> 'footer_text'
	));			

	
	$wp_customize->add_section('header_social_icons',array(
			'title'	=> esc_html__('Header Social Icons','skt-coming-soon'),				
			'priority'		=> null
	));
	
	$wp_customize->add_setting('hdr_fb_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'	
	));
	$wp_customize->add_control('hdr_fb_link',array(
			'label'	=> esc_html__('Add Facebook link here','skt-coming-soon'),
			'section'	=> 'header_social_icons',
			'setting'	=> 'hdr_fb_link'
	));	
	$wp_customize->add_setting('hdr_twitt_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('hdr_twitt_link',array(
			'label'	=> esc_html__('Add Twitter link here','skt-coming-soon'),
			'section'	=> 'header_social_icons',
			'setting'	=> 'hdr_twitt_link'
	));
	$wp_customize->add_setting('hdr_instagram_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('hdr_instagram_link',array(
			'label'	=> esc_html__('Add Instagram link here','skt-coming-soon'),
			'section'	=> 'header_social_icons',
			'setting'	=> 'hdr_instagram_link'
	));		
	$wp_customize->add_setting('hdr_linkedin_link',array(
			'default'	=> null,
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('hdr_linkedin_link',array(
			'label'	=> esc_html__('Add Linkedin link here','skt-coming-soon'),
			'section'	=> 'header_social_icons',
			'setting'	=> 'hdr_linkedin_link'
	));		
	//Hide Header Social Icons
	$wp_customize->add_setting('hide_header_social_icons',array(
			'sanitize_callback' => 'skt_coming_soon_sanitize_checkbox',
			'default' => true,
	));	 
	$wp_customize->add_control('hide_header_social_icons', array(
    	   'section'   => 'header_social_icons',    	 
		   'label'	=> esc_html__('Uncheck To Show This Section','skt-coming-soon'),
    	   'type'      => 'checkbox'
     ));
	 //Hide Header Social Icons	
	
	// Transparent Header
	$wp_customize->add_section('header_transparent',array(
			'title'	=> esc_html__('Homepage Header and Footer Transparent','skt-coming-soon'),					
			'priority'		=> null
	));	

	$wp_customize->add_setting('one_header_transparent',array(
			'sanitize_callback' => 'skt_coming_soon_sanitize_checkbox',
			'default' => true,
	));	 
	$wp_customize->add_control( 'one_header_transparent', array(
    	   'section'   => 'header_transparent',    	 
		   'label'	=> esc_html__('Uncheck To Enable Transparent Header','skt-coming-soon'),
    	   'type'      => 'checkbox'
     ));	
	 // Transparent Header
	 
	$wp_customize->add_section('header_footer_border',array(
			'title'	=> esc_html__('Header Footer Border','skt-coming-soon'),				
			'priority'		=> null
	));
    
	//Hide Header Border
	$wp_customize->add_setting('hide_header_border',array(
			'sanitize_callback' => 'skt_coming_soon_sanitize_checkbox',
			'default' => false,
	));	 
	$wp_customize->add_control('hide_header_border', array(
    	   'section'   => 'header_footer_border',    	 
		   'label'	=> esc_html__('Check To Hide Header Border','skt-coming-soon'),
    	   'type'      => 'checkbox'
     ));
	 //Hide Header Border
	 
	//Hide Footer Border
	$wp_customize->add_setting('hide_footer_border',array(
			'sanitize_callback' => 'skt_coming_soon_sanitize_checkbox',
			'default' => false,
	));	 
	$wp_customize->add_control('hide_footer_border', array(
    	   'section'   => 'header_footer_border',    	 
		   'label'	=> esc_html__('Check To Hide Footer Border','skt-coming-soon'),
    	   'type'      => 'checkbox'
     ));
	 //Hide Footer Border	 
}
add_action( 'customize_register', 'skt_coming_soon_customize_register' );
//Integer
function skt_coming_soon_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}
function skt_coming_soon_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

//setting inline css.
function skt_coming_soon_custom_css() {
    wp_enqueue_style(
        'skt-coming-soon-custom-style',
        get_template_directory_uri() . '/css/skt-coming-soon-custom-style.css' 
    );
        $color = esc_html(get_theme_mod( 'color_scheme' )); //E.g. #e64d43
		$headerbgcolor = esc_html(get_theme_mod( 'header_bg_color' )); 
		$footerbgcolor = esc_html(get_theme_mod( 'footer_bg_color' ));
		$headerbordercolor = esc_html(get_theme_mod( 'header_border_color' ));
		$footerbordercolor = esc_html(get_theme_mod( 'footer_border_color' ));
		$footertextcolor = esc_html(get_theme_mod( 'footer_text_color' )); 

        $custom_css = "
					#sidebar ul li a:hover,
					.footerarea a:hover,
					.blog_lists h4 a:hover,
					.recent-post h6 a:hover,
					.recent-post a:hover,
					.design-by a,
					.fancy-title h2 span,
					.postmeta a:hover,
					.left-fitbox a:hover h3, .right-fitbox a:hover h3, .tagcloud a,
					.blocksbox:hover h3,
					.homefour_section_content h2 span,
					.section5-column:hover h3,
					.section1top-block-area h2 span,
					.hometwo_section_content h2 span,
					.rdmore a,
					.hometwo_section_area h2 small,
					.hometwo_section_area .woocommerce ul.products li.product:hover .woocommerce-loop-product__title,
					.home3_section_area h2 small,
					.sec3-block-button2,
					.designboxbg:hover .designbox-content h3,
					.hometwo-service-column-title a:hover,
					.serviceboxbg:hover .servicebox-content h4,
					.main-navigation ul li:hover a, .main-navigation ul li a:focus, .main-navigation ul li a:hover, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current_page_item a
					{ 
						 color: {$color} !important;
					}
					.pagination .nav-links span.current, .pagination .nav-links a:hover,
					#commentform input#submit:hover,
					.wpcf7 input[type='submit'],
					.section2button,
					input.search-submit,
					.recent-post .morebtn:hover, 
					.slide_info .slide_more,
					.sc1-service-box-outer,
					.read-more-btn,
					.woocommerce-product-search button[type='submit'],
					.head-info-area,
					.designs-thumb,
					.hometwo-block-button,
					.nivo-controlNav a.active,
					.aboutmore,
					.service-thumb-box,
					.view-all-btn a:hover
					{ 
					   background-color: {$color} !important;
					}
					.sc1-service-box-outer h3 a:hover, .sc1-service-box-outer:hover h3 a,
					.hometwo_section_area .woocommerce ul.products li.product:hover,
					.nivo-controlNav a
					{
					   border-color: {$color} !important;
					}
					.titleborder span:after, .perf-thumb:before{border-bottom-color: {$color} !important;}
					.perf-thumb:after{border-top-color: {$color} !important;}
					
					.header{background-color: {$headerbgcolor};}
					.copyright-area{background-color: {$footerbgcolor};}
					
					.transheader{border-color: {$headerbordercolor} !important;}
					.transfooter{border-color: {$footerbordercolor} !important;}
					.copyright-wrapper{color: {$footertextcolor} !important;}
				";
        wp_add_inline_style( 'skt-coming-soon-custom-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'skt_coming_soon_custom_css' );          
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function skt_coming_soon_customize_preview_js() {
	wp_enqueue_script( 'skt_coming_soon_customizer', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'skt_coming_soon_customize_preview_js' );