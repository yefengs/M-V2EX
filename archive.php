<?php 



// index.php



get_header();
?>
<div id="warpper">
	<section id="content">
			<header id="archive-header">
				<h2 class="archive-title">



<?php  if (is_category()) { ?>
		<h2 class="archive-title">在分类目录《<?php single_cat_title(); ?>》中有如下文章</h2>
 	  <?php  } elseif( is_tag() ) { ?>
		<h2 class="archive-title">含有标签『<?php single_tag_title(); ?>』的文章如下</h2>
 	  <?php  } elseif (is_day()) { ?>
		<h2 class="archive-title">在这一天的<?php the_time('F jS, Y'); ?>文章有如下</h2>
 	  <?php  } elseif (is_month()) { ?>
		<h2 class="archive-title">在<?php the_time('F, Y'); ?>这段时间里的文章如下</h2>
 	  <?php } elseif (is_year()) { ?>
		<h2 class="archive-title">在这<?php the_time('Y'); ?>一年里的文章如下</h2>
	  <?php  } elseif (is_author()) { ?>
	   <h2 class="archive-title">这些年来博主写了如下文章</h2>
 	  <?php  } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="archive-title">博客存档文章</h2>
 	  <?php } ?>



					<?php


					/*
					if ( is_day() ) :
						printf( __( ' %s 这天的存档', 'twentytwelve' ), '<span>' . get_the_date() . '</span>' );
					elseif ( is_month() ) :
						printf( __( ' %s 这月的存档', 'twentytwelve' ), '<span>' . get_the_date( _x( 'Y F', 'monthly archives date format', 'twentytwelve' ) ) . '</span>' );

					elseif ( is_year() ) :
						printf( __( ' %s 这年的存档', 'twentytwelve' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'twentytwelve' ) ) . '</span>' );
					
					elseif ( is_author() ) :
						printf( __( '<span>博主写的文章如下</span>' );
				elseif ( is_tag() ) :
						echo '<span>与“'.single_tag_title().'”相关的内容如下</span>';

				elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) :
						echo '<span>分类目录《'.single_cat_title().'》中的内容如下</span>';
					else :
						_e( '存档如下', 'twentytwelve' );
					endif;

					**/	  
				?></h2>

			</header>
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
								 <span class="post-auther"><strong><?php the_author_posts_link(); ?></strong></span>
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