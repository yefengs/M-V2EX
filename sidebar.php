<?php
 global $user_ID, $user_identity, $user_email, $user_login;
  get_currentuserinfo();
  if (!$user_ID) {
?>
<aside class="widget admin-manage">
	<h3 class="widget-title">User Login</h3>
	<div class="widget-content">
	<form id="loginform" action="<?php echo get_settings('siteurl'); ?>/wp-login.php" method="post">
		<div id="logininput">
			<p class="logininput"><label for="log">Username</label><input class="login" type="text" name="log" id="log" value="" size="12" /></p>
			<p class="logininput"><label for="pwd">Password</label><input class="login" type="password" name="pwd" id="pwd" value="" size="12" /></p>
			<p style="text-align:center">
				<input class="denglu" type="submit" name="submit" value="Submit" />
				<label class="rememberme"><input id="comment_mail_notify" type="checkbox" name="rememberme" value="forever" /> Remember me</label> 
			</p>
		</div>
		<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
	</form>
	</div>
</aside>

<?php } 
else { ?>

<aside class="widget admin-manage">
	<h3 class="widget-title">Management</h3>
	<div class="widget-content">
	    <div id="adminbox_avatar">
	        <div id="admin-gravator">
	        	<?php echo get_avatar($user_email, 48); ?>
	        </div>
	        <div id="admin-name"><?php echo $user_identity; ?></div>
	    </div>
	    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tbody>
        		<tr>
				<td width="33%" align="center"><span class="bigger"><?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish;?></span><div class="sep3"></div><span class="fade">Posts</span></td>
<?php

	$text=0;
	$num_comm = wp_count_comments();
	if ( $num_comm && $num_comm->total_comments ) {
	$text = sprintf( _n( '%s', '%s', $num_comm->total_comments ), number_format_i18n( $num_comm->total_comments ) );
	}
	?>
				<td width="34%" align="center" style="border-left: 1px solid rgba(100, 100, 100, 0.4); border-right: 1px solid rgba(100, 100, 100, 0.4);"><span class="bigger"><?php echo $text;  ?></span><div class="sep3"></div><span class="fade">Comments</span></td>
				<td width="33%" align="center"><span class="bigger"><?php echo $count_tags = wp_count_terms('post_tag'); ?></span><div class="sep3"></div><span class="fade">Tags</span></td>
               </tr>
        </tbody>
        </table>

	    <div id="admin_li">
	      <a href="<?php bloginfo('url') ?>/wp-admin/">控制面板</a> | 
	      <a href="<?php bloginfo('url') ?>/wp-admin/post-new.php">撰写文章</a> | 
	      <a href="<?php bloginfo('url') ?>/wp-admin/edit-comments.php">评论管理</a> | 
	      <a href="<?php echo wp_logout_url(get_option('siteurl')); ?>" title="注销登录啦~">注销</a>
	    </div>
	</div>
</aside>
<?php } ?>

<?php dynamic_sidebar('侧边栏'); ?>
