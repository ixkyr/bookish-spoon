<?php
	session_start();
	header("Content-type:text/html;charset=utf-8");
	$link = mysqli_connect('localhost','root','loveyang999!','test');
	if (!$link) {
		die("连接失败:".mysqli_connect_error());
	}
	$username = $_POST['username'];
	$password = $_POST['password'];
	$confirm = $_POST['confirm'];
	$email = $_POST['email'];
	$code = $_POST['code'];
	if($username == "" || $password == "" || $confirm == "" || $email == "" || $code == "")
	{
		echo "<script>alert('信息不能为空！重新填写');window.location.href='zhuce.html'</script>";
	} elseif ((strlen($username) < 3)||(!preg_match('/^\w+$/i', $username))) {
		echo "<script>alert('用户名至少3位且不含非法字符！重新填写');window.history.back(-1);</script>";
		//判断用户名长度
	}elseif(strlen($password) < 5){
		echo "<script>alert('密码至少5位！重新填写');window.history.back(-1);</script>";
		//判断密码长度
	}elseif($password != $confirm) {
		echo "<script>alert('两次密码不相同！重新填写');window.history.back(-1);</script>";
		//检测两次输入密码是否相同
	} elseif (!preg_match('/^[\w\.]+@\w+\.\w+$/i', $email)) {
		echo "<script>alert('邮箱不合法！重新填写');window.history.back(-1);</script>";
		//判断邮箱格式是否合法
	} elseif($code != $_SESSION['authcode']) {
		echo "<script>alert('验证码错误！重新填写');window.history.back(-1);</script>";
		//判断验证码是否填写正确
	} elseif(mysqli_fetch_array(mysqli_query($link,"select * from login where username = '$username'"))){
		echo "<script>alert('用户名已存在');window.location.href='zhuce.html'</script>";
	} else{
		$sql= "insert into login(username, password, confirm, email)values('$username','$password','$confirm','$email')";
		//插入数据库
		if(!(mysqli_query($link,$sql))){
			echo "<script>alert('数据插入失败');window.location.href='zhuce.html'</script>";
		}else{
			echo "<script>alert('注册成功！去登陆');window.location.href='login.html'</script>";
		}
	}
?>