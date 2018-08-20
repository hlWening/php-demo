<?php
	//注册界面 register.php
//	header(string: "Content-type:text/html; charset=utf-8");

    //将用户名和密码存入变量中，供后续使用
    $user = $_POST['username'];
    $pwd = $_POST['userpwd'];
    //用户注册时间以及注册ip
    $time = date("Y-m-d h:i:s");
//  $time = time();
    $ip = long2ip($_SERVER['REMOTE_ADDR']);
//  $ip = ip2long($_SERVER['REMOTE_ADDR']);

    //定义用于返回的数据
    $res = [
    	'state' => 0,
    	'detail' => '注册失败',
    	'id' => ''
    ];

    //js文件中已判断提交的数据不为空且符合输入要求，所以直接连接数据库服务器
    $conn = mysqli_connect('localhost', 'root', '');//数据库帐号密码为安装数据库时设置
    //判断错误
    if (mysqli_errno($conn)) {
        echo mysqli_errno($conn);
        exit;
    }
    //选择数据库
    mysqli_select_db($conn,"my_sql_test");
    //设置字符集
    mysqli_set_charset($conn,'utf8');
    //查找是否有用户名重复的SQL语句
    $select_sql = "select username from userinfo where username = '$user'";
    //发送SQL语句
    $ret = mysqli_query($conn,$select_sql);
    //判断是否执行或者遍历数据
    $num = mysqli_num_rows($ret);
    if ($num) {
    	$res['state'] = -1;
		$res['detail'] = "用户名重复";
    } else {
    	//准备SQL语句
	    $sql = "insert into userinfo(username,userpwd,createtime,createip) values('$user','$pwd','$time','$ip')";
	    //发送SQL语句
	    $result = mysqli_query($conn,$sql);
	    if ($result) {
	    	$res['state'] = 1;
			$res['detail'] = "注册成功";
			$res['id'] = mysqli_insert_id($conn);
	    }
    }

    mysqli_close($conn);
    echo json_encode($res);
?>