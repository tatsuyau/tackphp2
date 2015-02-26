<?php

// バリデーションテスト用
class SickmanController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($message = "Hello")
    {

        $validation_errors = $this::execValidation(Request::getParams("GET"));
        if (!empty($validation_errors)) {
            $this->error($validation_errors);
        }

        $this->render();

    }

    // 特定のコントローラだけで使うバリデーションルールは分けて定義できる
    protected function setValidationRules()
    {

        parent::setValidationRules();

        /* バリデーションルールはこちらに追加してください */

        $this->validation->add('page', 'ページ')
            ->addRule('required_param')
            ->addRule('required_form')
            ->addRule('valid_string', ['numeric']);

        $this->validation->add('email', 'メールアドレス')
            ->addRule('valid_email');
    }

}
