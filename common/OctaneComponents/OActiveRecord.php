<?php
/**
 * Created by OctaneLab.
 * Date: 11.03.2018
 */
namespace common\OctaneComponents;

use backend\models\File;
use common\OctaneComponents\widgets\OGridView;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

use common\OctaneComponents\components\Icon;
use common\OctaneComponents\interfaces\ModelInterface;
/**
 * HXS ActiveRecord is the layer between used ActiveRecord and Yii's one
 */
abstract class OActiveRecord extends ActiveRecord implements ModelInterface
{
    const SOFT_DELETE_ALL    = 1;
    const SOFT_DELETE_ALIVE  = 0;
    const SOFT_DELETE_KILLED = -1;

    public static function tableName()
    {
        return '{{%' . static::tableRawName() . '}}';
    }


    public static function priceColumnName()
    {
        return 'price_netto';
    }

    public static function possessionLabels()
    {
        return [
            'created_at'  => Yii::t('app', 'Stworzony dnia'),
            'updated_at'  => Yii::t('app', 'Zmieniony dnia'),
            'created_by'  => Yii::t('app', 'Stworzony przez'),
            'updated_by'  => Yii::t('app', 'Zmieniony przez'),
            'deleted_by'  => Yii::t('app', 'Usuniety przez'),
            'deleted_at'  => Yii::t('app', 'Usuniety dnia')
        ];
    }

    private static function getAliveOnlyCondition()
    {
        return "status = 1";
    }

    /**
     * @param $field_name
     * @param bool $generate_icon
     * @param array $icon_options
     * @return string
     */
    public function getAttributeIcon( $field_name, $generate_icon = false, $icon_options = [ ] )
    {
        $icons     = $this->attributeIcons();
        $icon_name = isset( $icons[ $field_name ] ) ? $icons[ $field_name ] : 'circle-o';
        
        if ( !$generate_icon ) return $icon_name;
        
        return Icon::i( $icon_name, $icon_options );
    }
    
    /**
     * @param $field_name
     * @param string $first
     * @param array $icon_options
     * @return string
     * @internal param bool $generate_icon
     */
    public function getAttributeIconLabel( $field_name, $first = 'icon', $icon_options = [ ] )
    {
        $icon  = $this->getAttributeIcon( $field_name, true, $icon_options );
        $label = $this->getAttributeLabel( $field_name );
        
        if ( $first == 'icon' ) return $icon . ' ' . $label;
        
        return $label . ' ' . $icon;
    }
    
    /**
     * @inheritdoc
     * @return OActiveQuery the active query used by this AR class.
     */
    public static function find( $soft_delete_status = self::SOFT_DELETE_ALIVE )
    {
        $activeQuery = new OActiveQuery( get_called_class() );
        
        if ( $soft_delete_status == self::SOFT_DELETE_ALIVE ) {
            $activeQuery->alive();
        } else if ( $soft_delete_status == self::SOFT_DELETE_KILLED ) {
            $activeQuery->killed();
        }
        
        return $activeQuery;
    }
    
    /**
     * @inheritdoc
     * @return HXActiveQuery the active query used by this AR class with soft-deleted records.
     */
    public static function withTrashed()
    {
        return self::find( self::SOFT_DELETE_ALL );
    }
    
    /**
     * @param mixed $condition
     * @param int $soft_delete_status
     * @return array|bool|null|ActiveRecord
     */
    public static function findOne( $condition, $soft_delete_status = self::SOFT_DELETE_ALIVE )
    {
        return self::findByCondition( $condition, $soft_delete_status )->one();
    }
    
    /**
     * @param mixed $condition
     * @param int $soft_delete_status
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findAll( $condition, $soft_delete_status = self::SOFT_DELETE_ALIVE )
    {
        return self::findByCondition( $condition, $soft_delete_status )->all();
    }
    
    /**
     * @inheritdoc
     * @param mixed $condition
     * @param int $soft_delete_status
     */
    protected static function findByCondition( $condition, $soft_delete_status = self::SOFT_DELETE_ALIVE )
    {
        $query = static::find( $soft_delete_status );
        
        if ( !ArrayHelper::isAssociative( $condition ) ) {
            // query by primary key
            $primaryKey = static::primaryKey();
            if ( isset( $primaryKey[ 0 ] ) ) {
                $condition = [ $primaryKey[ 0 ] => $condition ];
            } else {
                throw new InvalidConfigException( '"' . get_called_class() . '" must have a primary key.' );
            }
        }
        
        return $query->andWhere( $condition );
    }
    
    /**
     * @param string $name Name of relation
     * @param array $models Array of models related with OR Array of numbers
     * @return $this
     */
    public function linkMany( $name, $models )
    {
        $err = [ ];
        foreach ( $this->checkIsIntOrModel( $models, $name ) as $model ) {
            $err[] = $this->link( $name, $model );
        }
        
        return $err;
    }
    
