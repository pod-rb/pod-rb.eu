<?php
/**
 * The template for displaying posts in the Gallery post format
 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */
 
//Getting data from Theme Options Panel and Meta Box 
$options = adventurous_get_options();

//More Tag
$moretag = $options['more_tag_text'];
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( function_exists( 'adventurous_content_image' ) ) : adventurous_content_image(); endif; ?>
    
	<div class="entry-container post-format">
    
        <header class="entry-header">
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'adventurous' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <h3 class="entry-format"><a href="<?php echo esc_url( get_post_format_link( 'Gallery' ) ); ?>" title="<?php esc_attr_e( 'All Gallery Posts', 'adventurous' ); ?>"><?php esc_attr_e( 'Gallery', 'adventurous' ); ?></a></h3>
        </header><!-- .entry-header -->  
    
    	<div class="entry-content"> 
           
			<?php
            $images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
			
            if ( $images && ( is_home() || is_front_page() ) ) :
			
                $total_images = count( $images );
                $image = array_shift( $images );

                $image_img_tag = wp_get_attachment_image( $image->ID, 'full' );
				?>
                
                <p><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'adventurous' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php echo $image_img_tag; ?></a></p>
                <p><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'adventurous' ), 'href="' . esc_url( get_permalink() ) . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'adventurous' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"', number_format_i18n( $total_images ) ); ?></em></p> 
                
			<?php else :
            	
				the_content( $moretag ); 
				wp_link_pages( array( 
					'before'		=> '<div class="page-link"><span class="pages">' . __( 'Pages:', 'adventurous' ) . '</span>',
					'after'			=> '</div>',
					'link_before' 	=> '<span>',
					'link_after'   	=> '</span>',
				) );
				
          	endif; ?>
             
        </div><!-- .entry-content -->    
            
        <footer class="entry-meta">
            <?php adventurous_post_format_meta(); ?>   
            <?php if ( comments_open() ) : ?>
            	<span class="sep"> | </span>
            	<span class="comments-link"><?php comments_popup_link(__('Leave a reply', 'adventurous'), __('1 Reply', 'adventurous'), __('% Replies;', 'adventurous')); ?></span>
            <?php endif; ?>
            <?php edit_post_link( __( 'Edit', 'adventurous' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
        </footer><!-- .entry-meta -->
        
  	</div><!-- .entry-container -->
    
</article><!-- #post-<?php the_ID(); ?> -->