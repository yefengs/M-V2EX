<?php 



// index.php



get_header();
?>
<div id="warpper">
	<section id="content">
		<div id="primary" role="main">
			<div itemscope="" itemtype="http://schema.org/WebPage" id="breadcrumb" class="breadcrumb"> 
				<?php 
					if ( !is_home() ) {  ?>
					<a itemprop="breadcrumb"  href="<?php echo esc_url( home_url( '/' ) ); ?>" title="返回首页" rel="home"><?php bloginfo( 'name' ); ?></a>
					<?php } ?><span class="chevron">&nbsp;›&nbsp;</span>
				 <span class="current">正文</span>
			</div>
		<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();

					?>
					<article id="post-<?php the_ID(); ?>" <?php //post_class(); ?> class="article-single" >
						<div class="article-single-box">
							<header class="entry-header">
								<?php the_title( '<h1 class="entry-title" itemprop="name headline">', '</h1>' ); ?>
								<div class="auther-gravater-single">
									<?php echo get_avatar( get_the_author_email(), '48'); ?>
								</div>
								<div class="post-meta-top">
									<span class="post-auther"><?php the_author_posts_link(); ?></span>
									<span class="updated postime" title="写于写于<?php the_time('Y年m月d日') ?>　<?php the_time() ?>"><?php post_time_ago(); ?></span>
									<span class="post"><?php post_views(' ','次点击'); ?> </span>
								</div>

							</header>
							<div class="post-entry post-content">
								<p class="conetent-string">
								<?php the_content(  '阅读全文 <span class="meta-nav">&rarr;</span>');
									wp_link_pages( array(
										'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfourteen' ) . '</span>',
										'after'       => '</div>',
										'link_before' => '<span>',
										'link_after'  => '</span>',
									) ); ?>
									
								<?php   comments_open() ?>
								</p>
							</div>
							<footer class="post-meta-single">
								<div class="meta-l">
									 <span class="post-auther"><?php the_author_posts_link(); ?></span>
									 <span class="post-category"><?php the_category('/') ?></span>
								 </div>
								 <div class="meta-r">
									 <span class="post"><?php post_views(' ','次点击'); ?> </span>
									 <span class="comments-num"><?php comments_popup_link('0人发表看法', '1人发表看法', '%人发表看法'); ?></span>
								</div>
								<div class="clearfix"></div>
							</footer>
						</div>
					</article>
					<?php
				endwhile;
				// Previous/next post navigation.
				 ?>
		    	<?php 
			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif;
			if ( comments_open() || get_comments_number() ) {
				
			}
		?>
		</div>
		 <?php comments_template(); ?><!--end primary or artile list box-->
	</section><!-- end content-->
	<section id="sidebar">

		<?php get_sidebar();?>
	</section><!-- end sidebar -->
	<div class="clearfix"></div>
</div><!-- end wrapper -->

<?php get_footer(); ?>