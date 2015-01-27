<article id="post-0"  class="article-single" >
	<div class="article-single-box">
		<header class="entry-header">
			<h1 class="entry-title" itemprop="name headline">Nothing Found</h1>
		</header>
		<div class="post-entry post-content">
			<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
				<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'twentyfifteen' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
			<?php elseif ( is_search() ) : ?>
				<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'twentyfifteen' ); ?></p>
				<?php get_search_form(); ?>
			<?php else : ?>
				<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'twentyfifteen' ); ?></p>
				<?php get_search_form(); ?>
			<?php endif; ?>
		</div>
	</div>
</article>
