<?php

class BaseController extends Controller
{

    protected $validation;

    public function __construct()
    {
        $this->validation = new Validation();
        $this->_setValidationRules();
        parent::__construct();
    }

    protected function _setValidationRules()
    {
        /*
         * 共通で使用するバリデーションルールはここに定義してください
         */

        $this->validation->add('page', 'ページ')
            ->addRule('required')
            ->addRule('min_length', 1)
            ->addRule('max_length', 3)
            ->addRule('valid_string', ['numeric']);

        $this->validation->add('limit', '表示件数')
            ->addRule('required')
            ->addRule('numeric_min', 1)
            ->addRule('numeric_max', 100)
            ->addRule('valid_string', ['numeric']);

        $this->validation->add('ip', 'IPアドレス')
            ->addRule('required_param')
            ->addRule('valid_ip');
        $this->validation->add('url', 'URL')
            ->addRule('valid_url');

    }

    protected function execValidation($params)
    {
        $error_messages = (!$this->validation->run($params)) ? $this->validation->showErrors() : null;
        if (empty($error_messages)) {
            return false;
        }

        // TODO エラー文を配列で受け取ってくれないっぽいので、とりあえず平文に。
        $tackphp_error_message = "";
        foreach ($error_messages as $error_message) {
            $tackphp_error_message .= $error_message . "<br>";
        }

        return $tackphp_error_message;
    }
}
