<?php

namespace app\core\forms;

use app\core\Model;

class Form
{
    public static function begin($action, $method)
    {
        echo sprintf('
            <div class="card card-body">
                <form action="%s" method="%s">
        ', $action, $method);
        return new Form();
    }

    public static function end()
    {
        echo '
                <div class="btn-group">
                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                    <a href="/" class="btn btn-outline-danger">Cancel</a>
                </div>
                </form>
            </div>
        ';
    }

    public function field(Model $model, $fieldName, $label)
    {
        return new Field($model, $fieldName, $label);
    }
}