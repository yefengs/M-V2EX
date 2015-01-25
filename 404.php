<?php 



// index.php



get_header();
?>
<div id="warpper">
	<section id="content">
		<div id="primary" role="main">
			<div itemscope="" itemtype="http://schema.org/WebPage" id="breadcrumb" class="breadcrumb"> 
					<a itemprop="breadcrumb"  href="<?php echo esc_url( home_url( '/' ) ); ?>" title="返回首页" rel="home"><?php bloginfo( 'name' ); ?></a><span class="chevron">&nbsp;›&nbsp;</span>
					404 Error
			</div>
			<article id="post-0"  class="article-single" >
				<div class="article-single-box">
					<header class="entry-header">
						<h1 class="entry-title" itemprop="name headline">Ouch! 404 error</h1>
					</header>
					<div class="post-entry post-content">
							<p>　It seems the page you are looking for is not here anymore. The page might have moved to another address or just removed by our staff.</p>
							<?php get_search_form(); ?>
					</div>
				</div>
			</article>
		</div>
	</section><!-- end content-->
	<section id="sidebar">
		<?php get_sidebar();?>
	</section><!-- end sidebar -->
	<div class="clearfix"></div>
</div><!-- end wrapper -->
<?php get_footer(); ?>

