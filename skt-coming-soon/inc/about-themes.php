<?php
//about theme info
add_action( 'admin_menu', 'skt_coming_soon_abouttheme' );
function skt_coming_soon_abouttheme() {    	
	add_theme_page( esc_html__('About Theme', 'skt-coming-soon'), esc_html__('About Theme', 'skt-coming-soon'), 'edit_theme_options', 'skt_coming_soon_guide', 'skt_coming_soon_mostrar_guide');   
} 
//guidline for about theme
function skt_coming_soon_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
?>
<div class="wrapper-info">
	<div class="col-left">
   		   <div class="col-left-area">
			  <?php esc_html_e('Theme Information', 'skt-coming-soon'); ?>
		   </div>
          <p><?php esc_html_e('SKT Coming Soon WordPress theme for under construction, website maintenance, holding, landing page, maintenance mode, countdown, launching page, teaser page, 404, doing some work and busy for launch product pages can be created using this theme. Comes with other types of 150+ templates for other industry use. SEO friendly, simple, easy, flexible to use.','skt-coming-soon'); ?></p>
	</div><!-- .col-left -->
	<div class="col-right">			
			<div class="centerbold">
				<hr />
				<a href="<?php echo esc_url(SKT_COMING_SOON_SKTTHEMES_LIVE_DEMO); ?>" target="_blank"><?php esc_html_e('Live Demo', 'skt-coming-soon'); ?></a> | 
				<a href="<?php echo esc_url(SKT_COMING_SOON_SKTTHEMES_PRO_THEME_URL); ?>"><?php esc_html_e('Buy Pro', 'skt-coming-soon'); ?></a> | 
				<a href="<?php echo esc_url(SKT_COMING_SOON_SKTTHEMES_THEME_DOC); ?>" target="_blank"><?php esc_html_e('Documentation', 'skt-coming-soon'); ?></a>
                <div class="space5"></div>
				<hr />                
                <a href="<?php echo esc_url(SKT_COMING_SOON_SKTTHEMES_THEMES); ?>" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sktskill.jpg" alt="" /></a>
			</div>		
	</div><!-- .col-right -->
</div><!-- .wrapper-info -->
<?php } ?>