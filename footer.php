<footer id="footer">
	<section id="footer-info">
		<p> &copy; <?php echo date('Y'); ?>. <a href="<?php echo get_option('home'); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a>. All Rights Reserved.</p>
		<p>POWER BY WORDPRESS · <?php echo get_num_queries();?> QUERIES. <?php timer_stop(1);?> SECONDS· Lovingly made by OLIVIDA modify by <a href="http://yefengs.com/theme/m-v2ex" title="The Wordpress theme by yefengs">yefengs</a></p>
		<p><span style="color:#F56767">♥</span> Do have faith in what you're doing.</p>
	</section>
</footer>
<?php wp_footer(); ?>
</body>
</html>