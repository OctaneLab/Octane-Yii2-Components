<?php
/**
 * Created by OctaneLab.
 * Date: 11.03.2018
 */
namespace common\OctaneComponents;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the ActiveQuery class for [[ActiveRecord]].
 *
 * @see ActiveRecord
 */
class OActiveQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return ActiveRecord[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ActiveRecord|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param array|string|\yii\db\ExpressionInterface $condition
     * @return $this
     */
    public function where($condition)
    {
        return $this->andWhere($condition);
    }

    /**
     * @param string $field_label Field name in db table, OR there is no such a field, Model's property
     * @param string $field_id Table field to be provided as key in returned data array.
     * @param string|null $sort_order Sorting type: ASC|DESC|null
     * @param string|null $sort_field Sorting field
     * @return array Data ready to provide to Dropdown input (select) (eg.)
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function forSelect($field_label = 'name', $field_id = 'id', $sort_order = 'ASC', $sort_field = null)
    {
        $cloneForCheck = clone $this;
        $oneRecord     = $cloneForCheck->select('id')->one();
        if ($oneRecord == null) return [];

        $columns = $oneRecord->getTableSchema()->columnNames;

        // If field exists in table: (for optimize)
        if (in_array($field_label, $columns)) {

            return $this->select([$field_label, $field_id])
                ->indexBy($field_id)
                ->orderBy($sort_order !== null ? ($sort_field == null ? $field_label : $sort_field) . ' ' . $sort_order : $field_id . ' ASC')
                ->column();
        }

        // else, get from Model's property
        $models = $this->indexBy($field_id)->all();
        $list   = ArrayHelper::map($models, $field_id, $field_label);

        if ($sort_order == 'ASC') asort($list);
        else rsort($list);

        return $list;
    }

    /**
     * @param string $deletedAtAttribute
     * @return $this Gets only NOT soft-deleted records
     */
    public function alive($deletedAtAttribute = 'deleted_at')
    {
        /** @var OActiveRecord $model */
        $model      = (new $this->modelClass);
        $table_name = $model->tableName();

        if ($model->hasProperty('deletedAtAttribute') AND $model->hasAttribute($model->deletedAtAttribute)) {
            $this->andWhere([$table_name . '.' . $model->deletedAtAttribute => null]);
        }

        unset($model);

        return $this;
    }

    /**
     * @param string $deletedAtAttribute
     * @return $this Gets only soft-deleted records
     */
    public function killed($deletedAtAttribute = 'deleted_at')
    {
        /** @var OActiveRecord $model */
        $model      = (new $this->modelClass);
        $table_name = $model->tableName();

        if ($model->hasProperty('deletedAtAttribute') AND $model->hasAttribute($model->deletedAtAttribute)) {
            $this->andWhere(['not', [$table_name . '.' . $model->deletedAtAttribute => null]]);
        }

        unset($model);

        return $this;
    }
}