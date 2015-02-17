<?php if($has_created): ?>
<p><?php echo $table_name; ?>テーブルを作成しました。</p>
<?php else: ?>
<p><?php echo $table_name; ?>テーブルが存在しません。作成する場合は下記リンクをクリックしてください。</p>
<a href="<?php Html::path($this->controller_name . "/start/true"); ?>">作成する</a>
<?php endif; ?>