    /**
     * @param string $name Name of relation
     * @param array $models Array of models to join with
     * @param bool $force
     * @return $this
     */
    public function unLinkMany( $name, $models, $force = true )
    {
        foreach ( $this->checkIsIntOrModel( $models, $name ) as $model ) {
            $this->unlink( $name, $model, $force );
        }
        
        return $this;
    }
    
    /**
     * @param $array Array of models, or int
     * @param $relationName If array has int val, need to find related model by id
     * @return mixed
     */
    private function checkIsIntOrModel( $array, $relationName )
    {
        if ( $array ) {
            if ( count( array_filter( $array, 'is_int' ) + array_filter( $array, 'strlen' ) ) == 0 ) {
                return $array;
            } else {
                $relation = $this->getRelation( $relationName )->modelClass;
                $mod      = $relation::find()->where( [ 'id' => $array ] )->select( 'id' )->all();
                
                return $mod;
            }
        } else {
            return [ ];
        }
    }
    
    /**
     * @param string $names
     * @param bool $strict
     * @inheritdoc
     */
    public function getDirtyAttributes($names = null, $strict = true)
    {
        if ($strict) return parent::getDirtyAttributes($names);
        if ($names == null) {
            $names = $this->attributes();
        }
        $names = array_flip($names);
        $attributes = [];
        if ($this->oldAttributes == null) {
            foreach ($this->attributes as $name => $value) {
                if (isset($names[$name])) {
                    $attributes[$name] = $value;
                }
            }
        } else {
            foreach ($this->attributes as $name => $value) {
                if (isset($names[$name]) && (!array_key_exists($name, $this->oldAttributes) || $value != $this->oldAttributes[$name])) {
                    $attributes[$name] = $value;
                }
            }
        }
        return $attributes;
    }

    /** ******************** GRID COLUMNS ********************* */

    /**
     * For OGridView - returns simple array with attrubutes depending on field name
     *
     * @param string $name
     * @param array $data
     * @param string $returnMethod
     * @param string $fType
     * @param array $hOpt
     * @return array
     */
    public static function renderGridColumn(
        $name         = 'status',
        $data         = [],
        $returnMethod = 'getStatusUX' ,
        $fType        = OGridView::FILTER_SELECT2,
        $hOpt         = ['style' => 'width:50px;']
    )
    {
        return [
            'attribute'           => $name,
            'format'              => 'raw',
            'headerOptions'       => $hOpt,  // not max-width
            'filterType'          => $fType,
            'filterWidgetOptions' => [
                'theme' => 'default',
                'data'          => $data,
                'pluginOptions' => [
                    'allowClear' => true,
                    'placeholder' => Yii::t('app', 'Wybierz')
                ],
            ],
            'value'     => function ( $model , $key, $index, $grid ) use ($returnMethod) {
                return $model->{$returnMethod}();
            }
        ];
    }

    /**
     * For OGrid avatar or thumb image or icons check and times only
     *
     * @param string $name
     * @param bool $showIconsOnly
     * @param array $hOpt
     * @return array
     */
    public static function renderGridThumbColumn(
        $name          = 'image_id',
        $showIconsOnly = false,
        $hOpt          = ['style' => 'width:50px;'])
    {
        return [
            'attribute'     => $name,
            'format'        => 'raw',
            'headerOptions' => $hOpt,
            'value'         => function ( $model , $key, $index, $grid ) use ($name, $showIconsOnly) {

                $magicName = explode('_',$name)[0];
                /** @var File $magic */
                $magic = $model->{$magicName};
                return isset($model->{$name})
                    ? (
                        $showIconsOnly
                            ? Icon::i('check',['style' => 'color:green;'])
                            : $magic->render(['style' => 'height: 50px;'])
                    )
                    : Icon::i('times',['style' => 'color:red;']);

            }
        ];
    }

    /**
     * @param bool $aliveOnly
     * @param array $specificWhere
     * @return array
     */
    public static function getForSelect($specificWhere = [], $aliveOnly = true)
    {
        $query = self::find();

        if(count($specificWhere) > 0){
            foreach($specificWhere as $index => $where){
                if($index == 0){
                    $query->where($where);
                }else{
                    $query->andWhere($where);
                }
            }
            if($aliveOnly) $query->andWhere(self::getAliveOnlyCondition());
        }else{
            $query->where(self::getAliveOnlyCondition());
        }
        $all = $query->all();

        $out = [];
        foreach ($all as $item) {
            $out[$item->id] = $item->getListPretty();
        }

        return $out;
    }

    /**
     * Renders item
     * @return mixed|string
     */
    public function getListPretty()
    {
        if($this->name) {
            $out = $this->name;
        }else {
            $out = "( ".Yii::t('app', 'Brak')." )";
        }
        return $out;
    }
}
