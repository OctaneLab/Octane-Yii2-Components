<?php
/**
 * Created by OctaneLab.
 * Date: 11.03.2018
 */

namespace common\OctaneComponents;


use yii\db\Migration;

class OMigration extends Migration
{
    /**
     * Quicker way to add FK
     *
     * @param $table_raw
     * @param $fk_table
     * @param $column
     * @param $fk_column
     * @param string $on_delete
     * @param string $on_update
     */
    public function addForeignKeyQuick($table_raw, $fk_table, $column, $fk_column, $on_delete = 'SET NULL', $on_update = 'CASCADE')
    {
        $this->addForeignKey(
            'FK-' . $table_raw . '-' . $column, //name
            '{{%' . $table_raw . '}}', //this table
            $column, //this column
            $fk_table, //fk table
            $fk_column, //fk match on column
            $on_delete, //on delete
            $on_update //on update
        );
    }

    /**
     * Quicker way to drop FK
     *
     * @param $table_raw
     * @param $column
     */
    public function dropForeignKeyQuick($table_raw, $column)
    {
        $this->dropForeignKey( 'FK-' . $table_raw . '-' . $column, '{{%' . $table_raw . '}}' );
    }
}