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
            ->add_rule('required')
            ->add_rule('min_length', 1)
            ->add_rule('max_length', 3)
            ->add_rule('valid_string', ['numeric']);

        $this->validation->add('limit', '表示件数')
            ->add_rule('required')
            ->add_rule('numeric_min', 1)
            ->add_rule('numeric_max', 100)
            ->add_rule('valid_string', ['numeric']);

        $this->validation->add('ip', 'IPアドレス')
            ->add_rule('required_param')
            ->add_rule('valid_ip');
        $this->validation->add('url', 'URL')
            ->add_rule('valid_url');

    }

    protected function execValidation($params)
    {
        $error_messages = (!$this->validation->run($params)) ? $this->validation->show_errors() : null;
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
