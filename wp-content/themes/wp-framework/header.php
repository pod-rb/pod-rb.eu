<?php
/**
 * Template: Header.php 
 *
 * @package WPFramework
 * @subpackage Template
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!--BEGIN html-->
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<!-- Built on WP Framework (http://wpframework.com) - Powered by WordPress (http://wordpress.org) -->

<!--BEGIN head-->
<head profile="<?php get_profile_uri(); ?>">

	<title><?php semantic_title(); ?></title>

	<!-- Meta Tags -->
	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress" />
	<meta name="framework" content="WP Framework" />

	<!-- Favicon: Browser + iPhone Webclip -->
	<link rel="shortcut icon" href="http://www.pod-rb.eu/wp-content/uploads/2011/01/pod-rb_logoFavicon_16x16.ico" />
	<link rel="apple-touch-icon" href="<?php echo IMAGES . '/iphone.png'; ?>" />

	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="<?php echo CSS . '/print.css'; ?>" type="text/css" media="print" />

  	<!-- Links: RSS + Atom Syndication + Pingback etc. -->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo( 'rss_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo( 'atom_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!-- Theme Hook -->
    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); // loads the javascript required for threaded comments ?>
	<?php wp_head(); ?>
<script type="text/javascript">
/*jQuery(function(){
jQuery(".member").mouseenter(function(){
	jQuery(this).children(".info").animate({"opacity":1},400);
});
jQuery(".member").mouseleave(function(){
	jQuery(this).children(".info").animate({"opacity":0},400);
});
jQuery('a.gal_member').lightBox();
jQuery('a.gallery').lightBox();
});*/
</script>

<!--[if lt IE 9]>
<style type="text/css">
/* CSS Hacks for IE*/
.container{border:1px solid #666}
.info{background:#383838 url(http://www.pod-rb.eu/wp-content/uploads/2011/01/bat_member22.png) no-repeat 50% 50%; filter: alpha(opacity = 0);}
.info a:link,.info a.gal_member{*position:absolute; *bottom:10px; *right:10px;}
.nav .page-item-22 a{border-right: 0 none;} /* use last list item class here*/
a.lightbox img {filter: alpha(opacity = 70);} 
.aside h3, .aside h4{color:#666;}
.aside{border:1px solid #666;} 
.nav{position:relative; z-index:3;}
</style>
<![endif]-->
<!--END head-->
</head>

<!--BEGIN body-->
<body class="<?php semantic_body(); ?>">
	
	<!--BEGIN .container-->
	<div class="container">
		<!-- Featured pictures on the top -->		

		<?php
			$banners = get_option("alobaidi_rbp_custom_banners");
			$links = get_option("alobaidi_rbp_custom_links");
			echo alobaidi_random_banners( $banners, $links, null );
		?>

		<!--BEGIN .header-->
		<div class="header">
			<!--<div id="logo">
				<a href="<?php bloginfo( 'url' ); ?>">
					<img width="484" height="108" src="http://www.pod-rb.eu/wp-content/uploads/2011/04/logo-white-text-texture-dar.png" title="Под Ръбъ" alt="Под Ръбъ text picture logo" />
				</a>
			</div>
-->
<!--original            <div id="logo"><a href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'name' ) ?></a></div>
			<p id="tagline"><?php bloginfo( 'description' ) ?></p>
 -->
			<div id="club_logo"><img src="http://www.pod-rb.eu/wp-content/uploads/2012/10/Pod_Rb_shadow.png" width="150" title="Под Ръбъ" alt="Лого на клуб Под Ръбъ" /></div>

		<!--END .header-->
		</div>

        <?php
/*wp_page_menu( 'show_home=0' );*/


	wp_nav_menu( array( 'theme_location' => 'header-menu',  'container' => 'div', 'container_class' => 'menu', 'menu_class' => 'nav sf-js-enabled sf-shadow' ) );
?>
		<!--BEGIN #content-->
		<div id="content">
		
