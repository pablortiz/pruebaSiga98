<?php
namespace controllers;

use models\Producto;
use models\mCategoria;

/**
 * Controlador.
 * 
 * @author obarcia
 */
class Site
{
    /**
     * Acción por defecto.
     * @var string
     */
    private $defaultAction = "actionIndex";
    
    /**
     * Devuelve la acción por defecto.
     * @return string Acción por defecto.
     */
    public function getDefaultAction()
    {
        return $this->defaultAction;
    }
    /**
     * Rederizar la vista.
     * @param string $view Nombre de la vista.
     * @param array $models Listado de modelos.
     */
    protected function renderView( $view, $models = [] )
    {
        include( __DIR__."/../views/".$view );
    }
    /**
     * Página principal.
     */
    public function actionIndex()
    {
        $productos = Producto::findAll();
        
        $this->renderView( "index.php", [ "productos" => $productos ] );
    }
    /**
     * Vista de un producto.
     */
    public function actionProductos()
    {
        if ( !empty( $_GET[ "id" ] ) ) {
            $producto = Producto::findOne( $_GET[ "id" ] );
        }
        
        $categorias = mCategoria::findAll();
        $method = ( !empty( $_GET[ "method" ] ) ? $_GET[ "method" ] : "" );
       
        if ( $method == "delete" ) {
            // Eliminar el producto
            if ( !empty( $producto ) ) {
                $producto->delete();
                
                header( "Location: /" );
            } else {
                throw new \Excetion( "Producto no encontrado." );
            }
        } else {
            $headers = getallheaders();
            if ( in_array( $headers[ "Accept" ], [ "image/jpg", "image/jpeg", "image/png" ] ) || !empty( $_GET[ "image" ] ) ) {
                if ( !empty( $producto ) ) {
                    $imageB64 = $producto->getImagen();
                    if ( !empty( $imageB64 ) ) {
                        $content = base64_decode( $imageB64 );
                    } else {
                        exit;
                    }
                    header( 'Content-Description: File Transfer');
                    header( 'Content-Type: image/png' );
                    header( 'Content-Disposition: attachment; filename=producto'.$producto->getId()."_image.png" ); 
                    header( 'Content-Transfer-Encoding: binary');
                    header( 'Connection: Keep-Alive');
                    header( 'Expires: 0');
                    header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header( 'Pragma: public' );
                    header( 'Content-Length: '.strlen( $content ) );
                    echo $content;

                    exit;
                }
            } else {
                if ( empty( $producto ) && empty( $_GET[ "id" ] ) ) {
                    $producto = new Producto();
                }
                
                if ( !empty( $producto ) ) {
                    if ( !empty( $_POST[ "action" ] ) && $_POST[ "action" ] == "save" ) {
                        $producto->setNombre( $_POST[ "nombre" ] );
                        $producto->setDescripcion( $_POST[ "descripcion" ] );
                        
                        $producto->setIdCategoria( $_POST[ "idCategoria" ] );
                        
                        if ( !empty( $_FILES[ "imagen" ][ "tmp_name" ] ) && in_array( $_FILES[ "imagen" ][ "type" ], [ "image/jpg", "image/jpeg", "image/png" ] ) ) {
                            $producto->setImagen( base64_encode( file_get_contents( $_FILES[ "imagen" ][ "tmp_name" ] ) ) );
                        }
                        if ( $producto->save() ) {
                            header( "Location: /" );
                        } else {
                            $this->renderView( "vProducto.php", [ "producto" => $producto, "error" => " " . $producto->getError() ] );
                        }
                    } else {
                        $this->renderView( "vProducto.php", [ "producto" => $producto, "categorias" => $categorias ] );
                    }
                } else {
                    throw new \Excetion( "Producto no encontrado." );
                }

                return;
            }
        }
        
        new \Exception( "Producto not found." );
    }
    /**
     * Exportar el XML con todos los productos.
     */
    public function actionXml()
    {
        $content = Producto::exportXML();

        header( 'Content-Description: File Transfer');
        header( 'Content-Type: application/xml' );
        header( 'Content-Disposition: attachment; filename=productos.xml' ); 
        header( 'Content-Transfer-Encoding: binary');
        header( 'Connection: Keep-Alive');
        header( 'Expires: 0');
        header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header( 'Pragma: public' );
        header( 'Content-Length: '.strlen( $content ) );

        echo $content;
        exit;
    }
    /**
     * Exportar el XML con 1 producto.
     */
    public function actionXmlOneProduct()
    {
        if ( !empty( $_GET[ "id" ] ) ) {
            $content = Producto::exportXMLOneProduct($_GET[ "id" ]);

            header( 'Content-Description: File Transfer');
            header( 'Content-Type: application/xml' );
            header( 'Content-Disposition: attachment; filename=producto_'.$_GET[ "id" ].'.xml' );
            header( 'Content-Transfer-Encoding: binary');
            header( 'Connection: Keep-Alive');
            header( 'Expires: 0');
            header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header( 'Pragma: public' );
            header( 'Content-Length: '.strlen( $content ) );
            
            echo $content;
            exit;
        } 
        new \Exception( "Producto not found." );
    }
    /**
     * Vista de todas categorias.
     */
    public function actionCategorias()
    { 
        $categorias = mCategoria::findAll();
        $this->renderView( "vCategorias.php", [ "categorias" => $categorias ] ); 
    }
    
    /**
     * Vista de una categoria.
     */
    public function actionCategoria()
    {
               
        if ( !empty( $_GET[ "id" ] ) ) {
            $categoria = mCategoria::findOne( $_GET[ "id" ] );
        }
        
        $method = ( !empty( $_GET[ "method" ] ) ? $_GET[ "method" ] : "" );

        if ( $method == "delete" ) {
            // Eliminar la categoria
            if ( !empty( $categoria ) ) {
                $categoria->delete();
                header( "Location: /categorias" );
            } else {
                throw new \Excetion( "Categoria no encontrado." );
            }
        }else{
          
            if ( empty( $producto ) && empty( $_GET[ "id" ] ) ) {
                $categoria = new mCategoria();
            }
            
            if ( !empty( $categoria ) ) {
                
                if ( !empty( $_POST[ "action" ] ) && $_POST[ "action" ] == "save" ) {
                    $categoria->setNombre( $_POST[ "nombre" ] );
                    $categoria->setDescripcion( $_POST[ "descripcion" ] );
                    if ( $categoria->save() ) {
                        header( "Location: /categorias" );
                    } else {
                        $this->renderView( "vCategoria.php", [ "categoria" => $categoria, "error" => "No se pudo guardar el registro." ] );
                    }
                } else {
                    // EDITA UNA CATEGORIA
                    $this->renderView( "vCategoria.php", [ "categoria" => $categoria ] );
                }
            } else {
                throw new \Excetion( "Categoria no encontrada." );
            }                
                return;
        }
    }
    
    public function actionImagen()
    {
      if ( !empty( $_GET[ "id" ] ) ) {
          $producto = Producto::findOne( $_GET[ "id" ] );
          
        }
      //print_r($_REQUEST);
      
      //print_r($producto);
      
      $method = ( !empty( $_GET[ "method" ] ) ? $_GET[ "method" ] : "" );
      
      if ( $method == "delete" ) {
          // Eliminar el producto
          if ( !empty( $producto ) ) {
              $producto->deleteImagen();
              header( 'Location: /productos/'.$producto->getId());
          } else {
              throw new \Excetion( "Producto no encontrado." );
          }
      }
      
      exit;
    }
    
}
