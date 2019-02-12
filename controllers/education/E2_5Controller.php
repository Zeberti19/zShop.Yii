<?php

namespace app\controllers\education;

use yii;
use yii\web\Controller;
use app\models\education\Country;
use yii\data\Pagination;

class E2_5Controller extends Controller
{
    /**+
     * @return string
     */
    public function actionIndex()
    {
        $CountryModel=new Country();
        $Countries=$CountryModel->find();
        $Pagination=new Pagination(["defaultPageSize"=>5,
                                    "totalCount"=>$Countries->count()]);
        $countries=$Countries->offset($Pagination->offset)
                             ->limit($Pagination->limit)->all();

        return $this->render('index',["CountryModel"=>$countries,
                                      "Pagination"=>$Pagination
                                     ]);
    }
}
