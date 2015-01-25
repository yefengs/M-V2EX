

var addComment={moveForm:function(a,b,c,d){var e,f=this,g=f.I(a),h=f.I(c),i=f.I("cancel-comment-reply-link"),j=f.I("comment_parent"),k=f.I("comment_post_ID");if(g&&h&&i&&j){f.respondId=c,d=d||!1,f.I("wp-temp-form-div")||(e=document.createElement("div"),e.id="wp-temp-form-div",e.style.display="none",h.parentNode.insertBefore(e,h)),g.parentNode.insertBefore(h,g.nextSibling),k&&d&&(k.value=d),j.value=b,i.style.display="",i.onclick=function(){var a=addComment,b=a.I("wp-temp-form-div"),c=a.I(a.respondId);if(b&&c)return a.I("comment_parent").value="0",b.parentNode.insertBefore(c,b),b.parentNode.removeChild(b),this.style.display="none",this.onclick=null,!1};try{f.I("comment").focus()}catch(l){}return!1}},I:function(a){return document.getElementById(a)}};



function return_load() {
	ajax_coment_submit();
	AjaxCommentsLoad();

};


function ajax_coment_submit() {
	var $commentform = $('#commentform'),
	txt1 = '<span id="loading">正在提交, 请稍候...</span>',
	txt2 = '<span id="error">#</span>',
	txt3 = '">提交成功！',
	edt1 = '<a rel="nofollow" class="comment-reply-link coments-edit" href="#edit" onclick=\'return addComment.moveForm("',
	edt2 = ')\'>编辑</a>',
	cancel_edit = '取消编辑',
	edit,
	num = 1,
	$comments = $('.comments-title'),
	$cancel = $('#cancel-comment-reply-link'),
	cancel_text = $cancel.text(),
	$submit = $('#commentform #submit');
	$submit.attr('disabled', false),
	$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body'),
	comm_array = [];
	comm_array.push('');
	$('#c_input').append(txt1 + txt2);
	$('#loading').hide();
	$('#error').hide();
	$(document).off('submit', '#commentform');
	$(document).on("submit", "#commentform",
	function() {
		if (edit) $('#c_input').after('<input type="text" name="edit_id" id="edit_id" value="' + edit + '" style="display:none;" />');
		$submit.attr('disabled', true).fadeTo('slow', 0.5);
		$('#loading').slideDown();
		$.ajax({
			url: ajax_var.url,
			data: $(this).serialize() + "&action=ajax_comment",
			type: $(this).attr('method'),
			error: function(request) {
				$('#loading').hide();
				$("#error").slideDown().html(request.responseText);
				setTimeout(function() {
					$submit.attr('disabled', false).fadeTo('slow', 1);
					$('#error').slideUp();
				},
				5000);
			},
			success: function(data) {
				$('#loading').hide();
				comm_array.push($('#comment').val());
				$('textarea').each(function() {
					this.value = ''
				});
				var t = addComment,
				cancel = t.I('cancel-comment-reply-link'),
				temp = t.I('wp-temp-form-div'),
				respond = t.I(t.respondId),
				post = t.I('comment_post_ID').value,
				parent = t.I('comment_parent').value;
				if (!edit && $comments.length) {
					//跟新 coments-title中的数量
					n = parseInt($comments.text().match(/\d+/));
					$comments.text($comments.text().replace(n, n + 1));
				}
				new_htm = '" id="new_comm_' + num + '"></';
				new_htm = (parent == '0') ? ('\n<ol style="clear:both;" class="commentlist' + new_htm + 'ol>') : ('\n<ul class="children' + new_htm + 'ul>');
				ok_htm = '\n<span class="ajax-notice" id="success_' + num + txt3;
				div_ = (document.body.innerHTML.indexOf('div-comment-') == -1) ? '': ((document.body.innerHTML.indexOf('li-comment-') == -1) ? 'div-': '');
				ok_htm = ok_htm.concat(edt1, div_, 'comment-', parent, '", "', parent, '", "respond", "', post, '", ', num, edt2);
				ok_htm += '</span>\n';
				ok_htm += '</span>\n';
				if (parent == '0') {
					$('#desc').after(new_htm)
				} else {
					$('#respond').after(new_htm)
				};
				$('#new_comm_' + num).append(data);
				$('#new_comm_' + num + ' li .comment_info').append(ok_htm);
				$body.animate({
					scrollTop: $('#new_comm_' + num).offset().top - 50
				},
				900);
				countdown();
				num++;
				edit = '';
				$('*').remove('#edit_id');
				cancel.style.display = 'none';
				cancel.onclick = null;
				t.I('comment_parent').value = '0';
				if (temp && respond) {
					temp.parentNode.insertBefore(respond, temp);
					temp.parentNode.removeChild(temp)
				}
			}
		});
		return false;
	});
	addComment = {
		moveForm: function(commId, parentId, respondId, postId, num) {
			var t = this,
			div, comm = t.I(commId),
			respond = t.I(respondId),
			cancel = t.I('cancel-comment-reply-link'),
			parent = t.I('comment_parent'),
			post = t.I('comment_post_ID');
			if (edit) exit_prev_edit();
			num ? (t.I('comment').value = comm_array[num], edit = t.I('new_comm_' + num).innerHTML.match(/(comment-)(\d+)/)[2], $new_sucs = $('#success_' + num), $new_sucs.hide(), $new_comm = $('#new_comm_' + num), $new_comm.hide(), $cancel.text(cancel_edit)) : $cancel.text(cancel_text);
			t.respondId = respondId;
			postId = postId || false;
			if (!t.I('wp-temp-form-div')) {
				div = document.createElement('div');
				div.id = 'wp-temp-form-div';
				div.style.display = 'none';
				respond.parentNode.insertBefore(div, respond)
			} ! comm ? (temp = t.I('wp-temp-form-div'), t.I('comment_parent').value = '0', temp.parentNode.insertBefore(respond, temp), temp.parentNode.removeChild(temp)) : comm.parentNode.insertBefore(respond, comm.nextSibling);
			$body.animate({
				scrollTop: $('#respond').offset().top - 180
			},
			400);
			if (post && postId) post.value = postId;
			parent.value = parentId;
			cancel.style.display = '';
			cancel.onclick = function() {
				if (edit) exit_prev_edit();
				var t = addComment,
				temp = t.I('wp-temp-form-div'),
				respond = t.I(t.respondId);
				t.I('comment_parent').value = '0';
				if (temp && respond) {
					temp.parentNode.insertBefore(respond, temp);
					temp.parentNode.removeChild(temp);
				}
				this.style.display = 'none';
				this.onclick = null;
				return false;
			};
			try {
				t.I('comment').focus();
			} catch(e) {}
			return false;
		},
		I: function(e) {
			return document.getElementById(e);
		}
	};
	function exit_prev_edit() {
		$new_comm.show();
		$new_sucs.show();
		$('textarea').each(function() {
			this.value = ''
		});
		edit = '';
	}
	var wait = 15,
	submit_val = $submit.val();
	function countdown() {
		if (wait > 0) {
			$submit.val(wait);
			wait--;
			setTimeout(countdown, 1000);
		} else {
			$submit.val(submit_val).attr('disabled', false).fadeTo('slow', 1);
			wait = 15;
		}
	}

}; // end ajax commment submie

