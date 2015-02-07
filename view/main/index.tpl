<h1><?php h($message); ?> tackphp!</h1>
<p><a href="<?php Html::path("/main/index/Welcome"); ?>">Welcome</a></p>
<p>
<?php h($message); ?>!<br />
このページが正常に表示されていますか？<br />
されていれば無事tackphp2がインストールされています！<br />
tackphp2でちょっとだけ機能が増えました^^<br />
with tack, you can.
</p>

<h2>1. データベースへのアクセス</h2>
<?php if($is_connect): ?>
<p class="text-success">DBに接続できました！</p>
<?php else: ?>
<p class="text-warning">DBに接続できません。database.phpの修正をしましょう！</p>
<?php endif; ?>

<h2>2. Scaffold</h2>
<p>
データベースへの接続が完了したらScaffoldを試してみましょう。<br />
ここではScaffoldControllerを継承して作成したSampleControllerでScaffoldを試してみます。<br />
Scaffoldではテーブルの作成も自動的に行います！<br />
(model/Sample.phpに設定が書いてあります。)<br />
<a href="<?php Html::path("/sample"); ?>">SampleScaffold</a>
</p>
