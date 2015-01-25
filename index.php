<?php 



// index.php



get_header();
?>
<div id="warpper">
	<section id="content">
		<div id="hot-tag">
				<?php wp_tag_cloud('smallest=13&largest=13&number=6&orderby=count&unit=px'); ?>
		</div>
		<div id="top-tips">
				<?php wp_nav_menu( array( 'theme_location' => 'tag_Menu', 'menu_class' => 'nav-menu' ) ); ?>	
		</div>
		<div id="primary" role="main">
		<?php
			if ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					//get_template_part( 'content', get_post_format() );


					?>
					<article id="post-<?php the_ID(); ?>" <?php //post_class(); ?> class="index-post" >
						<div class="auther-gravater">
							<?php echo get_avatar( get_the_author_email(), '48'); ?>
						</div>
						<div class="article-box">
							<header class="entry-header">
								<?php
									if ( is_single() ) :
									the_title( '<h2 class="entry-title" itemprop="name headline">', '</h2>' );
									else :
									the_title( '<h2 class="entry-title" itemprop="name headline"><a href="' . esc_url( get_permalink() ) . '" itemprop="url" rel="bookmark">', '</a></h2>' );
									endif;
								?>
							</header>
							<div class="post-entry post-content">
								<p class="conetent-string">
								<?php echo cut_string(strip_tags(apply_filters('the_content',$post->post_content)),42); ?>
								 <?php if ( comments_open() && ! is_single() ) : ?>
									<span class="comments-num"><?php comments_popup_link('0', '1', '%'); ?></span>
								<?php endif; // comments_open() ?>
								</p>
							</div>
							<footer class="post-meta">
								 <?php the_tags( '<span class="post-tag">', '', '</span>'); ?>
								 <span class="post-auther"><?php the_author_posts_link(); ?></span>
								 <time class="updated postime" title="写于写于<?php the_time('Y年m月d日') ?>　<?php the_time() ?>"><?php the_time('m/d') ?></time>
							</footer>
						</div>
					</article>
					<?php endwhile; ?>
					<nav id="page-navigation" role="navigation">
						<div class="nav-previous" >
							<?php 
								if ( get_previous_posts_link() ) : 
									previous_posts_link( __( '<span class="meta-nav">‹ </span> 上一页 ', 'twentythirteen' ) );
								endif; ?>&nbsp;
						</div>
						<?php get_all_post_nav_num(); ?>
						<div class="nav-next" >
						<?php 
						if ( get_next_posts_link() ) : next_posts_link( __( ' 下一页 <span class="meta-nav">›</span> ', 'twentythirteen' ) );
						 endif; 
						 ?>&nbsp;
						</div>
						<div class="clearfix"></div>
					</nav>
		    	<?php 
			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif;
		?>
		</div><!--end primary or artile list box-->
	</section><!-- end content-->
	<section id="sidebar">
		<?php get_sidebar();?>
	</section><!-- end sidebar -->
	<div class="clearfix"></div>
</div><!-- end wrapper -->

<?php get_footer(); ?>