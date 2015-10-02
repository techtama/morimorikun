<!DOCTYPE html>
<html lang="ja">
<head>
	<link href="mkeve.css" rel="stylesheet" type="text/css" media="all">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>イベントを作る｜もりもりくん</title>
	<style type="text/css">

		.month1 .date1,/* 元日 */
		.month1 .mon2,/* 成人の日 */
		.month2 .date11,/* 建国記念の日 */
		.month4 .date29,/* 昭和の日 */
		.month5 .date3,/* 憲法記念日 */
		.month5 .date4,/* みどりの日 */
		.month5 .date5,/* こども日 */
		.month7 .mon3,/* 海の日 */
		.month9 .mon3,/* 敬老の日 */
		.month10 .mon2,/* 体育の日 */
		.month11 .date3,/* 文化の日 */
		.month11 .date23,/* 勤労感謝の日 */
		.month12 .date23,/* 天皇誕生日 */
		#d20110321,/* 春分の日（年によって異なる 20日 - 21日） */
		#d20110923,/* 秋分の日（年によって異なる 20日 - 24日） */
		.sun1,
		.sun2,
		.sun3,
		.sun4,
		.sun5{background:#88c551;color:#fff;}

	</style>
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
			
				<h4>｜イベント名</h4>
					<input class="evename" name="event_name" maxlength="100" value type="text" placeholder="イベント名">
			
			
				<h4>｜日にち候補</h4>
					<p class="min">
						※候補の区切りは改行で判断されます。<br>
					</p>

					<div id="calendar"></div>
					<div class="tukibtn"><span id="month_prev_ajax">前月へ</span> <span id="month_next_ajax">次月へ</span></div>

					<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

						<script type="text/javascript">
						(function(){
							//　取得したい年月設定
							
							function calendar(y,m){
								
								// 初期設定	
								var feb_date = (y%4 == 0 && y%100 != 0)?29:28;
								if(y%400 == 0){feb_date = 29};
								var month_count = {1:31,2:feb_date,3:31,4:30,5:31,6:30,7:31,8:31,9:30,10:31,11:30,12:31}
								var day_en = {d0:"sun",d1:"mon",d2:"the",d3:"wed",d4:"thu",d5:"fri",d6:"sat"};
								var m_display = (m<10)?"0"+String(m):m;	
								var last_day = new Date(y,m-1,month_count[m]).getDay();
								var first_day = new Date(y,m-1,1).getDay();
								var w = 1;
								var d = first_day;
								
								// マークアップ生成
								var txt = "";
								txt += '<h1>◎　' + y + '年' + m + '月</h1>\n';
								txt += '<table summary="' + y + '年' + m_display + '月" class="calendar month' + m + '">\n';
								txt += '<tr>\n';
								txt += '<th>日</th>\n';
								txt += '<th>月</th>\n';
								txt += '<th>火</th>\n';
								txt += '<th>水</th>\n';
								txt += '<th>木</th>\n';
								txt += '<th>金</th>\n';
								txt += '<th>土</th>\n';
								txt += '</tr>\n';
								txt += '<tr class="week1">\n';
								for(var j=0;j<first_day;j++){
									txt += '<td>&nbsp;</td>\n';
								}
								for(var i=1;i<=month_count[m];i++){
									if(d != 0 && (first_day + i)%7 == 1){
										w++;
										d = 0;
										txt += '</tr>\n';	
										txt += '<tr class="week' + w + '">\n';
									}
									var i_display = (i<10)?"0"+String(i):i;
									
									day_count = (i%7 == 0)? Math.floor(i/7) : Math.floor(i/7) + 1 ;
									txt += '<td id="d' + y + m_display + i_display + '" class="' + day_en['d'+d] + day_count + ' date' + i + '">' + i + '</td>\n';
									d++;
								}
								for(var j=0;j<(6-last_day);j++){
									txt += '<td>&nbsp;</td>\n';
								}
								txt += '</tr>\n';
								txt += '</table>\n';
								
								// 書き出し
								$("#calendar").html(txt);
						
							
							function dateF(idDate){
								return idDate.slice(5,7) + "/" + idDate.slice(7);
							}

							function dateY(idDate){
								year = idDate.slice(1,5);
								month =	idDate.slice(5,7);
								day = idDate.slice(7);	
								var w = ["日","月","火","水","木","金","土"];	
								var pDate = new Date( year, month-1, day);

								return w[pDate.getDay()];
							}

							$("td").click(function(event){
								$("#kouho_name").val($("#kouho_name").val() + dateF(event.target.id) + "(" + dateY(event.target.id) + ")" + "\n");}
							);
							
							}
							
							$(document).ready(function(){
								y = new Date().getFullYear();
								m = new Date().getMonth()+1;
								calendar(y,m);
								
							
								$("#month_prev_ajax").click(function(){
									m--;
									if(m==0){y--;m=12;}
									calendar(y,m);
									return false;
								});
								$("#month_next_ajax").click(function(){
									m++;
									if(m==13){y++;m=1;}
									calendar(y,m);
									return false;
								});
							});
						})();



						</script>


					<textarea name="kouho_name" id="kouho_name" rows="10" placeholder="候補の区切りは改行で判断されます。また、カレンダーの日付をタップすると日時が入ります。&#13;&#10;&#13;&#10;例：&#13;&#10;8/1（火）4限&#13;&#10;5限&#13;&#10;8/3（木）夜"></textarea>
			
			
				<h4>｜詳細(空欄でも可)</h4>
					<textarea name="event_memo" rows="5" placeholder="例）ゆうさんの独断と偏見によりお店は「サイゼリヤ」に決まりました。参加費は1000円です。"></textarea>
							
				<input class="btn" type="submit" value="イベントを作る">
	</form>
	</div>
			<div class="footer">NAGOYAmanavee</div>
	</div>

</body>
</html>
