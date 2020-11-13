<?php
namespace models;

use models\api\ActiveRecord;

/**
 * Clase mCategoria.
 *
 * @author obarcia
 */
class mCategoria extends ActiveRecord
{
    /**
     * Identificador.
     * @var integer
     */
    private $id;
    /**
     * Nombre.
     * @var string
     */
    private $nombre;
    /**
     * Descripción.
     * @var string
     */
    private $descripcion;

    
    // ***************************************************
    // GETTER & SETTER
    // ***************************************************
    public function getId()
    {
        return $this->id;
    }
    public function setId( $id )
    {
        $this->id = $id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre( $nombre )
    {
        $this->nombre = $nombre;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function setDescripcion( $descripcion )
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Validar el vategoria.
     * @return boolean true si la validación es correcta, false en caso contrario.
     */
    public function validate()
    {
        //[...]
        return true;
    }
    /**
     * Guardar el registro.
     * @return boolean true si la operación fué correcta, false en caso contrario.
     */
    public function save()
    {
        if ( $this->validate() ) {
            $params = [];
            if ( empty( $this->id ) ) {
                $stmt = self::getDb()->prepare( "INSERT INTO ".self::getTablename()." (nombre, descripcion) VALUES (:nombre, :descripcion)" );
            } else {
                $stmt = self::getDb()->prepare( "UPDATE ".self::getTablename()." SET nombre = :nombre, descripcion = :descripcion WHERE id = :id" );
                $params[ "id" ] = $this->id;
            }
            $params[ "nombre" ] = $this->nombre;
            $params[ "descripcion" ] = $this->descripcion;
           
            if ( $stmt->execute( $params ) ) {
                $this->id = self::getDb()->lastInsertId();
                
                return true;
            } else {
                return false;
            }
        }
        
        return false;
    }
    /**
     * Eliminar la categoria.
     * @return boolean true si la operación fué correcta, false en caso contrario.
     */
    public function delete()
    {
        
        
        echo $this->id ;
        
        if ( !empty( $this->id ) ) {
            $stmt = self::getDb()->prepare( "DELETE FROM ".self::getTablename()." WHERE id = :id" );
            $params[ "id" ] = $this->id;
            if ( $stmt->execute( $params ) ) {
                return true;
            } else {
                return false;
            }
        }
    }
    /**
     * Nombre de la tabla.
     * @return string Nombre de la tabla.
     */
    public static function getTablename()
    {
        return "Categorias_01";
    }
    
    /**
     * Obtener un registro.
     * @param integer $id Identificador del registro.
     * @return \models\.Categoria Instancia del registro o null si no lo encuentra.
     */
    public static function findOne( $id )
    {
        $stmt = self::getDb()->prepare( "SELECT * FROM ".self::getTablename()." WHERE id = :id" );
        if ( $stmt->execute( [ "id" => $id ] ) ) {
            $result = $stmt->fetch( \PDO::FETCH_OBJ );
            if ( !empty( $result ) ) {
                $p = new mCategoria();
                $p->setId( $result->id );
                $p->setNombre( $result->nombre );
                $p->setDescripcion( $result->descripcion );
                
                return $p;
            }
        }
        
        return null;
    }
    
    /**
     * Buscar todos las categorias.
     */
    public static function findAll()
    {
        $list = [];
        
        $stmt = self::getDb()->query( "SELECT * FROM ".self::getTablename()." ORDER BY id DESC" );
        $result = $stmt->fetchAll( \PDO::FETCH_OBJ );
       
        if ( !empty( $result ) ) {
            foreach ( $result as $r ) {
                
                $p = new mCategoria();
                $p->setId( $r->id );
                $p->setNombre( $r->nombre );
                $p->setDescripcion( $r->descripcion );
                $list[] = $p;
            }
        }
        
        return $list;
    }

    
    
}