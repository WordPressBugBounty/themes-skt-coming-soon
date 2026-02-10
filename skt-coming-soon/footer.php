<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package SKT Coming Soon
 */
 
$header_trans = get_theme_mod('one_header_transparent', 1); 
$footer_text = get_theme_mod('footer_text');
?>
<div class="copyright-area <?php if( !is_home() && is_front_page() && $header_trans == '') { echo esc_html('transfooter'); } ?>">
<div class="copyright-wrapper">
<div class="container">
     <div class="copyright-txt">
     	<?php if (!empty($footer_text)) { ?>
	 		<?php echo esc_html($footer_text); ?>
		<?php } else { ?>
			<?php bloginfo('name'); ?> <?php esc_html_e('Theme By ','skt-coming-soon');?>            
            <a href="<?php echo esc_url('https://www.sktthemes.org/shop/coming-soon-wordpress-theme/');?>" rel="nofollow noopener noreferrer" target="_blank">
        <?php esc_html_e('SKT Coming Soon','skt-coming-soon'); ?>
        </a>

        <?php } ?>
        </div>
     <div class="clear"></div>
</div>           
</div>
</div><!--end #copyright-area-->
<?php wp_footer(); ?>
</body>
</html>