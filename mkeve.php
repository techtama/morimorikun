<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>イベントを作る｜もりもりくん</title>
</head>
<body>
<?php
	//入力内容の受け取り
	$evename=$_POST['evename'];
	$kouho=$_POST['kouho'];
	$comment=$_POST['comment'];

	//サニタイジング
	$evename=htmlspecialchars($evename);
	$kouho=htmlspecialchars($kouho);
	$comment=htmlspecialchars($comment);

	//DB接続
	$dsn='mysql:dbname=Morimori;host=localhost;charaset=utf8;';
	$username = 'yu';
	$password = 'morimorimorimori';
	$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);

	try{
		$dbh = new PDO($dsn, $username, $password, $options);
	}catch(PDOException $e){
		var_dump($e->getMessage());
		exit;
	}


?>
</body>
</html>