<?php

/**
 * Handles generation off all icons
 */
class BF_Icons_Factory {

    /**
     * Inner array of icons instances
     *
     * @var array
     */
    private static $instances = array();

    /**
     * used for getting instance of a type of icons
     *
     * @param string $icon
     * @return bool
     */
    public static function getInstance( $icon = '' ){

        if( empty( $icon ) )
            return false;

        $_icon = $icon;

        $icon = ucfirst($icon);

        if ( !isset( self::$instances[$icon]) || is_null( self::$instances[$icon] ) ){

            if(!class_exists('BF_'.$icon))
                require_once BF_PATH . 'libs/icons/class-bf-'.$_icon.'.php';

            $class = 'BF_' . $icon;
            self::$instances[$icon] = new $class;
        }

        return self::$instances[$icon];
    }

}