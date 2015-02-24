<?php

// バリデーションテスト用
class SickmanController extends BaseController{
    public function __construct(){
        parent::__construct();
    }
    public function index($message="Hello"){

        $validation_errors = $this::_exec_validation(Request::getParams("GET"));
        if(!empty($validation_errors)) $this->error($validation_errors);

        $this->render();
    }

    // 特定のコントローラだけで使うバリデーションルールは分けて定義できる
    protected function _set_validation_rules()
    {

        parent::_set_validation_rules();

        /* バリデーションルールはこちらに追加してください */

        $this->validation->add('page', 'ページ')
            ->add_rule('required_param')
            ->add_rule('required_form')
            ->add_rule('valid_string', ['numeric']);

        $this->validation->add('email', 'メールアドレス')
            ->add_rule('valid_email');
    }

}
