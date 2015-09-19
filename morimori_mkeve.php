<!DOCTYPE html>
<html lang="ja">
<head>
	<link href="mkeve.css" rel="stylesheet" type="text/css" media="all">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>イベントを作る｜もりもりくん</title>
</head>
<body>
	<div class="back">

	<div class="header">
	<h1>もりもりくん</h1>
	</div>
		
	<a class="modoru" href="morimori.html">＜ もどる　</a>

	<div class="mkeve">	

	<form action="mkeve.php" method="post">

		<h3>●イベントを作る</h3>
			<p>
				<h4>｜イベント名</h4>
					<input class="evename" name="event_name" maxlength="100" value type="text" placeholder="イベント名">
			</p>
			<p>
				<h4>｜日にち候補</h4>
					<p class="min">
						※候補の区切りは改行で判断されます。<br>
						※同じ日にちは繰り返さないように書いてください。<br>
						<br>
						例：<br>
						8/1（火）4限<br>
						5限<br>
						8/3（木）夜<br><br>
					</p>

					<p>調整さんみたいなカレンダー</p>
					<textarea name="kouho_name" rows="10" placeholder="候補の区切りは改行で判断されます。また、カレンダーの日付をタップすると日時が入ります。"></textarea>
			</p>
			<p>
				<h4>｜詳細(空欄でも可)</h4>
					<textarea name="event_memo" rows="10" placeholder="例）ゆうさんの独断と偏見によりお店は「サイゼリヤ」に決まりました。参加費は1000円です。"></textarea>
			</p>
				
				<input class="btn" type="submit" value="イベントを作る">
	</form>
	</div>
			<div class="footer">NAGOYAmanavee</div>
	</div>

</body>
</html>
