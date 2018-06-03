<?php

namespace common\OctaneComponents\interfaces;

interface RoutingInterface
{
   /**
    * @return string Name of the Controller
    */
   public static function name();

   /**
    * @return array Actions' titles, icons and other helpers
    */
   public static function labels();

   /**
    * @return array Actions' behaviors
    */
   public function behaviors();

}
