<!DOCTYPE html>
<html lang="ja">
<head>
	<link href="mkeve.css" rel="stylesheet" type="text/css" media="all">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

	if ($event_name=='' or $kouho_name=='') {
		?>
		
	<div class="back">

	<div class="header">
	<h1>もりもりくん</h1>
	</div>

	<div class="mkeve">

		<?php
		echo "入力されていない項目があります。<br/><br/><br/>";
		?>
		<input class="btn" type='button' value = '戻る' onClick='history.back()' >
	</div>
		<div class="footer2">NAGOYAmanavee</div>
	</div>

		<?php
	}else{

	$stmt = $dbh->prepare("insert into events(event_name,event_memo) values(?,?)"); //?-->プレイスホルダー
	$stmt->execute(array($_POST['event_name'], $_POST['event_memo']));//プリペアードステートメントの実行

	$eveid = $dbh->lastInsertId();

	$kouho = explode("\n", $kouho_name);//ブンカツ
	$kouho = array_map('trim', $kouho);
	$kouho = array_filter($kouho,'strlen');
	$kouho = array_values($kouho);

	$cnt = count($kouho);
	
	
	for( $i=0;$i<$cnt;$i++){
	//for
	$stmt = $dbh->prepare("insert into kouho(event_id, kouho_name) values(?,?)");
	$stmt->execute(array( $eveid , $kouho[$i]));//プリペアードステートメントの実行

	}
?>
	<div class="back">
	
	<div class="header">
	<h1>もりもりくん</h1>
	</div>
	
	<div class="mkeve">

<?php
	echo "イベント作り成功!<br/><br/><br/><br/>";
?>

		<a id="kakunin" href='morimori_syu.php?id=<?php echo $eveid ?>'>確認しましょう>></a>
		<br><br>
	</div>
		<div class="footer2">NAGOYAmanavee</div>
	</div>
<?php
	}
	$dbh = null;
?>
</body>
</html>