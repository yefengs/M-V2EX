<?php 
/*
**
*
* @auther:yefengs.com
**
*
*
*
*
*
*/



//add_filter( 'the_content', 'pre_content_filter', 0 );
/**
 * 转换pre标签中的html代码
 *
 * 使用'the_content'钩子.
 *
 * @author c.bavota
 */
function pre_content_filter( $content ) {
	return preg_replace_callback( '|<pre.*>(.*)</pre|isU' , 'convert_pre_entities', $content );
}

function convert_pre_entities( $matches ) {
	return str_replace( $matches[1], htmlentities( $matches[1] ), $matches[0] );
}




function twentythirteen_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array('audio', 'gallery', 'image', 'status') );
	register_nav_menu( 'primary','Top Menu');
	register_nav_menu( 'tag_Menu','tag Menu');
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 604, 270, true );
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'twentythirteen_setup' );

add_filter( 'pre_option_link_manager_enabled', '__return_true' );

function remove_open_sans() {
	wp_deregister_style( 'open-sans' );
	wp_register_style( 'open-sans', false );
	wp_enqueue_style('open-sans','');
}
add_action( 'init', 'remove_open_sans' );

$yefengsbg = array('default-color' => 'f6deba','random-default' => false,'flex-height' => false,'flex-width' => false,);
add_theme_support( 'custom-background', $yefengsbg );

  add_image_size('xiangce1', 470, 270); // 别名为 thumb， 尺寸为 150x150 的设定
  add_image_size('xiangce2', 235, 235); // 别名为 recommend， 尺寸为 120x120 的
  add_image_size('xiangce3', 150, 150);

