<?php
	//登录处理界面 logincheck.php
//	header(string: "Content-type:text/html; charset=utf-8");

    //将用户名和密码存入变量中，供后续使用
    $user = $_POST['username'];
    $psw = $_POST['userpwd'];
    //定义用于返回的数据
    $res = [
    	'state' => 0,
    	'detail' => "用户不存在或密码错误"
    ];
//  $res = array('state'=>0, 'detail'=>"用户不存在");

    //js文件中已判断提交的数据不为空且符合输入要求，所以直接连接数据库
    //一、连接数据库服务器
    $conn = mysqli_connect('localhost', 'root', '');
    //二、判断错误
    if (mysqli_errno($conn)) {
        echo mysqli_errno($conn);
        exit;
    }
    //三、选择数据库
    mysqli_select_db($conn,"my_sql_test");
    //四、设置字符集
    mysqli_set_charset($conn,'utf8');
    //五、准备SQL语句
    $sql = "select username,userpwd from userinfo where username = '$user' and userpwd = '$psw'";
	//六、发送SQL语句
    $result = mysqli_query($conn,$sql);
	//七、判断是否执行或者遍历数据
    $num = mysqli_num_rows($result);
    if ($num) {
    	$res['state'] = 1;
		$res['detail'] = "登录成功";
    }
    //八、关闭数据库
    mysqli_close($conn);
    echo json_encode($res);
	//第七步中，读取时遍历显示数据的函数如下：
	//函数名                              功能                                                                           参数
	//mysqli_fetch_array    得到result结果集中的数据，返回数组进行遍历           参数1：传入查询出来的结果变量；参数2：传入MYSQLI_NUM返回索引数组，MYSQLI_ASSOC返回关联数组，MYSQLI_BOTH返回索引和关联
	//mysqli_fetch_assoc    得到result结果集中的数据，返回关联数组进行遍历    参数1：传入查询出来的结果变量
	//mysqli_fetch_row      得到result结果集中的数据，返回索引数组进行遍历    参数1：。。。。。。。。。。。
	//mysqli_fetch_object   得到result结果集中的数据，返回对象进行遍历           参数1：。。。。。。。。。。。
	//mysqli_num_rows       返回查询出来的结果总数                                              参数1：。。。。。。。。。。。
	//第七步中，写入时（如果发送的是INSERT语句，通常需要得到是否执行成功或者同时拿到自增的ID------------获取自增id用mysqli_insert_id()，例子在注册页面）
	//函数名                              功能                                                                            参数
	//mysqli_fetch_field    遍历数据行                                                                   参数1：。。。。。。。。。。。
	//如果发送的是update和delete类别的语句，只需要判断是否执行成功即可
?>