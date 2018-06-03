<?php
/**
 * Created by OctaneLab.
 * Date: 11.03.2018
 */
namespace common\OctaneComponents\interfaces;

interface ModelInterface {
    const TYPE_CANDIDATE = 1;
    const TYPE_RECRUITMENT = 2;

    /**
     * @param bool $plural
     * @return string Name of the model
     */
    public static function modelName($plural = false);

    /**
     * @return string Raw table name of the Model
     */
    public static function tableRawName();

    /**
     * @return string Raw table name of the Model
     */
    public static function missingLabel();
}