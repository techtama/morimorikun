<!DOCTYPE html>
<html lang="ja">
<head>
	<link href="syu.css" rel="stylesheet" type="text/css" media="all">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>出欠確認｜もりもりくん</title>
</head>
<body>
<div class ="header">
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

	<a class="modoru" href="morimori_choice.php">＜　もどる　</a>

	<div class="syu">
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
					<td>撮★</td>
					<td>○</td>
					<td>△</td>
					<td>×</td>
					<td>未</td>
					<td>一覧</td>
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
						
						$count4 =$stm->fetchColumn();
					 	echo $count4.'人';
					 ?>
					
					</td>
					<td>
					<?php
					 	$stm =$dbh->query("select count(*) from attendance where kouho_id = $kouho and attendance = 3");
					 	
					 	$count3 =$stm->fetchColumn();
					 	echo $count3.'人';
					?>
					</td>
					<td>
					<?php
					 	$stm = $dbh->query("select count(*) from attendance where kouho_id = $kouho and attendance = 2");
					 
					 	$count2 =$stm->fetchColumn();
					 	echo $count2.'人';
					?>
					</td>
					<td>
					<?php
					 	$stm = $dbh->query("select count(*) from attendance where kouho_id = $kouho and attendance = 1");
					 	
					 	$count1 =$stm->fetchColumn();
					 	echo $count1.'人';
					?>
					</td>
					<td>
					<?php
					 	$stm = $dbh->query("select count(*) from attendance where kouho_id = $kouho and attendance > 0");
						
						$count0 =$stm->fetchColumn();
					 	echo 30-$count0.'人';
					?>
					</td>
					<td>
						<?php
							$stm =$dbh->query("select * from attendance where kouho_id = $kouho and attendance between 2.0 and 4.0 order by attendance desc");
							$user_data =$stm->fetchAll(); 

							foreach($user_data as $rown){

								$user=$rown['user_id'];
								$stm=$dbh->query("select user_name from users where user_id = $user");
								$user_name=$stm->fetch(PDO::FETCH_ASSOC);
								$name=strval($user_name['user_name']);

								//var_dump($name);

								if($rown['attendance']>3){
									echo "★".$name."、";
								}elseif ($rown['attendance']>2) {
									echo $name."、";
								}else{
									if($rown==end($user_data)){
										echo "△".$name;
									}else{
										echo "△".$name."、";
									}
								}

							}

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

					echo $name; ?>:<?php echo $row['comment'];?><br>
				</p>
		<?php
			}
		?>
	</p>



	<input type="btn" value="出欠を入力する" onclick="add();">

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
		</p>
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

</div>

<div class="footer">NAGOYAmanavee</div>

</body>
</html>