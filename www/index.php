<?php
error_reporting( 1 );
spl_autoload_register( function( $className ) {
    $className = str_replace( "\\", DIRECTORY_SEPARATOR, $className );
    include_once __DIR__. '/' . $className . '.php';
     
});

$ctrl = new \controllers\Site();

if ( !empty( $_GET[ "action" ] ) ) {
    $action = "action".ucwords( $_GET[ "action" ] );
} else {
    $action =  $ctrl->getDefaultAction() ;
}
if ( !empty( $ctrl ) ) {
    
    if ( method_exists( $ctrl, $action ) ) {
        $ctrl->$action();
    } else {
        throw new \Exception( "Action not found." );
    }
} else {
    throw new \Exception( "Controller not found." );
}
