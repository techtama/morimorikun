<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>イベントを作る｜もりもりくん</title>
</head>
<body>
<?php
	//入力内容の受け取り
	$event_name=$_POST['event_name'];
	$kouho_name=$_POST['kouho_name'];
	$event_memo=$_POST['event_memo'];

	//サニタイジング
	$event_name=htmlspecialchars($event_name);
	$kouho_name=htmlspecialchars($kouho_name);
	$event_memo=htmlspecialchars($event_memo);

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


	$stmt = %dbh->prepare("insert into events(event_name,event_memo) values(?,?)"); //?-->プレイスホルダー
	$stmt->execute(array($_POST['event_name'], $_POST['event_memo']));　　　//プリペアードステートメントの実行

	$stmt = %dbh->prepare("insert into kouho(kouho_name) values($_POST['event_memo'])");

	echo "done";
?>
</body>
</html>