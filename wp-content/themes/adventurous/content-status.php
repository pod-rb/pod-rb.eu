<?php
/**
 * The template for displaying posts in the Status post format
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
    
		<div class="entry-header">
            <header>
                <?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'adventurous_status_avatar', '60' ) ); ?>
                <h2 class="entry-title"><?php the_author(); ?></h2>
            </header>
            <h2 class="entry-format"><a href="<?php echo esc_url( get_post_format_link( 'status' ) ); ?>" title="<?php esc_attr_e( 'All Status Posts', 'adventurous' ); ?>"><?php esc_attr_e( 'Status', 'adventurous' ); ?></a></h2>
		</div><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content( $moretag ); ?>
			<?php wp_link_pages( array( 
                'before'		=> '<div class="page-link"><span class="pages">' . __( 'Pages:', 'adventurous' ) . '</span>',
                'after'			=> '</div>',
                'link_before' 	=> '<span>',
                'link_after'   	=> '</span>',
            ) ); 
            ?>
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