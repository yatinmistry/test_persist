<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RouterDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'action' => ['index','step'=>'bulk-upload'],
    'options'=>['enctype'=>'multipart/form-data']
]);?>
    <?= $form->field($model,'importFile')->fileInput() ?>
<?= Html::submitButton('Bulk Import',['class'=>'btn btn-primary']);?>

<?php ActiveForm::end();?>