<!DOCTYPE html>
<html lang="ja">
<head>
	<link href="morimori.css" rel="stylesheet" type="text/css" media="all">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>出欠確認｜もりもりくん</title>
</head>
<body>
<div id="header">
	<h1>もりもりくん</h1>
</div>
<?php
	$dsn='mysql:dbname=Morimori;host=localhost;charaset=utf8;';
	$username='yu';
	$password='morimorimorimori';

	try{
		$dbh = new PDO($dsn,$username,$password);
	}catch(PDOException $e){
		var_dump($e->getMessage());
		exit;
	}

	$id = $_GET['id'];
	$stm = $dbh->query("select * from events where event_id = $id ");
	$event = $stm->fetchAll();
	foreach($event as $row){
?>

	<a href="morimori_choice.php">もどる</a>
	<h3>●出欠を入力する</h3>
		<h4>イベント名｜<?php echo $row['event_name'];?>
<?php
}
		$stm=$dbh->query("select kouho_id from kouho where event_id = $id limit 1");
		$kouho_id=$stm->fetch(PDO::FETCH_ASSOC);
		$kouho=$kouho_id['kouho_id'];
		$stm=$dbh->query("select count(*) from attendance where kouho_id = $kouho");
		$count=$stm->fetchColumn();

?>

		回答数：<?php echo $count; ?><br><br>
		
		イベント説明</h4>
		
		<p><?php echo $row['event_memo'];?></p>


		<h4>日にち候補</h4>
		<table>
			<tbody>
				<tr>
					<td>日程</td>
					<td>撮</td>
					<td>○</td>
					<td>△</td>
					<td>×</td>
					<td>未</td>
				</tr>

				<?php

					$stm =$dbh->query("select * from kouho where event_id = $id ");
					$select_data =$stm->fetchAll(); 

					foreach($select_data as $row){

				 	$kouho = intval($row["kouho_id"]);

				?>

				<tr>
					<td><?php echo $row["kouho_name"] ?></td>
					<td>
					 <?php
					 	$stm = $dbh->query("select count(*) from attendance where kouho_id = $kouho and attendance = 4");
						
						$count =$stm->fetchColumn();
					 	echo $count;
					 ?>
					
					</td>
					<td>
					<?php
					 	$stm =$dbh->query("select count(*) from attendance where kouho_id = $kouho and attendance = 3");
					 	
					 	$count =$stm->fetchColumn();
					 	echo $count;
					?>
					</td>
					<td>
					<?php
					 	$stm = $dbh->query("select count(*) from attendance where kouho_id = $kouho and attendance = 2");
					 
					 	$count =$stm->fetchColumn();
					 	echo $count;
					?>
					</td>
					<td>
					<?php
					 	$stm = $dbh->query("select count(*) from attendance where kouho_id = $kouho and attendance = 1");
					 	
					 	$count =$stm->fetchColumn();
					 	echo $count;
					?>
					</td>
					<td>
					<?php
					 	$stm = $dbh->query("select count(*) from attendance where kouho_id = $kouho and attendance > 0");
						
						$count =$stm->fetchColumn();
					 	echo 30-$count;
					?>
					</td>
				</tr>
				
				<?php
				}
				?>
			</tbody>
		</table>

	<p>
		○コメント<br>
		<?php
			$stm =$dbh->query("select * from comments where event_id = $id and comment !=''");
			$comment_data =$stm->fetchAll(); 

			foreach($comment_data as $row){
		?>
				<p><?php 

					$user_id=$row['user_id'];
					$stm=$dbh->query("select user_name from users where user_id=$user_id");
					$username=$stm->fetch(PDO::FETCH_ASSOC);
					$name=$username['user_name'];

					echo $name; ?>:<?php echo $row['comment'];?><br></p>
		<?php
			}
		?>
	</p>



	<input type="button" value="出欠を入力する" onclick="add();">

	<form action="syu.php" method="post">

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<p>名前：

		<select name="manavee_id">
		<option value="">選択してください</option>
		<?php
			$stm = $dbh->query('select * from users');
			$namelist = $stm->fetchAll();

			foreach($namelist as $row1){
		?>
			<option value="<?php echo $row1['user_id'] ?>"><?php echo $row1['user_name'] ?></option>
		<?php
		}
		?>
		</select>
		<p>
			<?php
				$stm = $dbh->query("select * from kouho where event_id = $id ");
				$kouho_data = $stm->fetchAll(); 
				foreach($kouho_data as $row){
				echo $row['kouho_name'];
			?>
		<input type="radio" name="<?php echo $row['kouho_id']?>" value="4">撮
		<input type="radio" name="<?php echo $row['kouho_id']?>" value="3">○
		<input type="radio" name="<?php echo $row['kouho_id']?>" value="2">△
		<input type="radio" name="<?php echo $row['kouho_id']?>" value="1">×
		<input type="radio" name="<?php echo $row['kouho_id']?>" value="0" checked="checked">未
		</p>
		<?php
		}
		?>
		<p>
		コメント：<br>
		<textarea name="comment" rows="10"></textarea>
		</p>

		<p>
		<input type="submit" value="送信する">
		</p>
	</form>

</body>
</html>