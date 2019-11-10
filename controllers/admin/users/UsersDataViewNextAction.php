<?php
namespace app\controllers\admin\users;

/**
 * Класс-действие, которое меняет вид данных пользователей на следующий по порядку
 *
 * @return string
 */
class UsersDataViewNextAction extends \yii\base\Action
{
    /**
     * Массив с ИД видов данных о пользователях. В данном массиве важен порядок,
     * т.к. именно исходя из порядка ИД в этом массиве определяется в какой последовательности будут переключаться
     * виды данных
     *
     * @var array
     */
    protected $dataViewMas=['self','yii2','gii'];

    /**
     * Меняет вид данных пользователей на следующий по порядку
     *
     * @param $dataViewId
     *          ИД текущего вида данных
     * @return string
     */
    public function run($dataViewId)
    {
        $key=array_search($dataViewId,$this->dataViewMas);
        $key++;
        if($key==count($this->dataViewMas)) $dataViewNext=$this->dataViewMas[0];
        else $dataViewNext=$this->dataViewMas[$key];
        switch($dataViewNext)
        {
            case 'self':
            case 'yii2':
                header("Location:?r=admin/users/users-tools&dataViewId={$dataViewNext}");
                exit;
            case 'gii':
                header("Location:?r=admin/users/users-gii&dataViewId={$dataViewNext}");
                exit;
            default:
        }
    }
}