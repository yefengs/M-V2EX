<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width">
	<title><?php if ( is_tag() ) { echo wp_title('Tag:');if($paged > 1) printf(' - 第%s页',$paged);echo ' | '; bloginfo( 'name' );} elseif ( is_archive() ) {echo wp_title('');  if($paged > 1) printf(' - 第%s页',$paged);    echo ' | ';    bloginfo( 'name' );} elseif ( is_search() ) {echo '&quot;'.wp_specialchars($s).'&quot;的搜索结果 | '; bloginfo( 'name' );} elseif ( is_home() ) {bloginfo( 'name' );$paged = get_query_var('paged'); if($paged > 1) printf(' - 第%s页',$paged);}  elseif ( is_404() ) {echo '404错误 页面不存在！ | '; bloginfo( 'name' );} else {echo wp_title( ' | ', false, right )  ; bloginfo( 'name' );} ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--link rel="stylesheet" type="text/css" href="style.css" media="screen"-->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	<script src="http://libs.useso.com/js/jquery/1.8.3/jquery.min.js?v=1.8.3&type=1"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body itemscope itemtype="http://schema.org/WebPage">
<header id="header">
	<section id="head-wrapper" role="banner">
		<div id="logo">
			<h1 id="site-url">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</h1>
		</div>
		<div id="top-search-box">
			<form id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<input type="text" placeholder="" title="Search" name="s" id="s" x-webkit-speech="x-webkit-speech"/>
			</form>
		</div>
		<nav id="top-nav" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>	
		</nav>
		<div class="clearfix"></div>
	</section>
</header>
<div id="shadow"></div>
