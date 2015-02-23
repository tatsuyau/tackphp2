<?php
class BaseController extends Controller{
	public function __construct(){
		parent::__construct();
	}

    /**
     * パラメータのバリデーションをチェック。
     * エラーがあればメッセージを配列で返す。（TODO： 現在はtackphpのエラー用にただのstringに直してる）
     *
     * @param $params array
     * @return array|bool
     */
    public static function validation_check($params)
    {

        $val = new Validation();

        /* バリデーションルールはこちらに追加してください */

        $val->add('page', 'ページ')
            ->add_rule('required')
            ->add_rule('min_length', 1)
            ->add_rule('max_length', 3)
            ->add_rule('valid_string', ['numeric']);

        $val->add('limit', '表示件数')
            ->add_rule('required')
            ->add_rule('numeric_min', 1)
            ->add_rule('numeric_max', 100)
            ->add_rule('valid_string', ['numeric']);

        /* // バリデーションルール */

        $error_messages = array();
        if (!$val->run($params)) {
            $error_messages = $val->show_errors();
        }

        if(!empty($error_messages)) {
            $message = "";
            foreach($error_messages as $error_message){
                $message .= $error_message."<br>";
            }
            return $message;
        }else{
            return false;
        }
    }
}
