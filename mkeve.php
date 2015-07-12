<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>イベントを作る｜もりもりくん</title>
</head>
<body>
<?php

	//入力内容の受け取り
	$event_name=$_POST["event_name"];
	$kouho_name=$_POST["kouho_name"];
	$event_memo=$_POST["event_memo"];

	//サニタイジング
	$event_name=htmlspecialchars($event_name);
	$kouho_name=htmlspecialchars($kouho_name);
	$event_memo=htmlspecialchars($event_memo);

	//DB接続
	$dsn='mysql:dbname=Morimori;host=localhost;charaset=utf8;';
	$username = 'yu';
	$password = 'morimorimorimori';

	try{
		$dbh = new PDO($dsn, $username, $password);
	}catch(PDOException $e){
		var_dump($e->getMessage());
		exit;
	}


	$stmt = $dbh->prepare("insert into events(event_name,event_memo) values(?,?)"); //?-->プレイスホルダー
	$stmt->execute(array($_POST['event_name'], $_POST['event_memo']));//プリペアードステートメントの実行

	$kouho = explode("\n", $kouho_name);//ブンカツ
	$cnt = count($kouho);
	
	for( $i=0;$i<$cnt;$i++){
	//for
	$stmt = $dbh->prepare("insert into kouho(event_id, kouho_name) values(?,?)");
	$stmt->execute(array($dbh->lastInsertId(), $kouho[$i]));//プリペアードステートメントの実行

}

	echo "$cnt";
	echo "done";

	$dbh = null;
?>
</body>
</html>