<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title></title>
		<style>
			.my-table {
				width: 100%;
				border: 1px solid darkblue;
				border-right: 0px;
				border-top: 0px;
			}
			.my-table tr {
				line-height: 40px;
			}
			.my-table th,
			.my-table td {
				text-align: center;
				font-size: 16px;
				border-right: 1px solid darkblue;
				border-top: 1px solid darkblue;
			}
			.my-table tr input {
				width: 80px;
				height: 24px;
				vertical-align: 16%;
				border: 0px;
			}
			.my-table tr.edit input {
				width: 110px;
				border: 1px solid #e5e5e5;
			}
		</style>
	</head>
	<body>

		<table class="my-table" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>name</th>
					<th>sex</th>
					<th>brithday</th>
					<th>job</th>
					<th>salary</th>
					<th>jieshao</th>
					<!--<th>id</th>-->
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="8"><a class="add" href="javascript:void(0);"></a></td>
				</tr>
			</tbody>
		</table>
		<input id="t1" type="text" />
 			<button>开始倒计时吧</button>
		<script src="js/jquery-1.8.3.min.js"></script>
		<script src="js/index.js"></script>
		<script>
				var oText = document.getElementById('t1');
			    var oBtn = document.getElementsByTagName('button');

			    var timer = null;
			    oBtn[0].onclick = function(){
			    	var _this = this;
			    	var num = 60;
			        clearInterval(timer);
			    	timer = setInterval(function(){
			    		if (num > 0) {
			    			oText.value = --num;
							_this.setAttribute('disabled', true);
			    		} else {
			    			oText.value = '请重新点击';
			    			_this.removeAttribute('disabled');
			    		}
			        }, 1000)
			    }
		</script>
	</body>
</html>
