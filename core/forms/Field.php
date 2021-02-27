<?php

namespace app\core\forms;

use app\core\Model;

class Field
{
    public const TYPE_TEXT = 'text';
    public const TYPE_EMAIL = 'email';
    public const TYPE_NUMBER = 'number';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_TEXTAREA = 'textarea';

    public Model $model;
    public string $type;
    public string $label;
    public string $fieldName;

    public function __construct(Model $model, $fieldName, $label)
    {
        $this->model = $model;
        $this->type = self::TYPE_TEXT;
        $this->label = $label;
        $this->fieldName = $fieldName;
    }

    public function __toString()
    {
        return sprintf('
            <div class="mb-3 form-group">
                <label class="form-label">%s</label>
                <input type="%s" name="%s" value="%s" class="form-control %s">
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ', 
            $this->label,
            $this->type,
            $this->fieldName,
            $this->model->{$this->fieldName},
            $this->model->getError($this->fieldName) ? 'is-invalid' : '',
            $this->model->getError($this->fieldName) ? $this->model->getError($this->fieldName) : ''
        );
    }
    
    public function email()
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }
    public function number()
    {
        $this->type = self::TYPE_NUMBER;
        return $this;
    }

    public function password()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

}