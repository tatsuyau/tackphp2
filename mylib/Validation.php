<?php

class Validation
{

    protected $rule_set = [];
    protected $add_count = -1;
    protected $errors = [];
    protected $replace_tags = [':field', ':label', ':value', ':rule'];
    protected $missing_error_message = '該当するエラーメッセージが存在しません。';
    protected $error_messages = [
        'required_param' => ':label パラメータを指定してください。',
        'required_form' => ':label の項目が空欄です。',
        'min_length' => ':label は :param:1 文字以上で入力して下さい。',
        'max_length' => ':label は :param:1 文字以下で入力して下さい。',
        'exact_length' => ':label は :param:1 文字で入力して下さい。',
        'match_value' => ':label は使用できない文字が含まれています。使用可能な文字 [:param:1] ',
        'match_pattern' => ':label は :param:2 で入力して下さい。',
        //'match_field' => ':label は :param:1 と異なっています。',
        'valid_email' => ':label は正しいメールアドレスの形式ではありません。',
        'valid_emails' => ':label は有効でないメールアドレスが含まれています。',
        'valid_url' => ':label は有効なURLではありません。',
        'valid_ip' => ':label は有効なIPアドレスではありません。',
        'numeric_min' => ':label は :param:1 より大きい数値を入力して下さい。',
        'numeric_max' => ':label は :param:1 より小さい数値を入力して下さい。',
        'valid_string' => ':label は :param:1 で入力してください。',
    ];
    protected $replace_words = [
        'alpha' => 'アルファベット',
        'utf8' => '全角文字',
        'numeric' => '数値',
        'spaces' => 'スペース',
        'newlines' => '改行',
        'tabs' => 'タブ',
        'punctuation' => '句読点',
        'singlequotes' => 'シングルクオート',
        'doublequotes' => 'ダブルクオート',
        'dashes' => 'ハイフン',
        'brackets' => 'brackets',
        'braces' => 'braces',
    ];

    /*
     * public
     */

    public function add($name, $label = '')
    {
        $this->add_count++;

        // 継承先でルールの上書きがあれば、古いルールを削除
        if (!empty($this->rule_set) && is_array($this->rule_set)) {
            foreach ($this->rule_set as $k => $v) {
                if ($v["name"] == $name) {
                    unset($this->rule_set[$k]);
                }
            }
        }

        $this->rule_set[$this->add_count]['name'] = $name;
        $this->rule_set[$this->add_count]['label'] = $label;

        return $this;
    }

    public function addRule($key, $val = null)
    {
        $this->rule_set[$this->add_count]["rules"][] = [$key, $val];

        return $this;
    }

    public function run($params)
    {

        $this->rule_set = array_values($this->rule_set);

        foreach ($this->rule_set as $k => $v) {
            $is_find = false;
            foreach ($params as $k2 => $v2) {
                if ($k2 === $v["name"]) {
                    $this->checkValidation($k2, $v["rules"], $v["label"], $v2);
                    $is_find = true;
                    break;
                }
            }

            // 必須パラメータの未指定チェック
            if ($is_find) {
                continue;
            }
            foreach ($v["rules"] as $rule_data) {
                if ($rule_data[0] == 'required_param') {
                    $this->setError($rule_data[0], $v["name"]);
                    break;
                }
            }
        }

        return (empty($this->errors));
    }

    public function showErrors()
    {
        return $this->errors;
    }

    public function validationEmpty($val)
    {
        return ($val === false or $val === null or $val === '' or $val === array());
    }

    public function validationRequireForm($input)
    {
        return !$this->validationEmpty($input);
    }

    public function validationMinLength($input, $rule)
    {
        return mb_strlen($input) >= $rule;
    }

    public function validationMaxLength($input, $rule)
    {
        return mb_strlen($input) <= $rule;
    }

    public function validationExactLength($input, $rule)
    {
        return mb_strlen($input) == $rule;
    }

