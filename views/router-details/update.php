<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RouterDetails */

$this->title = 'Update Router Details: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Router Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="router-details-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
