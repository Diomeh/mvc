<?php

namespace app\models;

use app\core\Model;

class RegisterModel extends Model
{
    public string $username = '';
    public string $email = '';
    public string $pass_one = '';
    public string $pass_two = '';
    
    public function rules() : array
    {
        return [
            'username' => [
                self::RULE_REQUIRED => true,
                self::RULE_MIN => 6,
                self::RULE_MAX => 16
            ],
            'email' => [
                self::RULE_REQUIRED => true,
                self::RULE_EMAIL => true
            ],
            'pass_one' => [
                self::RULE_REQUIRED => true,
                self::RULE_MIN => 8,
                self::RULE_MAX => 32
            ],
            'pass_two' => [
                self::RULE_REQUIRED => true,
                self::RULE_MIN => 8,
                self::RULE_MAX => 32,
                self::RULE_MATCH => ['pass_one']
            ],
        ];
    }

    public function register()
    {
        return true;
    }
}