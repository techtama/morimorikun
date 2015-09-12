<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>イベントを作る｜もりもりくん</title>
</head>
<body>
<?php

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

	//入力内容の受け取り
	$user_id=$_POST["manavee_id"];
	$comment=$_POST["comment"];
	$id=$_POST["id"];

	//サニタイジング
	$user_id=htmlspecialchars($user_id);
	$comment=htmlspecialchars($comment);
	$id=htmlspecialchars($id);


	$stm = $dbh->query("select * from kouho where event_id = $id");
	$kouho_data = $stm->fetchAll(); 
				foreach($kouho_data as $row){


					 $attendance=$_POST[$row['kouho_id']];
					 $kouho=intval($row['kouho_id']);

					 $stm = $dbh->query("select count(*) from attendance where kouho_id = $kouho and user_id = $user_id");
					 $count =$stm->fetchColumn();

					 if ($count>0) {
						$stm = $dbh->prepare("update attendance set attendance = $attendance where kouho_id = $kouho and user_id = $user_id");
					 	$stm->execute();	
					 }else{
					 	$stm = $dbh->prepare("insert into attendance(user_id,kouho_id,attendance) values(?,?,?)");//?-->プレイスホルダー
					 	$stm->execute(array($_POST['manavee_id'], $row['kouho_id'], $_POST[$row['kouho_id']]));//プリペアードステートメントの実行
					 }
					 	
					}

	if($count>0){
		$stm = $dbh->prepare("update comments set comment = '$comment' where event_id = $id and user_id = $user_id");
		$stm->execute();
	}else{
		$stm = $dbh->prepare("insert into comments(event_id,user_id,comment) values(?,?,?)");
		$stm->execute(array($_POST["id"],$_POST['manavee_id'],$_POST["comment"]));
	}

	echo "送信されました。<br /><br /><br />入力ページに戻ります。";
?>
	<meta http-equiv="refresh" content="3;URL=morimori_syu.php?id=<?php echo $id ?>">
<?php
	$dbh = null;
?>
</body>
</html>