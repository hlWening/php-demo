$(function(){

	var gather_Fn = {
		common_ajax: function(type_, url_, data_, callback_fun){
			$.ajax({
				type: type_,
				url: url_,
				data: data_,
				dataType: 'json',
//				contentType: 'application/json',
				success: function(res){
					callback_fun(res);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					alert(errorThrown);
				},
				async: true
			})
		},
		data_verify: function(parent){
			var user = $(parent).find('input[data-verify="user"]').get(0).value,
				pwd = $(parent).find('input[data-verify="pwd"]').get(0).value;
			var userres = false;
			if ((user != '')&&(pwd != '')) {
				var userreg = /^[\u4E00-\u9FA5A-Za-z0-9_]+$/,
					pwdreg = /((?=.*[0-9])(?=.*[a-z])|(?=.*[0-9])(?=.*[A-Z])|(?=.*[a-z])(?=.*[A-Z]))^[0-9a-zA-Z_\.]{6,12}$/;
					if (!userreg.test(user)) {
						alert('请输入正确的用户名！');
					} else {
						if (!pwdreg.test(pwd)) {
							alert('请输入6到12位至少包含数字、大小写字母中两种的密码！');
						} else {
							if (parent == '.register') {
								var pwd1 = $(parent).find('input[type="password"]').eq(0).get(0).value,
									pwd2 = $(parent).find('input[type="password"]').eq(1).get(0).value;
								if (pwd1 != pwd2) {
									alert('密码不一致！');
								} else {
									userres = true;
								}
							} else {
								userres = true;
							}
						}
					}
			} else {
				if (user == '') {
					alert('请输入正确的用户名！');
				} else if (pwd == '') {
					alert('请输入6到12位至少包含数字、大小写字母中两种的密码！');
				} else {
					alert('请输入用户名和密码！');
				}
			}
			return userres;
		},
		//登录事件
		login_fn: function(){
			var user = $('.login').find('input[data-verify="user"]').get(0).value,
				pwd = $('.login').find('input[data-verify="pwd"]').get(0).value;
			if (gather_Fn.data_verify('.login')) {
				gather_Fn.common_ajax('post', 'login.php', {username: user, userpwd: pwd}, function(data){
					if (data.state > 0) {
						window.location.href='index.php';
					} else {
						alert(data.detail);
					}
				})
			}
		},
		//注册事件
		register_fn: function(){
			var user = $('.register').find('input[data-verify="user"]').get(0).value,
				pwd = $('.register').find('input[data-verify="pwd"]').get(0).value;
			if (gather_Fn.data_verify('.register')) {
				gather_Fn.common_ajax('post', 'register.php', {username: user, userpwd: pwd}, function(data){
					if (data.state > 0) {
						window.location.href='index.php';
					} else {
						alert(data.detail);
					}
				})
			}
		},
		event_fn: function(){
			$("body").on('click', '.login .btn', gather_Fn.login_fn);
			$("body").on('click', '.register .btn', gather_Fn.register_fn);
		}
	};
	gather_Fn.event_fn();
})
