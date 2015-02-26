<h1>sickmanてすと</h1>
<p>getパラムに　&email=aaa　とかつけると、バリデーションする</p>

<?php echo $error_message; ?>

<?php
$a = "b";
$$a = "c";
echo $a; //b
echo $b; //c

$unko = 'うんこ';
$key = 'unko';
echo $$key; //うんこ

$this->_set_list;
$key = "error_message"  $val = "えらーです";
$key = k2 $val = b
$key = k3 $val = c


$key = error_message
$val = エラーメッセージ

だとして

$$key = $val
${error_message} = "エラーメッセージ";


　（$error_message） //errorメッセ
echo $key; //errorキー

<?php
	//配列
	$array = array("php","meigen");
	//phpという変数を作ってmeigenという値を入れる
	${$array[0]} = $array[1];
	//変数phpが生成されたか確認
	echo $php;
?>