    public function validationMatchValue($input, $rule, $strict = false)
    {
        return ($input === $input || (!$strict && $input == $input));
    }

    public function validationMatchPattern($input, $rule)
    {
        return preg_match($rule, $input) > 0;
    }

    public function validationValidEmail($input)
    {
        return filter_var($input, FILTER_VALIDATE_EMAIL);
    }

    public function validationValidEmails($input, $separator = ',')
    {
        $emails = explode($separator, $input);

        foreach ($emails as $e) {
            if (!filter_var(trim($e), FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }

        return true;
    }

    public function validationValidUrl($input)
    {
        return filter_var($input, FILTER_VALIDATE_URL);
    }

    public function validationValidIp($input)
    {
        return filter_var($input, FILTER_VALIDATE_IP);
    }

    public function validationNumericMin($input, $rule)
    {
        return $input >= $rule;
    }

    public function validationNumericMax($input, $rule)
    {
        return $input <= $rule;
    }

    public function validationValidString($input, $rule_list = ['alpha', 'utf8'])
    {
        if (!is_array($rule_list)) {
            if ($rule_list == 'alpha') {
                $rule_list = ['alpha', 'utf8'];
            } elseif ($rule_list == 'alpha_numeric') {
                $rule_list = ['alpha', 'utf8', 'numeric'];
            } elseif ($rule_list == 'specials') {
                $rule_list = ['specials', 'utf8'];
            } elseif ($rule_list == 'url_safe') {
                $rule_list = ['alpha', 'numeric', 'dashes'];
            } elseif ($rule_list == 'integer' or $rule_list == 'numeric') {
                $rule_list = ['numeric'];
            } elseif ($rule_list == 'float') {
                $rule_list = ['numeric', 'dots'];
            } elseif ($rule_list == 'quotes') {
                $rule_list = ['singlequotes', 'doublequotes'];
            } elseif ($rule_list == 'slashes') {
                $rule_list = ['forwardslashes', 'backslashes'];
            } elseif ($rule_list == 'all') {
                $rule_list = [
                    'alpha',
                    'utf8',
                    'numeric',
                    'specials',
                    'spaces',
                    'newlines',
                    'tabs',
                    'punctuation',
                    'singlequotes',
                    'doublequotes',
                    'dashes',
                    'forwardslashes',
                    'backslashes',
                    'brackets',
                    'braces'
                ];
            } else {
                return false;
            }
        }

        $pattern = !in_array('uppercase', $rule_list) && in_array('alpha', $rule_list) ? 'a-z' : '';
        $pattern .= !in_array('lowercase', $rule_list) && in_array('alpha', $rule_list) ? 'A-Z' : '';
        $pattern .= in_array('numeric', $rule_list) ? '0-9' : '';
        $pattern .= in_array('specials', $rule_list) ? '[:alpha:]' : '';
        $pattern .= in_array('spaces', $rule_list) ? ' ' : '';
        $pattern .= in_array('newlines', $rule_list) ? "\n" : '';
        $pattern .= in_array('tabs', $rule_list) ? "\t" : '';
        $pattern .= in_array('dots', $rule_list) && !in_array('punctuation', $rule_list) ? '\.' : '';
        $pattern .= in_array('commas', $rule_list) && !in_array('punctuation', $rule_list) ? ',' : '';
        $pattern .= in_array('punctuation', $rule_list) ? "\.,\!\?:;\&" : '';
        $pattern .= in_array('dashes', $rule_list) ? '_\-' : '';
        $pattern .= in_array('forwardslashes', $rule_list) ? '\/' : '';
        $pattern .= in_array('backslashes', $rule_list) ? '\\\\' : '';
        $pattern .= in_array('singlequotes', $rule_list) ? "'" : '';
        $pattern .= in_array('doublequotes', $rule_list) ? "\"" : '';
        $pattern .= in_array('brackets', $rule_list) ? "\(\)" : '';
        $pattern .= in_array('braces', $rule_list) ? "\{\}" : '';
        $pattern = empty($pattern) ? '/^(.*)$/' : ('/^([' . $pattern . '])+$/');
        $pattern .= in_array('utf8', $rule_list) || in_array('specials', $rule_list) ? 'u' : '';

        return preg_match($pattern, $input) > 0;
    }

    /*
     * protected
     */

    protected function checkValidation($name, $rule_list, $rule_label, $input_val = [])
    {
        foreach ($rule_list as $rule_data) {
            $this->filterRule($rule_data[0], $rule_data[1], $rule_label, $input_val);
        }
    }

    protected function filterRule($rule_name, $rule_val, $rule_label, $input_val)
    {
        switch ($rule_name) {
            case 'required_form':
                if (!$this->validationRequireForm($input_val)) {
                    $this->setError($rule_name, $rule_label, $rule_val);
                }
                break;
            case 'min_length':
                if (!$this->validationMinLength($input_val, $rule_val)) {
                    $this->setError($rule_name, $rule_label, $rule_val);
                }
                break;
            case 'max_length':
                if (!$this->validationMaxLength($input_val, $rule_val)) {
                    $this->setError($rule_name, $rule_label, $rule_val);
                }
                break;
            case 'exact_length':
                if (!$this->validationExactLength($input_val, $rule_val)) {
                    $this->setError($rule_name, $rule_label, $rule_val);
                }
                break;
            case 'match_value':
                if (!$this->validationExactLength($input_val, $rule_val)) {
                    $this->setError($rule_name, $rule_label, $rule_val);
                }
                break;
            case 'match_pattern':
                if (!$this->validationExactLength($input_val, $rule_val)) {
                    $this->setError($rule_name, $rule_label, $rule_val);
                }
                break;
            case 'valid_email':
                if (!$this->validationValidEmail($input_val)) {
                    $this->setError($rule_name, $rule_label, $rule_val);
                }
                break;
            case 'valid_emails':
                if (!$this->validationValidEmails($input_val)) {
                    $this->setError($rule_name, $rule_label, $rule_val);
                }
                break;
            case 'valid_url':
                if (!$this->validationValidUrl($input_val)) {
                    $this->setError($rule_name, $rule_label, $rule_val);
                }
                break;
            case 'valid_ip':
                if (!$this->validationValidIp($input_val)) {
                    $this->setError($rule_name, $rule_label, $rule_val);
                }
                break;
            case 'numeric_min':
                if (!$this->validationNumericMin($input_val, $rule_val)) {
                    $this->setError($rule_name, $rule_label, $rule_val);
                }
                break;
            case 'numeric_max':
                if (!$this->validationNumericMax($input_val, $rule_val)) {
                    $this->setError($rule_name, $rule_label, $rule_val);
                }
                break;
            case 'valid_string':
                if (!$this->validationValidString($input_val, $rule_val)) {
                    $this->setError($rule_name, $rule_label, $rule_val);
                }
                break;
            default:
                break;
        }
    }

    protected function setError($rule_name, $rule_label, $rule_val = null)
    {

        if ($this->validationEmpty($this->error_messages[$rule_name])) {
            $this->errors[] = $this->missing_error_message;
        } else {
            $error_message = $this->error_messages[$rule_name];
            $error_message = str_replace(':label', $rule_label, $error_message);
            if (is_array($rule_val)) {
                $param_num = 1;
                foreach ($rule_val as $val) {
                    $error_message = str_replace(':param:' . $param_num++, $val, $error_message);
                }
            } elseif (!$this->validationEmpty($rule_val)) {
                $error_message = str_replace(':param:1', $rule_val, $error_message);
            }
            foreach ($this->replace_words as $k => $v) {
                $error_message = str_replace($k, $v, $error_message);
            }
            $this->errors[] = $error_message;
        }
    }
}
