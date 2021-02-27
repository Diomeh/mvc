<?php

use app\core\forms\Form; 

$form = Form::begin('', 'post');

echo '<h1>Create your user</h1>';

echo $form->field($model, 'username', 'Username');
echo $form->field($model, 'email', 'Email')->email();
 
?>

<div class="row">
    <div class="col-sm">
        <?php echo $form->field($model, 'pass_one', 'Password')->password(); ?>
    </div>
    <div class="col-sm">
        <?php echo $form->field($model, 'pass_two', 'Confirm your password')->password(); ?>
    </div>
</div>

<?php Form::end(); ?>