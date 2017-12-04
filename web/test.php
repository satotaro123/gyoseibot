<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>チャットボットテスト</title>
<link href="css/common.css" rel="stylesheet" />
<link href="css/bootstrap.css" rel="stylesheet" />
<link href="css/jquery.bootgrid.css" rel="stylesheet" />
<link href="css/botui.min.css" rel="stylesheet" />
<link href="css/botui-theme-default.css" rel="stylesheet" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.js"></script>
<script src="//cdn.jsdelivr.net/vue/latest/vue.min.js"></script>
<script src="//unpkg.com/botui/build/botui.min.js"></script>
<!--
<script src="https://embed.small.chat/T7ZNUHSENG7ZM4UH8B.js" async></script>
-->
</head>
<body>
<div id="header"></div>
<div class="container">
	<h1>チャットボットテスト</h1>
	<div class="botui-app-container" id="chat-app">
    	<!-- チャットの表示  -->
    	<bot-ui></bot-ui>
	</div>
</div>
</body>
<script>
$(function(){
	$("#header").load("header.html");

	var url = 'https://api.github.com/search/repositories?q=';
	  var msgIndex, key;
	  var botui = new BotUI('chat-app');


	  //初期メッセージ
	  botui.message.bot({
	    content: 'こんにちは！'
	  }).then(init);

	  function init() {
		  /*
		  botui.message.bot({
			  delay: 1500,  //メッセージの表示タイミングをずらす
		      content: 'はじめにテストするボットを選択してください'
		  }).then(function() {
		      return botui.action.button({
		        delay: 1000,
		        action: [{
		          text: '属性登録',
		          value: '属性登録'
		        }, {
		          text: '検診相談',
		          value: '検診相談'
		        }, {
		          text: 'その他のお問い合わせ',
			      value: 'その他のお問い合わせ'
		        }]
		      });
		  }).then(function(res) {
			  delay: 1500,
			  content: '「' + res.value + '」ですね。かしこまりました。'
		  });
		  */
		  botui.message.bot({
			  delay: 1500,  //メッセージの表示タイミングをずらす
		      content: 'はじめにテストするボットを選択してください'
		  }).then(function() {
		      return botui.action.button({
		        delay: 1000,
		        action: [{
		          text: '属性登録',
		          value: 'aa'
		        }, {
		          text: '検診相談',
		          value: 'bb'
		        }, {
		          text: 'その他のお問い合わせ',
			      value: 'cc'
		        }]
		      });
		  }).then(function(res) {
			  delay: 1500,
			  content: '」ですね。かしこまりました。'
		  });
	  }

	  function init2() {
	    botui.message.bot({
	      delay: 1500,  //メッセージの表示タイミングをずらす
	      content: '気になるキーワードで、GitHubの総リポジトリ数をお答えします！'
	    }).then(function() {

	      //キーワードの入力
	      //「return」を記述して、ユーザーからの入力待ち状態にする
	      return botui.action.text({
	        delay: 1000,
	        action: {
	          placeholder: '例：javascript'
	        }
	      });
	    }).then(function(res) {

	      //入力されたキーワードを取得する
	      key = res.value;
	      getRepositories(key);

	      //ローディング中のアイコンを表示
	      botui.message.bot({
	        loading: true
	      }).then(function(index) {

	        //ローディングアイコンのindexを取得
	        //このindexを使ってメッセージ情報を更新する
	        //（更新しないとローディングアイコンが消えないため…）
	        msgIndex = index;
	      });
	    });
	  }


	  //GitHubのリポジトリを取得する処理
	  function getRepositories(keyword) {
	    var xhr = new XMLHttpRequest();

	    xhr.open('GET', url + keyword);
	    xhr.onload = function() {
	      var result = JSON.parse(xhr.responseText);

	      //取得したリポジトリ数をshowMessage()に代入する
	      showMessage(result.total_count);
	    }
	    xhr.send();
	  }


	  //リポジトリ総数をメッセージに表示する処理
	  function showMessage(totalCount) {

	    //ローディングアイコンのindexを使ってメッセージを書き換える
	    botui.message.update(msgIndex, {
	      content: key + 'のリポジトリ総数は、' + totalCount + '個です！'
	    }).then(function() {
	      return botui.message.bot({
	        delay: 1500,
	        content: 'まだ続けますか？'
	      })
	    }).then(function() {

	      //「はい」「いいえ」のボタンを表示
	      return botui.action.button({
	        delay: 1000,
	        action: [{
	          icon: 'circle-thin',
	          text: 'はい',
	          value: true
	        }, {
	          icon: 'close',
	          text: 'いいえ',
	          value: false
	        }]
	      });
	    }).then(function(res) {

	      //「続ける」か「終了」するかの条件分岐処理
	      res.value ? init() : end();
	    });
	  }


	  //プログラムを終了する処理
	  function end() {
	    botui.message.bot({
	      content: 'ご利用ありがとうございました！'
	    })
	  }
});
</script>
</html>

