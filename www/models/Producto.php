<?php
namespace models;

use models\api\ActiveRecord;
use models\mCategoria;

/**
 * Clase producto.
 * 
 * @author obarcia
 */
class Producto extends ActiveRecord
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
     * DescripciÃ³n.
     * @var string
     */
    private $descripcion;
    /**
     * Contenido de la imagen en Base64.
     * @var string
     */
    private $imagen;
    
    private $idCategoria;
    
    private $txtError;

    // ***************************************************
    // GETTER & SETTER
    // ***************************************************

    public function getError()
    {
        return $this->txtError;
    }
    public function setError( $id )
    {
        $this->txtError = $id;
    }
    
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
    public function getImagen()
    {
        return $this->imagen;
    }
    public function setImagen( $imagen )
    {
        $this->imagen = $imagen;
    }
    
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }
    public function setIdCategoria( $idCategoria )
    {
        $this->idCategoria = $idCategoria;
    }
    
    /**
     * Validar el producto.
     * @return boolean true si la validaciÃ³n es correcta, false en caso contrario.
     */
    public function validate($obj)
    {

        if (strlen($obj->nombre)>160 ) {
            $this->txtError = "Nombre muy largo";
            return  false;
        }
        
        if (strlen($obj->descripcion)>258 ) {
            $this->txtError = "Descripcion muy larga";
            return  false;
        }

        if (strlen($obj->nombre)==0 ) {
            $this->txtError = "Escribe un Nombre.";
            return  false;
        }
        
        if (strlen($obj->descripcion)==0 ) {
            $this->txtError = "Escribe una Descripcion.";
            return  false;
        }
        
        return true;
    }
    /**
     * Guardar el registro.
     * @return boolean true si la operaciÃ³n fuÃ© correcta, false en caso contrario.
     */
    public function save()
    {
        if ( $this->validate($this) ) {
            $params = [];
            
            if ( empty( $this->id ) ) {                
                self::getDb()->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);                
                $stmt = self::getDb()->prepare( "INSERT INTO ".self::getTablename()." (nombre, descripcion, imagen, id_categoria) VALUES (:nombre, :descripcion, :imagen, :idCategoria )" );
            } else {
                $stmt = self::getDb()->prepare( "UPDATE ".self::getTablename()." SET nombre = :nombre, descripcion = :descripcion, imagen = :imagen, id_categoria = :idCategoria WHERE id = :id" );
                $params[ "id" ] = $this->id;
            }
            $params[ "nombre" ] = $this->nombre;
            $params[ "descripcion" ] = $this->descripcion;
            $params[ "imagen" ] = $this->imagen != null ? $this->imagen : "";
            $params[ "idCategoria" ] = $this->idCategoria;
   
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
     * Eliminar el producto.
     * @return boolean true si la operaciÃ³n fuÃ© correcta, false en caso contrario.
     */
    public function delete()
    {
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
     * Eliminar la imagen de producto.
     * @return boolean true si la operaciÃ³n fuÃ© correcta, false en caso contrario.
     */
    public function deleteImagen()
    {
        if ( !empty( $this->id ) ) {
            $stmt = self::getDb()->prepare( "UPDATE ".self::getTablename()." SET imagen=null WHERE id = :id" );
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
        return "Productos_01";
    }
    /**
     * Obtener un registro.
     * @param integer $id Identificador del registro.
     * @return \models\Producto Instancia del registro o null si no lo encuentra.
     */
    public static function findOne( $id )
    {
        $stmt = self::getDb()->prepare( "SELECT * FROM ".self::getTablename()." WHERE id = :id" );
        if ( $stmt->execute( [ "id" => $id ] ) ) {
            $result = $stmt->fetch( \PDO::FETCH_OBJ );
            if ( !empty( $result ) ) {
                $p = new Producto();
                $p->setId( $result->id );
                $p->setNombre( $result->nombre );
                $p->setDescripcion( $result->descripcion );
                $p->setImagen( $result->imagen );
                $p->setIdCategoria( $result->id_categoria );

                return $p;
            }
        }
        
        return null;
    }
    /**
     * Buscar todos los productos.
     */
    public static function findAll()
    {
        $list = [];
        
        $stmt = self::getDb()->query( "SELECT * FROM ".self::getTablename()." ORDER BY id DESC" );
        $result = $stmt->fetchAll( \PDO::FETCH_OBJ );
        if ( !empty( $result ) ) {
            foreach ( $result as $r ) {
                $p = new Producto();
                $p->setId( $r->id );
                $p->setNombre( $r->nombre );
                $p->setDescripcion( $r->descripcion );
                $p->setImagen( $r->imagen );
                $p->setIdCategoria( $r->id_categoria );
                
                $list[] = $p;
            }
        }
        
        return $list;
    }
    /**
     * Exportar los productos a XML.
     * @return string XML como string.
     */
    public static function exportXML()
    {
        $productos = self::findAll();
        $xml="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml.="<productos>\n";
        foreach ($productos as $producto) {
            $xml.="<producto>\n";
            foreach ($producto as $key=>$value) {
                $xml.="<$key>".$value."</$key>\n";   
            }  
            $xml.="</producto>\n";
        }
        $xml .= "</productos>";
        return $xml;
    }
    
    /**
     * Exportar un producto a XML.
     * @return string XML como string.
     */
    public static function exportXMLOneProduct($id)
    {
        $producto = Producto::findOne( $id );
        $xml="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml.="<producto>\n";
        foreach ($producto as $key=>$value) {
            $xml.="<$key>".$value."</$key>\n";
        }
        $xml.="</producto>\n";
        return $xml;        
    }

}