<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RouterDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Router Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="router-details-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::a('Create Router Details', ['create'], ['class' => 'btn btn-success']) ?>

        <?php
        if ($uploadedData) {
            echo $this->render('_bulk_import_uploaded_data_form', [
                'uploadedData' => $uploadedData,
                'uploadFormModel' => $uploadFormModel,
            ]);
        }else {
            echo $this->render('_bulk_import_form', ['model' => $uploadFormModel]);
        }
        ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'sapid',
            'hostname',
            'loopback',
            'mac_address',
            //'created_date',
//            [
//                'class' => ActionColumn::className(),
//                'urlCreator' => function ($action, RouterDetails $model, $key, $index, $column) {
//                    return Url::toRoute([$action, 'id' => $model->id]);
//                 }
//            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
<?php
$script = <<< JS
   $(document).on('click','.jdelete',function (){
            $(this).closest('tr').remove(); 
   });
JS;
$this->registerJs($script);
?>