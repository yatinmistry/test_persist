<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RouterDetails */

$this->title = 'Create Router Details';
$this->params['breadcrumbs'][] = ['label' => 'Router Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="router-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
