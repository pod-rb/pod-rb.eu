<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */
?> 
			<?php 
            /** 
             * adventurous_content_sidebar_close hook
             *
             * HOOKED_FUNCTION_NAME PRIORITY
             *
             * adventurous_content_sidebar_wrapper_close 10
             */
            do_action( 'adventurous_content_sidebar_close' ); ?> 
            
		<?php 
        /** 
         * adventurous_main_close hook
         *
         * HOOKED_FUNCTION_NAME PRIORITY
         *
         * adventurous_main_wrapper_close 10
         */
        do_action( 'adventurous_main_close' ); ?>             
     
        <?php 
        /** 
         * adventurous_after_main hook
         */
        do_action( 'adventurous_after_main' ); ?> 
        
   	</div><!-- #main-wrapper -->
           
    <?php 
    /** 
     * adventurous_before_footer hook
	 *
	 * HOOKED_FUNCTION_NAME PRIORITY
	 * 
	 * adventurous_homepage_featured_display value before footer 20
     */
    do_action( 'adventurous_before_footer' );  ?>     
    
	<footer id="colophon" role="contentinfo">
    
		<?php
        /** 
         * adventurous_footer hook
         *
         * @hooked adventurous_footer_sidebar - 10
         */		 
        do_action( 'adventurous_footer' ); ?>
        
 		<?php
        /** 
         * adventurous_footer hook
         *
         * @hooked adventurous_site_generator_open - 10
		 * @hooked adventurous_footer_content - 20
		 * @hooked adventurous_site_generator_close - 100
         */		 
        do_action( 'adventurous_site_generator' ); ?>       
           
  <script type="text/javascript">
  /**
   * This fixes aa bug for Wp-image-zoom plugin connected to sticky header that displaces the aoom lens. Check official wp-image zoom documentation
   */
    jQuery(document).ready(function( $ ) {
      var haveRefreshed = false;
      jQuery(document).scroll(function() {
        var topScrol = $(window).scrollTop()
          var options = IZ.options;
          if(topScrol > 70 && !haveRefreshed) { // the value when the header becomse small
            haveRefreshed = true;
            $('.zoomContainer').remove();
            if (IZ && IZ.with_woocommerce == '1') {
              $('img.zoooom, .attachment-shop_single, .attachment-shop_thumbnail.flex-active-slide img').image_zoom(options);
            } else {
              $('img.zoooom, .zoooom img').image_zoom(options);
            }
            if (IZ && IZ.woo_categories == '1') {
              $('.tax-product_cat .products img').image_zoom(options);
            }
        }
      });
    });
  </script>               
	</footer><!-- #colophon .site-footer -->
    
    <?php 
    /** 
     * adventurous_after_footer hook
	 *
	 * @hooked adventurous_scrollup - 10
     */
    do_action( 'adventurous_after_footer' );  ?> 
    
</div><!-- #page .hfeed .site -->

<?php 
/** 
 * adventurous_after hook
 */
do_action( 'adventurous_after' );

wp_footer(); ?>

</body>
</html>
