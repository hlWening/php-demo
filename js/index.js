$(function(){
	//获取表格对象
	var g_table = $(".my-table");

	var gather_Fn = {
		xiushan_html: "<td><a class='revise' href='javascript:void(0);'>修改</a>&nbsp;&nbsp;&nbsp;<a class='del' href='javascript:void(0);'>删除</a></td>",
		baoqu_html: "<td><a class='save' href='javascript:void(0);'>保存</a>&nbsp;&nbsp;&nbsp;<a class='cancel' href='javascript:void(0);'>取消</a></td>",
		quequ_html: "<a class='save_revise' href='javascript:void(0);'>确认</a>&nbsp;&nbsp;&nbsp;<a class='cancel_revise' href='javascript:void(0);'>取消</a>",
		jia_html: "<tr><td colspan='8'><a class='add' href='javascript:void(0);'>添加</a></tr>",
		common_ajax: function(type_, url_, data_, callback_fun){
			$.ajax({
				type: type_,
				url: url_,
				data: data_,
				dataType: 'json',
//				contentType: 'text/html',
				success: function(res){
					callback_fun(res);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					alert(errorThrown);
				},
				async: true
			})
		},
		init: function(){
			gather_Fn.getdata_fn();
			gather_Fn.event_fn();
		},
		create_row: function(data_item,opt_html){
			var $tr = $("<tr dataid="+data_item.id+"></tr>");
			for(var k in data_item){
				if (k != 'id') {
					$tr.append("<td><input data-val="+k+" type='text' value="+data_item[k]+"></td>");
				}
			}
			$tr.append(opt_html);
			return $tr;
		},
		//页面打开获取数据
		getdata_fn: function(){
			gather_Fn.common_ajax('get', 'data.php?action=init_data_list', '', function(res){
				for(var i = 0, j = res.length; i < j; i++){
					var data_dom = gather_Fn.create_row(res[i], gather_Fn.xiushan_html);
					g_table.append(data_dom);
				}
				g_table.append(gather_Fn.jia_html);
			});
		},
		//点击添加
		adddata_fn: function(){
			var $this_tr = $(this).closest('tr');
			$(this).parent().remove();
			//$(this).parentNode.remove();
//			$this_tr.addClass('edit').append(gather_Fn.create_row(undefined, gather_Fn.baoqu_html));
			$this_tr.addClass('edit').append("<td><input data-val='name' type='text'></td><td><input data-val='sex' type='text'></td>"+
			"<td><input data-val='brithday' type='text'></td><td><input data-val='job' type='text'></td>"+
			"<td><input data-val='salary' type='text'></td><td><input data-val='jieshao' type='text'></td>").append(gather_Fn.baoqu_html);
		},
		//点击保存数据
		savedata_fn: function(){
			var $this_tr = $(this).closest('tr'),
					data = {};
				data.name     = $this_tr.find('[data-val="name"]').val(),
				data.sex      = $this_tr.find('[data-val="sex"]').val(),
				data.brithday = $this_tr.find('[data-val="brithday"]').val(),
				data.job      = $this_tr.find('[data-val="job"]').val(),
				data.salary   = $this_tr.find('[data-val="salary"]').val(),
				data.jieshao  = $this_tr.find('[data-val="jieshao"]').val();
				gather_Fn.common_ajax('post', 'data.php?action=add_row', data, function(res){
					if (res.state == 1) {
						$this_tr.remove();
						g_table.append(gather_Fn.create_row(data, gather_Fn.xiushan_html));
						g_table.append(gather_Fn.jia_html);
					} else {
						alert(res.detail);
					}
				});
		},
		//取消添加数据
		cancel_fn: function(){
			$this_tr.remove();
			g_table.append(gather_Fn.jia_html);
		},
		//修改数据按钮
		revise_fn: function(){
			var $this_tr = $(this).closest('tr');
			$this_tr.addClass('edit');
			$(this).closest('td').html(gather_Fn.quequ_html);
		},
		//删除数据
		del_fn: function(){
			var $this_tr = $(this).closest('tr');
			var this_id = parseInt($this_tr.attr('dataid'));
			gather_Fn.common_ajax('post', 'data.php?action=del_row', {id: this_id}, function(res){
				if (res.state == 1) {
					$this_tr.remove();
				} else {
					alert(res.detail);
				}
			});
		},
		event_fn: function(){
			$("body").on('click', '.add', gather_Fn.adddata_fn);
			$("body").on('click', '.save', gather_Fn.savedata_fn);
			$("body").on('click', '.cancel', gather_Fn.cancel_fn);
			$("body").on('click', '.del', gather_Fn.del_fn);
			$("body").on('click', '.revise', gather_Fn.revise_fn);
		}
	};
	gather_Fn.init();







})
