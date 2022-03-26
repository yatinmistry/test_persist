<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RouterDetails */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => ['index','step'=>'bulk-import'],
    'options'=>['enctype'=>'multipart/form-data']
]);?>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Sapid</th>
            <th>Hostname</th>
            <th>Loopback</th>
            <th>Mac Address</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($uploadedData as $key=>$row) {
        ?>
        <tr class="<?=$uploadFormModel->isDuplicateError($key) ? "active" : ""?>">
            <?php
            echo "<td>".($key+1)."</td>";
            foreach ($row as $field=>$value) {
                $errorMsg = $uploadFormModel->getRowError($key,$field);
                echo "<td>
                            <input name='BulkUpload[$key][$field]' type='text' class='form-control' value='$value'>
                            ".$errorMsg."
                      </td>";

            }?>
            <td><a href="javascript:void(0)" class="jdelete">Delete</a></td>
        </tr>
      <?php
    }
    ?>
    </tbody>

<table>
    <?= Html::submitButton('Confirm Bulk Upload',['class'=>'btn btn-primary']);?>
<?php ActiveForm::end();?>
