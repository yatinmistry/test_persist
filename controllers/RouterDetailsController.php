<?php

namespace app\controllers;

use app\models\RouterDetails;
use app\models\RouterDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii;

/**
 * RouterDetailsController implements the CRUD actions for RouterDetails model.
 */
class RouterDetailsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    public function bulkUpload($model){
        $uploadedData = [];
        if (Yii::$app->request->isPost) {
            $model->importFile = UploadedFile::getInstance($model, 'importFile');
            if ($uploadedData = $model->upload()) {
                // file is uploaded successfully
                return $uploadedData;
            }
        }
        return $uploadedData;
    }

    public  function  bulkImport(UploadForm $uploadFormModel, Array $data) {

        if ($uploadFormModel->validateBulkImortData($data)) {
            // Insert Data
            foreach ($data as $row){
                $model = new RouterDetails();
                $model->attributes = $row;
//                print_r($model->attributes);
                if ($model->save()) {
//                    echo "Saved<br/>";
                } else {
//                    echo "failed<br/>";
//                    print_r($model->errors);
                }
            }
            Yii::$app->session->setFlash('success', "Data Imported Successfully");
            return true;
        }

        return false;
    }

    /**
     * Lists all RouterDetails models.
     *
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new RouterDetailsSearch();
        $uploadFormModel = new UploadForm();

        $step = Yii::$app->request->get('step');
        $uploadedData = Yii::$app->request->post("BulkUpload");
        // Confirm Bulk Import
        if ('bulk-import' == $step &&
            Yii::$app->request->isPost &&
            $uploadedData &&
            $this->bulkImport($uploadFormModel, $uploadedData)) {
                return $this->redirect(['index']);
        } else if('bulk-upload' == $step) { // Upload
            $uploadedData = $this->bulkUpload($uploadFormModel);
        }

        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uploadFormModel'=> $uploadFormModel,
            'uploadedData' => $uploadedData,
        ]);
    }

    /**
     * Displays a single RouterDetails model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RouterDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new RouterDetails();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RouterDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RouterDetails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RouterDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return RouterDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RouterDetails::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