function entry_date( $echo = true ) {
	$format_prefix = '%2$s';
	$date = sprintf( '<time class="date updated" role="update" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);
	if ( $echo )
		echo $date;
	return $date;
}

function yefengs_widgets_init() {
	register_sidebar( array(
		'name' => __( '侧边栏', 'twentytwelve' ),
		'id' => 'sidebar-1',
		'description' => __( '这个是位于右侧的小工具栏~', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'yefengs_widgets_init' );


function post_time_ago( $type = 'post' ) {$d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';echo  human_time_diff($d('U'),current_time('timestamp')),'前';}

function comment_time_ago( $type = 'commennt', $day = 30 ) { $d = $type == 'post' ? 'get_post_time' : 'get_comment_time';    $timediff = time() - $d('U');    if ($timediff <= 60*60*24*$day){ echo  human_time_diff($d('U'), strtotime(current_time('mysql', 0))), '前';    }    if ($timediff > 60*60*24*$day){  echo  date('Y/m/d',get_comment_date('U')), ' ', get_comment_time('H:i');    };  }


add_filter('the_content', 'slimbox', 12);
add_filter('get_comment_text', 'slimbox');
function slimbox ($content) { 
	global $post;
	$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
	$replacement = '<a$1href=$2$3.$4$5 id="pirobox_gall_'.$post->ID.'" data-slimbox="slimbox" $6>$7</a>';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}



/** 
* wordpress pre html special chars 
* @author yefengs 
* @link http://os.yefengs.com/wordpress-pre-tag-content-displayed-in-an-escape.html 
* @var 1.0.0 
* @package WordPress pre  
* @subpackage yefengs 
* @since 2014-12-22 
* @return string */ 
add_filter('the_content', 'htmlspecialchars_pre', 12); 
add_filter('get_comment_text', 'htmlspecialchars_pre'); 

// function htmlspecialchars_pre ($content) { 
//     return preg_replace_callback ("/<pre>(.*?)<\/pre>/si", create_function('$matches','return "<pre>" . htmlspecialchars($matches[1]) ."</pre>";'),$content);
// }



function htmlspecialchars_pre ($content) {  
	
	return preg_replace_callback ("/<pre>(.*?)<\/pre>/si", create_function('$matches','return "<"."pre".">". htmls_pecial_chars($matches[1]) ."</pre>";'),$content); 

}

function htmls_pecial_chars($content=''){
	//htmlspecialchars_decode() 
	$content = str_replace("&","&amp;",$content);
	$content = str_replace("<","&lt;",$content);
	$content = str_replace(">","&gt;",$content);
	$content = str_replace('"',"&quot;",$content);
	$content = str_replace("'","&#039;",$content);
	$content = str_replace("	","&nbsp;&nbsp;&nbsp;&nbsp;",$content);
	$content = str_replace(" ","&nbsp;",$content);
return $content;
}


function zfunc_comments_users($postid=0,$which=0) {
	$comments = get_comments('status=approve&type=comment&post_id='.$postid); //获取文章的所有评论
	if ($comments) {
		$i=0; $j=0; $commentusers=array();
		foreach ($comments as $comment) {
			++$i;
			if ($i==1) { $commentusers[] = $comment->comment_author_email; ++$j; }
			if ( !in_array($comment->comment_author_email, $commentusers) ) {
				$commentusers[] = $comment->comment_author_email;
				++$j;
			}
		}
		$output = array($j,$i);
		$which = ($which == 0) ? 0 : 1;
		return $output[$which]; //返回评论人数
	}
	return 0; //没有评论返回0
}


//访问统计
/* 访问计数 */
function record_visitors()
{
	if (is_singular()) 
	{
	  global $post;
	  $post_ID = $post->ID;
	  if($post_ID) 
	  {
		  $post_views = (int)get_post_meta($post_ID, 'views', true);
		  if(!update_post_meta($post_ID, 'views', ($post_views+1))) 
		  {
			add_post_meta($post_ID, 'views', 1, true);
		  }
	  }
	}
}
add_action('wp_head', 'record_visitors');  
 

function example_wp_handle_upload_prefilter($file){
  date_default_timezone_set('PRC');
  $time=date("dHis");
  $time = 'leyaep'.$time;
  $file['name'] = $time.".".pathinfo($file['name'] , PATHINFO_EXTENSION);
  return $file;
}
add_filter('wp_handle_upload_prefilter', 'example_wp_handle_upload_prefilter');


/// 函数名称：post_views 
/// 函数作用：取得文章的阅读次数
function post_views($before = '', $after = ' views', $echo = 1)
{
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID, 'views', true);
  if ($echo) echo $before, number_format($views), $after;
  else return $views;
}



function get_ssl_avatar($avatar) {
   $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2">',$avatar);
   return $avatar;
}
add_filter('get_avatar', 'get_ssl_avatar');



function get_all_post_nav_num(){
		if ( is_singular() ) return;
		global $wp_query, $paged;
		$max_page = $wp_query->max_num_pages;
		if ( $max_page == 1 ) return; 
		if ( empty( $paged ) ) $paged = 1;
		echo '<div class="all-post-page" >' . $paged . '/<span class="totalpage">' . $max_page . '</span></div>'; 
}


function cut_string($string, $sublen, $start = 0, $code = 'UTF-8'){if($code == 'UTF-8'){$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/"; preg_match_all($pa, $string, $t_string);if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."..."; return join('', array_slice($t_string[0], $start, $sublen));}else{$start = $start*2;$sublen = $sublen*2;$strlen = strlen($string);$tmpstr = '';for($i=0; $i<$strlen; $i++){if($i>=$start && $i<($start+$sublen)){if(ord(substr($string, $i, 1))>129) $tmpstr.= substr($string, $i, 2);else $tmpstr.= substr($string, $i, 1);}if(ord(substr($string, $i, 1))>129) $i++;}if(strlen($tmpstr)<$strlen ) $tmpstr.= "...";return $tmpstr;}}

function WelcomeCommentAuthorBack($email = ''){
	  if(empty($email)){
		return;
	  }
	  global $wpdb;
	  $past_30days = gmdate('Y-m-d H:i:s',((time()-(24*60*60*30))+(get_option('gmt_offset')*3600)));
	  $sql = "SELECT count(comment_author_email) AS times FROM $wpdb->comments
			  WHERE comment_approved = '1'
			  AND comment_author_email = '$email'
			  AND comment_date >= '$past_30days'";
	  $times = $wpdb->get_results($sql);
	  $times = ($times[0]->times) ? $times[0]->times : 0;
	  $message = $times ? sprintf(__('在过去的一个多月里你居然有<strong>%1$s</strong>次留言，你太给力了！' ), $times) : '我猜你肯定很久没来看我了，肯定想我了，你想说些什么秘密呢？';
	  return $message;
	}

function checkadmin(){
	$adminEmail = get_option('admin_email');
	if(get_comment_author_email() == $adminEmail ){
		return true;
	}else{
		return false;
   }
}

function yefengs_comment_text( $comment_text ) {
	$comment = get_comment( $comment_ID );
	echo apply_filters( 'comment_text', $comment_text, $comment );
}


function yefengs_theme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; 

	global $commentcount;
 
	if(!$commentcount) { //初始化楼层计数器
 
		$page = get_query_var('cpage')-1;
 
		$cpp=get_option('comments_per_page');//获取每页评论数
 
		$commentcount = $cpp * $page;
 
	}

  ?>
  <li <?php comment_class(); ?> >
	<div class="comment-lists  <?php if ($depth >= '2') { echo 'left30';} ?>" id="comment-<?php comment_ID() ?>">
		<section  class="y_avatar">
			<?php echo get_avatar( get_comment_author_email(), '48'); ?>
		</section>
		<section class="comment_con">
			<div class="comment_info">  
			<cite class="vcard"><strong><a class="linkforavater <?php if(checkadmin()) {echo "admin"; }?>" href="<?php  if (get_comment_author_url()) 
		echo esc_url( home_url( '/' ) ).'?home='. base64_encode(get_comment_author_url()); 
		else  echo "javascript:;"; ?>" title=" <?php echo get_comment_author(); ?> " target="_blank" rel="external nofollow" ><?php echo get_comment_author(); ?></a></strong></cite>
			<span class="commentinfo"><?php comment_time_ago();?>&nbsp; <?php comment_reply_link( array_merge( $args, array( 'reply_text' => '回复','login_text' =>'回复', 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
			   <?php if(!$parent_id = $comment->comment_parent) {printf('%1$s', ++$commentcount);} ?>

		  </div>
		<p>
			<?php if($comment->comment_parent){// 如果存在父级评论   
				$comment_parent_href = htmlspecialchars(get_comment_link( $comment->comment_parent ));   
				$comment_parent = get_comment($comment->comment_parent);    
				$_content ='<span class="at">＠'.$comment_parent->comment_author.'</span>';
				$_content = $_content.get_comment_text();
				yefengs_comment_text($_content);
			 } else{
			comment_text();
			} ?>
		</p>
		</section>
		<div class="clearfix"></div>
	</div>
<?php }


/* Ajax无限评论翻页 by winy */
function AjaxCommentsPage() {
  if ( isset($_GET["yefengs"]) && $_GET["yefengs"] == "GetComments" ) {
	global $post,$wp_query, $wp_rewrite;
	$postid = isset($_GET["post"]) ? $_GET["post"] : null;
	$pageid = isset($_GET["page"]) ? $_GET["page"] : null;
	if ( !$postid || !$pageid ) {
	  fail(__("Error post id or comment page id."));
	}
	// get comments
	$comments = get_comments("post_id=" . $postid);
	$post = get_post($postid);
	if ( !$comments ) {
	  fail(__("啊哈~居然没有评论"));
	}
	if( "desc" != get_option("comment_order") ){
	  $comments = array_reverse($comments);
	}
	// set as singular (is_single || is_page || is_attachment)
	$wp_query->is_singular = true;
	// base url of page links
	$baseLink = "";
	if ( $wp_rewrite->using_permalinks() ) {
	  $baseLink = user_trailingslashit(get_permalink($postid) . "/comment-page-%#%", "commentpaged");
	}
	// response 下一行WinyskyComments注意修改callback为你自己的回调函数 
	echo '<ol class="comment-list">';
	if ("desc" == get_option("comment_order"))echo '<div id="desc"></div>';
	wp_list_comments("type=comment&callback=yefengs_theme_comment&page=" . $pageid . "&per_page=" . get_option("comments_per_page"), $comments);
	if ("desc" != get_option("comment_order"))echo '<div id="desc"></div>';
	echo '</ol>';
	echo '<nav id="commentnav" role="navigation">';
	paginate_comments_links('prev_text=上页&next_text=下页&current=' . $pageid . $baseLink);
	echo "</nav>";
	die;
  } else {
	return;
  }
}
add_action('init', 'AjaxCommentsPage');


// comment_mail_notify v1.0 by willin kan. (所有回覆都發郵件)
function comment_mail_notify($comment_id) {
		$comment = get_comment($comment_id);
		$parent_id = $comment->comment_parent ? $comment->comment_parent : '';
		$spam_confirmed = $comment->comment_approved;
		if (($parent_id != '') && ($spam_confirmed != 'spam')) {
		$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); //e-mail 發出點, no-reply 可改為可用的 e-mail.
		$to = trim(get_comment($parent_id)->comment_author_email);
	  $subject = ' [' . get_option("blogname") . '] 的信使';
		$message = '<div style="background-color:#fff; border:1px solid #666666; color:#111;border-radius:8px; font-size:13px; width:702px; margin:0 auto; margin-top:10px; font-family:微软雅黑, Arial;">
		 <div style="background:#666666; width:100%; height:60px; color:white; border-radius:6px 6px 0 0; "><span style="height:60px; line-height:60px; margin-left:30px; font-size:20px;">您在<a style="text-decoration:none; color:#00bbff;font-weight:600;" href="' . get_option('home') . '" target="_blank">' . get_option('blogname') . '</a>博客上的留言有回复啦！</span></div>
		 <div style="width:90%; margin:0 auto">
		 <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
		 <p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:</p>
		 <p style="background-color: #EEE;border: 1px solid #DDD;padding: 10px 5px;margin: 15px 0;">'
		 . trim(get_comment($parent_id)->comment_content) . '</p>
		 <p>' . trim($comment->comment_author) . ' 给您的回复:</p>
		 <p style="background-color: #EEE;border: 1px solid #DDD;padding:10px 5px;margin: 15px 0;">
		  '. trim($comment->comment_content) . '</p>
		 <p>您可以点击 <a style="text-decoration:none; color:#00bbff" href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看回复的完整內容</a></p>
		  <p>欢迎再次光临 <a style="text-decoration:none; color:#00bbff" href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
		 <p style="color:red;">(温馨提示：本邮件由系统自动发出，切勿回复)</p>
		  </div>
		 </div>';
		$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
		$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
		wp_mail( $to, $subject, $message, $headers );
			}
	  } add_action('comment_post', 'comment_mail_notify');

/* -----------------------------------------------
<<小牆>> Anti-Spam v1.9 by Willin Kan.
*/
//建立
class anti_spam {
  function anti_spam() {
	if ( !is_user_logged_in() ) {
	  add_action('template_redirect', array($this, 'w_tb'), 1);
	  add_action('pre_comment_on_post', array($this, 'gate'), 1);
	  add_action('preprocess_comment', array($this, 'sink'), 1);
	}
  }
  //設欄位
  function w_tb() {
	if ( is_singular() ) {
	  ob_start(create_function('$input', 'return preg_replace("#textarea(.*?)name=([\"\'])comment([\"\'])(.+)/textarea>#",
	  "textarea$1name=$2w$3$4/textarea><textarea name=\"comment\" cols=\"60\" rows=\"4\" style=\"display:none\"></textarea>", $input);') );
	}
  }
  //檢查
  function gate() {
	( !empty($_POST['w']) && empty($_POST['comment']) ) ? $_POST['comment'] = $_POST['w'] : $_POST['spam_confirmed'] = 1;
  }
  //處理
  function sink( $comment ) {
	if ( !empty($_POST['spam_confirmed']) ) {
	  //方法一:直接擋掉, 將 die(); 前面兩斜線刪除即可.
	  //die();
	  //方法二:標記為spam, 留在資料庫檢查是否誤判.
	  add_filter('pre_comment_approved', create_function('', 'return "spam";'));
	  $comment['comment_content'] = "[ 可能是垃圾评论! ]\n " . $comment['comment_content'];
	}
	return $comment;
  } 
}
$anti_spam = new anti_spam();

function yefengs_the_content_nofollow($content) {
	preg_match_all('/href="(.*?)"/', $content, $matches);
	if ($matches) {
		foreach ($matches[1] as $val) {
			if (strpos($val, home_url()) === false) {
			  $val= esc_url( home_url( '/' ) ).'?home='. base64_encode($val);
				$content = str_replace("href=\"{$val}\"", "href=\"{$val}\" rel=\"external nofollow\" class=\"externall\"", $content);
			}
		}
	}
	return $content;
}
add_filter('the_content', 'yefengs_the_content_nofollow', 999);
add_filter('get_comment_text', 'slimbox');
/**
* @author yefengs
* @version 1.1
*
*
*/


add_action('wp_ajax_nopriv_ajax_comment', 'ajax_comment');
add_action('wp_ajax_ajax_comment', 'ajax_comment');
function ajax_comment(){
	global $wpdb;
	//nocache_headers();
	$comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;
	$post = get_post($comment_post_ID);
	$post_author = $post->post_author;
   if ( empty($post->comment_status) ) {
		do_action('comment_id_not_found', $comment_post_ID);
		ajax_comment_err('Invalid comment status.');
	}
	$status = get_post_status($post);
	$status_obj = get_post_status_object($status);
	if ( !comments_open($comment_post_ID) ) {
		do_action('comment_closed', $comment_post_ID);
		ajax_comment_err('Sorry, comments are closed for this item.');
	} elseif ( 'trash' == $status ) {
		do_action('comment_on_trash', $comment_post_ID);
		ajax_comment_err('Invalid comment status.');
	} elseif ( !$status_obj->public && !$status_obj->private ) {
		do_action('comment_on_draft', $comment_post_ID);
		ajax_comment_err('Invalid comment status.');
	} elseif ( post_password_required($comment_post_ID) ) {
		do_action('comment_on_password_protected', $comment_post_ID);
		ajax_comment_err('Password Protected');
	} else {
		do_action('pre_comment_on_post', $comment_post_ID);
	}
	$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
	$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
	$comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
	$comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
	$edit_id              = ( isset($_POST['edit_id']) ) ? $_POST['edit_id'] : null; // 提取 edit_id
	$user = wp_get_current_user();
	if ( $user->exists() ) {
		if ( empty( $user->display_name ) )
			$user->display_name=$user->user_login;
		$comment_author       = $wpdb->escape($user->display_name);
		$comment_author_email = $wpdb->escape($user->user_email);
		$comment_author_url   = $wpdb->escape($user->user_url);
		$user_ID              = $wpdb->escape($user->ID);
		if ( current_user_can('unfiltered_html') ) {
			if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment'] ) {
				kses_remove_filters();
				kses_init_filters();
			}
		}
	} else {
		if ( get_option('comment_registration') || 'private' == $status )
			ajax_comment_err('哈哈哈~你必须登陆后才可以留言的说.');
	}
	$comment_type = '';
	if ( get_option('require_name_email') && !$user->exists() ) {
		if ( 6 > strlen($comment_author_email) || '' == $comment_author )
			ajax_comment_err( '哈哈~~你必须输入昵称和邮箱才可以留言' );
		elseif ( !is_email($comment_author_email))
			ajax_comment_err( '鄙视你！你居然连邮箱地址都输不正确~' );
	}
	if ( '' == $comment_content )
		ajax_comment_err( '出错啦~~难道你就没有话想说嘛~' );
	$dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
	if ( $comment_author_email ) $dupe .= "OR comment_author_email = '$comment_author_email' ";
	$dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
	if ( $wpdb->get_var($dupe) ) {
		ajax_comment_err('貌似，大概，好像你说过这句话了~');
	}
	if ( $lasttime = $wpdb->get_var( $wpdb->prepare("SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author) ) ) {
		$time_lastcomment = mysql2date('U', $lasttime, false);
		$time_newcomment  = mysql2date('U', current_time('mysql', 1), false);
		$flood_die = apply_filters('comment_flood_filter', false, $time_lastcomment, $time_newcomment);
		if ( $flood_die ) {
			ajax_comment_err('你说的太快了，不着急，慢慢说~');
		}
	}
	$comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;
	$commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');

	if ( $edit_id )
{
	$comment_id = $commentdata['comment_ID'] = $edit_id;
	if( ihacklog_user_can_edit_comment($commentdata,$comment_id) )
	{  
		wp_update_comment( $commentdata );
	}
	else
	{
		ajax_comment_err( 'Cheatin&#8217; uh? ' );
	}

}
else
{
$comment_id = wp_new_comment( $commentdata );
}

	$comment = get_comment($comment_id);
	do_action('set_comment_cookies', $comment, $user);
	$comment_depth = 1;
	$tmp_c = $comment;
	while($tmp_c->comment_parent != 0){
		$comment_depth++;
		$tmp_c = get_comment($tmp_c->comment_parent);
	}
	$GLOBALS['comment'] = $comment;
	?>
  <li <?php comment_class(); ?> >
	<div class="comment-lists  <?php if ($depth >= '2') { echo 'left30';} ?>" id="comment-<?php comment_ID() ?>">
		<section  class="y_avatar">
			<?php echo get_avatar( get_comment_author_email(), '48'); ?>
		</section>
		<section class="comment_con">
			<div class="comment_info">  
			<cite class="vcard"><strong><a class="linkforavater <?php if(checkadmin()) {echo "admin"; }?>" href="<?php  if (get_comment_author_url()) 
		echo esc_url( home_url( '/' ) ).'?home='. base64_encode(get_comment_author_url()); 
		else  echo "javascript:;"; ?>" title=" <?php echo get_comment_author(); ?> " target="_blank" rel="external nofollow" ><?php echo get_comment_author(); ?></a></strong></cite>
			<span class="commentinfo"><?php comment_time_ago();?>&nbsp; </span>
			   <?php if(!$parent_id = $comment->comment_parent) {printf('%1$s', ++$commentcount);} ?>

		  </div>
		<p>
			<?php if($comment->comment_parent){// 如果存在父级评论   
				$comment_parent_href = htmlspecialchars(get_comment_link( $comment->comment_parent ));   
				$comment_parent = get_comment($comment->comment_parent);    
				$_content ='<span class="at">＠'.$comment_parent->comment_author.'</span>';
				$_content = $_content.get_comment_text();
				yefengs_comment_text($_content);
			 } else{
			comment_text();
			} ?>
		</p>
		</section>
		<div class="clearfix"></div>
	</div>

	<?php die();

}
function ajax_comment_err($a) {
	header('HTTP/1.0 500 Internal Server Error');
	header('Content-Type: text/plain;charset=UTF-8');
	echo $a;
	exit;
}

function ihacklog_user_can_edit_comment($new_cmt_data,$comment_ID = 0) {
	if(current_user_can('edit_comment', $comment_ID)) {
		return true;
	}
	$comment = get_comment( $comment_ID );
	$old_timestamp = strtotime( $comment->comment_date);
	$new_timestamp = current_time('timestamp');
	// 不用get_comment_author_email($comment_ID) , get_comment_author_IP($comment_ID)
	$rs = $comment->comment_author_email === $new_cmt_data['comment_author_email']
			&& $comment->comment_author_IP === $_SERVER['REMOTE_ADDR']
				&& $new_timestamp - $old_timestamp < 3600;
	return $rs;
}



function likescript() {
	//if (!is_admin()) {
	wp_enqueue_script('like_post', get_template_directory_uri()."/js/mv2ex.js?v=20141122",'',false,true);//}
	wp_localize_script('like_post', 'ajax_var', array(
		'url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('ajax-nonce')
	));
}
add_action('wp_enqueue_scripts', 'likescript');



function gohome() {
	if ( isset($_GET['home'])) {
	$str = $_GET["home"];
	if ($str == base64_encode(base64_decode($str)) && !empty($str)) {
		header('location:'.base64_decode($str));
	}else{
	  $str=$_SERVER["HTTP_REFERER"];
	  header('location:'.$str);
	}
	}
}
add_action('init', 'gohome');