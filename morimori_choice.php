<!DOCTYPE html>
<html lang="ja">
<head>
	<link href="morimori.css" rel="stylesheet" type="text/css" media="all">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>イベントを選ぶ｜もりもりくん</title>
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

?>

<div id="header">
	<h1>もりもりくん</h1>
</div>
	<a href="morimori.html">もどる</a>
	<h3>●入力するイベントを選ぶ</h3>
		<ul>
		<?php

			$stm = $dbh->query('select * from events order by event_id desc');
			$select_data = $stm->fetchAll(); 

			foreach($select_data as $row){
		?>
				<li><a href='morimori_syu.php?id=<?php echo $row["event_id"] ?>'><?php echo $row["event_name"] ?></a></li>
		<?php	
			}
		?>
	
		</ul>


</body>
</html>
