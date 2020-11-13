<?php
namespace models\api;

/**
 * Clase Active Record.
 * 
 * @author obarcia
 */
class ActiveRecord
{
    /**
     * Instancia del PDO.
     * @var \PDO
     */
    private static $pdo;
    /**
     * Configuración de la BBDD.
     * @var array
     */
    private static $bd;
    
    /**
     * Obtener el PDO de la conexióin con la BBDD.
     * @return PDO Instancia del PDO.
     * @throws \Exception E xcepción si da un error de conexión con la BBDD.
     */
    public static function getDb()
    {
        if ( empty( self::$pdo ) ) {
            $config = include_once( __DIR__.'/../../config/config.php' );
            self::$bd = $config[ "bd" ];
            self::$pdo = new \PDO( self::$bd[ "dsn" ], self::$bd[ "username" ], self::$bd[ "password" ] );
            if ( empty( self::$pdo ) ) {
                throw new \Exception( "DB connection error" );
            } 
        }
        
        return self::$pdo;
    }
}