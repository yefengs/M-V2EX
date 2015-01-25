<?php
/**
 * 默认文章样式
 * @package yefengs
 * @subpackage simple
 * @since simple 1.0
 * @link yefengs.com
 * @author yefengs
 *
 */

?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
			<div class="auther-gravater">
				<?php echo get_avatar( get_the_author_email(), '48'); ?>
			</div>
			<header class="entry-header">
				<?php
					if ( is_single() ) :
					the_title( '<h1 class="entry-title" itemprop="name headline">', '</h1>' );
					else :
					the_title( '<h1 class="entry-title" itemprop="name headline"><a href="' . esc_url( get_permalink() ) . '" itemprop="url" rel="bookmark">', '</a></h1>' );
					endif;
				?>
			</header>
			<div class="post-entry post-content">

				<?php echo cut_string(strip_tags(apply_filters('the_content',$post->post_content)),52); ?>

			</div>
			<footer class="post-meta">
				 <?php the_tags( '<span class="post-tag">', '', '</span>'); ?>
				 <span class="post-auther"><?php the_author_posts_link(); ?></span>
				 <time class="updated postime" title="写于写于<?php the_time('Y年m月d日') ?>　<?php the_time() ?>"><?php the_time('m/d') ?></time>
				 <?php if ( comments_open() && ! is_single() ) : ?>
					<span class="comments-num"><?php comments_popup_link('没有评论', '1条评论 ', '% 条评论'); ?></span>
				<?php endif; // comments_open() ?>

			</footer>


			<div class="entry-content" itemprop="description articleBody">
				<?php

	$str = wpautop( get_the_content() );
  	$_strpos=strpos( $str, '</p>' );

	if (!is_single()&& $_strpos) {
		$str = substr( $str, 0, $_strpos + 4 );
		$str = strip_tags($str, '<a><img><strong><em>');
		echo '<p>' . $str . '</p>';
		echo '<div class="more_link"><a href="' . esc_url( get_permalink() ) . '" class="more-link">阅读全文 <span class="meta-nav">→</span></a></div>';
} else {
	the_content(  '阅读全文 <span class="meta-nav">&rarr;</span>');
}
					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfourteen' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) );
				?>	
			</div>
			<footer class="entry-meta">
				<?php if ( comments_open() && ! is_single() ) : ?>
					<span class="comments-num"><?php comments_popup_link('没有评论', '1条评论 ', '% 条评论'); ?></span>
				<?php endif; // comments_open() ?>
				<?php $categories_list = get_the_category_list( __( ', ', 'twentythirteen' ) );
					if ( $categories_list ) {
						echo '<span class="categories-links">' . $categories_list . '</span>';
					}?>
				<span class="post-views"><?php post_views(); ?></span>
				<?php entry_date(); ?>
				<?php echo getPostLikeLink(get_the_ID()); ?>
				<?php edit_post_link('Edit', '<span class="post-edit">', '</span>' );  ?>
			</footer>
		</article>