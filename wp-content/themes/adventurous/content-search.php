<?php
/**
 * The template for displaying Search Result
 *
 * @package Catch Themes
 * @subpackage Adventurous
 * @since Adventurous 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 
    <div class="entry-container">
    
		<header class="entry-header">
    		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'adventurous' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		</header><!-- .entry-header -->

		<div class="entry-summary">
        <?php the_excerpt(); ?>
    </div><!-- .entry-summary -->  
        
    <footer class="entry-meta">          
        <?php edit_post_link( __( 'Edit', 'adventurous' ), '<span class="edit-link">', '</span>' ); ?>        
    </footer><!-- .entry-meta -->
        
  	</div><!-- .entry-container -->
    
</article><!-- #post-<?php the_ID(); ?> -->