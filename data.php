<?php
//	header("Content-type:text/html;charset=utf-8");

	//定义返回结果数组
	$res = [
		'state' => 0,
		'detail' => ''
	];

	//配置路由
	$action = $_GET['action'];
	switch($action){
		case 'init_data_list':
			init_data_list();
			break;
		case 'add_row':
			add_row();
			break;
		case 'del_row':
			del_row();
			break;
		case 'revise_row':
			edit_row();
			break;
		default:
			break;
	}

	function common_fn() {
		$conn = mysqli_connect('localhost', 'root', '');
		if (mysqli_errno($conn)) {
	        echo mysqli_errno($conn);
	        exit;
	    }
	    mysqli_select_db($conn,"my_sql_test");
	    mysqli_set_charset($conn,'utf8');
	    // func_get_args动态获取函数参数,返回数组
	    $sqls = func_get_args();
	    foreach ($sqls as $s) {
	    	$result = mysqli_query($conn,$s);
	    }
	    mysqli_close($conn);
	    return $result;
	}

	function init_data_list() {
		$result = common_fn("select * from employee");
		$data = [];
	    while ($row = mysqli_fetch_assoc($result)) {
	    	Array_push($data, $row);
//	    	$data[] = $row;
	    }
		echo json_encode($data);
	}

	function add_row() {
		$name = $_POST['name'];
    	$sex = $_POST['sex'];
    	$brithday = $_POST['brithday'];
    	$job = $_POST['job'];
    	$salary = $_POST['salary'];
    	$jieshao = $_POST['jieshao'];
		$result = common_fn("insert into employee(name,sex,brithday,job,salary,jieshao) values('$name','$sex','$brithday','$job','$salary','$jieshao')");
		if ($result) {
			$res['state'] = 1;
			$res['detail'] = '添加成功';
		} else {
			$res['state'] = 0;
			$res['detail'] = '添加失败';
		}
		echo json_encode($res);
	}

	function del_row() {
		$id = $_POST['id'];
		$result = common_fn("delete from employee where id='$id'");
		if ($result) {
			$res['state'] = 1;
			$res['detail'] = '删除成功';
		} else {
			$res['state'] = 0;
			$res['detail'] = '删除失败';
		}
		echo json_encode($res);
	}

	function revise_row() {
		$id = $_POST['id'];
		$name = $_POST['name'];
    	$sex = $_POST['sex'];
    	$brithday = $_POST['brithday'];
    	$job = $_POST['job'];
    	$salary = $_POST['salary'];
    	$jieshao = $_POST['jieshao'];
		$result = common_fn("update employee set name='$name',sex='$sex',brithday='$brithday',job='$job',salary='$salary',jieshao='$jieshao' where id='$id'");
		if ($result) {
			$res['state'] = 1;
			$res['detail'] = '修改成功';
		} else {
			$res['state'] = 0;
			$res['detail'] = '修改失败';
		}
		echo json_encode($res);
	}



//	function init_data_list(){
//		$query = query_sql('select * from `employee`');
//		while($row = $query->fetch_assoc()){
//			$data[] = $row;
//		}
//		echo json_encode($data);
//
//	}
//	function query_sql(){
//		$mysqli = new mysqli('localhost', 'root', '', 'my_sql_test');  // 实例化mysqli---连接数据库
//		$mysqli->query("set names 'utf8'"); // 方法一 数据库输出编码 应该与你的数据库编码保持一致
//		//mysqli_query($mysqli, "set names 'utf8'");  //  方法二 数据库输出编码 应该与你的数据库编码保持一致
//		$sqls = func_get_args(); // func_get_args动态获取函数参数,返回数组
//		foreach($sqls as $s){
//			$query = $mysqli->query($s);
//		}
//		$mysqli->close();
//		return $query;
//	}

//	function del_row(){
//		@$dataid = $_POST['dataid'];
//		$sql = 'DELETE FROM `employee` WHERE `id`='.$dataid;
//		debugger;
//		if(query_sql($sql)){
//			echo json_encode('ok');
//		}else {
//			echo json_encode('db error ...');
//		}
//
//	}

//	function add_row(){
//		$name = $_POST['name'];
//		$sex = $_POST['sex'];
//		$brithday = $_POST['brithday'];
//		$job = $_POST['job'];
//		$salary = $_POST['salary'];
//		$jieshao = $_POST['jieshao'];
//		//连接数据库服务器
//		$conn = mysqli_connect('localhost', 'root', '');
//		//判断错误
//	    if (mysqli_errno($conn)) {
//	        echo mysqli_errno($conn);
//	        exit;
//	    }
//		//选择数据库
//	    mysqli_select_db($conn,"my_sql_test");
//	    //设置字符集
//	    mysqli_set_charset($conn,'utf8');
//		//SQL语句
//		$sql = "insert into employee(name,sex,brithday,job,salary,jieshao) values('$name','$sex','$brithday','$job','$salary','$jieshao')";
//		//发送SQL语句
//	    $result = mysqli_query($conn,$sql);
//	    if ($result) {
//	    	$res['state'] = 1;
//			$res['detail'] = "添加成功";
//			$res['id'] = mysqli_insert_id($conn);
//	    } else {
//	    	$res['state'] = 0;
//			$res['detail'] = "添加失败";
//	    }
//		mysql_close();//关闭mysql连接
//		echo json_encode('保存成功');
//	}

?>



