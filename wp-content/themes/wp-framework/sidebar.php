<?php
/**
 * Template: Sidebar.php
 *
 * @package WPFramework
 * @subpackage Template
 */
?>
        <!--BEGIN #secondary .aside-->
        <div id="secondary" class="aside"> 
            
            <?php 
/*
                  $page_url = explode('/', get_page_link() );
                  $image_file = "../wp-content/uploads/2011/04/" . $page_url[3] . "-pod-raba.jpg";
		  if(file_exists($image_file)) 
                     echo "<img height='330' class='right_col_image' width='280' title='' alt='' src='" . $image_file . "' />"; 
                  else echo "<img height='330' class='right_col_image' width='280' title='' alt='' src='../wp-content/uploads/2011/04/articles-pod-raba1-254x300.jpg' />";
 */
            ?>
            	
			<?php	/* Widgetized Area */
					if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar() ) : ?>
          
            <!--BEGIN #widget-search-->
            <div id="widget-search" class="widget">
				<?php get_search_form(); ?>
            <!--END #widget-search--> 
            </div>

            <!--BEGIN #widget-pages-->
            <div id="widget-pages" class="widget">
				<h3 class="widget-title">Pages</h3>
				<ul class="xoxo">
					<?php wp_list_pages( 'title_li=' ); ?>
				</ul>
            <!--END #widget-pages-->
            </div>

            <!--BEGIN #widget-categories-->
            <div id="widget-categories" class="widget">
				<h3 class="widget-title">Categories</h3>
				<ul class="xoxo">
					<?php wp_list_categories( 'title_li=' ); ?>
				</ul>
            <!--END #widget-categories-->
            </div>
			
<?php if ( get_tags() ) { ?>
            <!--BEGIN #widget-tags-->
            <div id="widget-tags" class="widget">
				<h3 class="widget-title">Tags</h3>
				<?php wp_tag_cloud( 'title_li=&format=list&smallest=13&largest=13&unit=px' ); ?>
            <!--END #widget-tags-->
            </div>
<?php } ?>

            <!--BEGIN #widget-bookmarks-->
            <div id="widget-bookmarks" class="widget">
				<h3 class="widget-title">Blogroll</h3>
				<ul class="xoxo">
					<?php wp_list_bookmarks( 'title_li=&categorize=0' ); ?>
				</ul>
            <!--END #widget-bookmarks-->
            </div>

			<!--BEGIN #widget-archives-->
            <div id="widget-archives" class="widget">
				<h3 class="widget-title">Archives</h3>
				<ul class="xoxo">
					<?php wp_get_archives( 'type=monthly' ) ?>
				</ul>
            <!--END #widget-archives-->
            </div>

            <!--BEGIN #widget-feeds-->
            <div id="widget-feeds" class="widget">
				<h3 class="widget-title">RSS Syndication</h3>
				<ul class="xoxo">
					<li><a href="<?php bloginfo( 'rss2_url' ); ?>" title="<?php echo wp_specialchars( get_bloginfo( 'name' ), 1 ) ?> Posts RSS feed" rel="alternate" type="application/rss+xml">All posts</a></li>
					<li><a href="<?php bloginfo( 'comments_rss2_url' ); ?>" title="<?php echo wp_specialchars( bloginfo( 'name' ), 1 ) ?> Comments RSS feed" rel="alternate" type="application/rss+xml">All comments</a></li>
				</ul>
            <!--END #widget-feeds-->
            </div>

            <!--BEGIN #widget-meta-->
            <div id="widget-meta" class="widget">
				<h3 class="widget-title">Meta</h3>
				<ul class="xoxo">
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
					<li><a href="http://validator.w3.org/check/referer" title="Validate this page as XHTML 1.0 Transitional">Validate <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
					<li><a href="http://jigsaw.w3.org/css-validator/check/referer" title="Validate this page as CSS level 2.1">Validate <abbr title="Cascading Style Sheets">CSS</abbr></a></li>
				</ul>
			<!--END #widget-meta-->
			</div>
			<?php endif; /* (!function_exists('dynamic_sidebar') */ ?>
		<!--END #secondary .aside-->

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/bg_BG/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-like-box" data-href="http://www.facebook.com/pages/%D0%9F%D0%BE%D0%B4-%D1%80%D1%8A%D0%B1%D1%8A/187810817900448" data-width="282" data-height="260" data-colorscheme="dark" data-show-faces="true" data-stream="false" data-header="false"></div>
		</div>