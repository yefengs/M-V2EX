<?php
/**
 * The template for displaying Comments
 * @package WordPress
 * @subpackage M-V2EX
 * @since M-V2EX 1.0
 */
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Error');
if ( post_password_required() )
	return;
?>
<div id="comments" class="comments-area">
	<div id="comments-title" post-id="<?php the_ID(); ?>">
			<?php printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'twentythirteen' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
	</div>
		<div id="loadmark"></div>
		<ol class="comment-list">
		<?php if ("desc" == get_option("comment_order"))echo '<div id="desc"></div>'; ?>
			<?php if ( have_comments() ){ ?>
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 74,
					'callback'=>'yefengs_theme_comment'
				) );
			?>
				<?php } // have_comments() ?>
		<?php if ("desc" != get_option("comment_order"))echo '<div id="desc"></div>';?>
		</ol><!-- .comment-list -->
		<?php if ( get_comment_pages_count() > 1 && get_option('page_comments') && have_comments() ) {  ?>
            <nav id="commentnav" role="navigation">
                <?php paginate_comments_links('prev_text=上页&next_text=下页');?>
            </nav>
        <?php  }?>
		<?php if ( ! comments_open() && get_comments_number() && have_comments() ) : ?>
			<p class="no-comments"><?php _e( 'Comments are closed.' , 'twentythirteen' ); ?></p>
		<?php endif; ?>
</div><!-- #comments -->
<div id="respond-form">
<div id="respond-title">添加一条新回复 <span class="gotop" style="float:right"><a href="#" title="回到最上面">回到顶部</a></span></div>
<?php if ('open' == $post->comment_status) { ?>
	<?php if ( get_option('comment_registration') && !$user_ID ) {?>
	<p id="commentinfo">亲爱的，您必须 <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">登录</a>后方可留言。</p>
	<?php } else { ?>
	<div id="respond">
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			<?php if ( $user_ID ) :?>
				<p id="commentinfo">亲爱的 <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a> 欢迎回来！<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="安全退出登录">退出登录</a></p>
			<?php else : ?>
			<p id="commentinfo">
					<?php if($comment_author): ?>
							亲爱的<?php echo $comment_author; ?>(<a href="javascript:showCommentAuthorInfo();" style="font-size:12px;">换马甲</a>)！<?php echo WelcomeCommentAuthorBack($comment_author_email); ?>
							<script type="text/javascript">jQuery(document).ready(function() {jQuery('#authorinfo').hide();jQuery('#commentinfo').show();});function showCommentAuthorInfo() {jQuery('#authorinfo').show();jQuery('#commentinfo').hide();}</script>
						<?php else: ?>
							告诉你一个秘密，只要填写<strong>昵称</strong>和<strong>邮箱</strong>就可以留言了...
						<?php endif; ?>
			</p>
				<div id="authorinfo">
				<p><label for="author">昵称:</label>
					<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="18" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> required/>
					</p>
				<p><label for="email">邮箱:</label>
					<input type="email" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="18" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> required/>
					</p>
				<p><label for="url">网址:</label>
					<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="18" tabindex="3" />
					</p>
					<div class="clearfix"></div>
				</div>
			<?php endif; ?>
			<div id="submitbox">
				<div id="c_textarea">
					<textarea name="comment" id="comment" tabindex="4" onkeydown="if(event.ctrlKey&amp;&amp;event.keyCode==13){document.getElementById('submit').click();return false};" placeholder="想给我说些什么 (*^__^*) 嘻嘻……"></textarea>
				</div>
				<div id="c_input">
					<input name="submit" type="submit" id="submit" tabindex="5" value="回复" />
					<?php cancel_comment_reply_link('取消回复'); ?>
				</div>
			</div>
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
		</form>
	</div>
	<?php } //end submit form
	} else { //comment from closed ?>
		<p id="commentinfo">亲爱的，主人已经关闭了这篇文章的评论 。</p>
	<? } //end commform  ?>


<div id="comment-bottom"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>

</div>
