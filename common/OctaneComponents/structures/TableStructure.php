<?php
/**
 * Created by OctaneLab.
 * Date: 11.03.2018
 */
namespace common\OctaneComponents\structures;

use yii\db\Migration;
use common\models\User;

class TableStructure
{

    // timestamp
    public $created_at = 'created_at';
    public $updated_at = 'updated_at';

    // possession
    public $created_by = 'created_by';
    public $updated_by = 'updated_by';

    // soft delete
    public $deleted_by = 'deleted_by';
    public $deleted_at = 'deleted_at';

    //life
    public $status = 'status';

    /**
     * @param array $except Names of columns to omit
     * @param array $only Names of columns to take only
     * @return array
     */
    public function timestamp($except = [], $only = [])
    {
        $migration = new Migration();

        $fields = [
            $this->created_at => $migration->integer(),
            $this->updated_at => $migration->integer(),
        ];

        $fields = $this->excludeItems($fields, $except, $only);

        return $fields;
    }

    /**
     * @param array $except Names of columns to omit
     * @param array $only Names of columns to take only
     * @return array
     */
    public function possession($except = [], $only = [])
    {
        $migration = new Migration();

        $fields = [
            $this->created_by => $migration->integer(),
            $this->updated_by => $migration->integer(),
        ];

        $fields = $this->excludeItems($fields, $except, $only);

        return $fields;
    }

    /**
     * @param array $except Names of columns to omit
     * @param array $only Names of columns to take only
     * @return array
     */
    public function softDelete($except = [], $only = [])
    {
        $migration = new Migration();

        $fields = [
            $this->deleted_by => $migration->integer(),
            $this->deleted_at => $migration->integer(),
        ];

        $fields = $this->excludeItems($fields, $except, $only);

        return $fields;
    }

    /**
     * @return array
     */
    public function statusInfo()
    {

        $migration = new Migration();

        $fields = [
            $this->status => $migration->smallInteger()->notNull()->defaultValue('0'),
        ];

        return $fields;
    }

    /**
     * @param array $except Names of columns to omit
     * @param array $only Names of columns to take only
     * @return array
     */
    public function possessionForeignKeys($except = [], $only = [])
    {
        $keys = [
            $this->created_by => [
                'rel_table'  => User::tableName(),
                'rel_column' => 'id',
                'on_delete'  => 'NO ACTION',
                'on_update'  => 'CASCADE',
            ],
            $this->updated_by => [
                'rel_table'  => User::tableName(),
                'rel_column' => 'id',
                'on_delete'  => 'NO ACTION',
                'on_update'  => 'CASCADE',
            ],
        ];

        $keys = $this->excludeItems($keys, $except, $only);

        return $keys;
    }

    /**
     * @return array
     */
    public function softDeleteForeignKeys()
    {
        return [
            $this->deleted_by => [
                'rel_table'  => User::tableName(),
                'rel_column' => 'id',
                'on_delete'  => 'NO ACTION',
                'on_update'  => 'CASCADE',
            ],
        ];
    }

    /**
     * @param int $value
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function url($value = 2083)
    {
        $migration = new Migration();
        return $migration->string($value);
    }

    /**
     * @param $fields
     * @param $except
     * @param $only
     * @return mixed
     */
    private function excludeItems($fields, $except, $only)
    {
        if (!empty($except)) {
            foreach ($except as $field) {
                unset($fields[$field]);
            }
        }

        if (!empty($only)) {
            foreach ($fields as $field => $type) {
                if (!in_array($field, $only)) {
                    unset($fields[$field]);
                }
            }
        }

        return $fields;
    }
}