function AjaxCommentsLoad() {
	$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $("html") : $("body")) : $("html,body");
	$("#commentnav a").click(function() {
		var wpurl = $(this).attr("href").split(/(\?|&)yefengs=GetComments.*$/)[0];
		var commentPage = 1;
		if (/comment-page-/i.test(wpurl)) {
			commentPage = wpurl.split(/comment-page-/i)[1].split(/(\/|#|&).*$/)[0]
		} else if (/cpage=/i.test(wpurl)) {
			commentPage = wpurl.split(/cpage=/)[1].split(/(\/|#|&).*$/)[0]
		};
		var postId = $("#comments-title").attr("post-id");
		var url = wpurl.split(/#.*$/)[0];
		url += /\?/i.test(wpurl) ? "&": "?";
		url += "yefengs=GetComments&post=" + postId + "&page=" + commentPage;
		$.ajax({
			url: url,
			type: "GET",
			beforeSend: function() {
				$(".comment-list").css({
					cursor: "wait"
				});
				var C = 0.6;
				$(".comment-list").css({
					opacity: C,
					MozOpacity: C,
					KhtmlOpacity: C,
					filter: "alpha(opacity=" + C * 100 + ")"
				});
				var loading = '<div id="comment-loading">拼命加载...</div>';
				$("#commentnav").html(loading)
			},
			error: function(jqXHR, textStatus) {
				window.location.href = $(this).attr("href")
			},
			success: function(data) {
				$(".comment-list").remove();
				$("#commentnav").remove();
				$("#loadmark").after(data);
				var C = 1;
				$(".comment-list").css({
					opacity: C,
					MozOpacity: C,
					KhtmlOpacity: C,
					filter: 'alpha(opacity=' + C * 100 + ')'
				});
				$("#comment-loading").remove();
				$(".comment-list").css({
					cursor: "auto"
				});
				$body.animate({
					scrollTop: $("#loadmark").offset().top + -80
				},
				400);
				AjaxCommentsLoad()
			}
		});
		return false;
	});
};

jQuery(document).ready(function($){
	return_load();
});

