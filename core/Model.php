<?php

namespace app\core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MATCH = 'match';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';

    public array $errors = [];

    public function __construct($data = null)
    {
        $this->loadData($data);
    }

    public function loadData($data)
    {
        if (isset($data))
            foreach ($data as $key => $value)
                if (property_exists($this, $key))
                    $this->{$key} = $value;
    }

    abstract public function rules(): array;

    public function validate()
    {
        foreach ($this->rules() as $fieldName => $rules) {
            $fieldValue = $this->{$fieldName};
            foreach ($rules as $rule => $val) {
                switch ($rule) {
                    case self::RULE_REQUIRED:
                        if (!$fieldValue)
                            $this->errors[$fieldName][$rule] = 'This field is required';
                        break;
                    case self::RULE_EMAIL:
                        if (!filter_var($fieldValue, FILTER_VALIDATE_EMAIL))
                            $this->errors[$fieldName][$rule] = 'Please enter a valid email address.';
                        break;
                    case self::RULE_MATCH:
                        foreach ($val as $matchField)
                            if (strcmp($fieldValue, $this->{$matchField}) != 0)
                                $this->errors[$fieldName][$rule] = $this->errors[$matchField][$rule] = "Fields don't match.";
                        break;
                    case self::RULE_MIN:
                        if (!$fieldValue || strlen($fieldValue) < $val)
                            $this->errors[$fieldName][$rule] = "The min length of this field must be at least $val characters long.";
                        break;
                    case self::RULE_MAX:
                        if ($fieldValue && strlen($fieldValue) >= $val)
                            $this->errors[$fieldName][$rule] = "The max length of this field must be less than $val characters long.";
                        break;
                }
            }
        }
        
        return empty($this->errors);
    }

    public function getError($fieldName)
    {
        return empty($this->errors[$fieldName]) 
            ? false 
            : current($this->errors[$fieldName]);
    }
}
