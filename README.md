Se tiene una aplicación web que permite listar, crear y editar los productos de una base de datos (BD_Productos). No se permite realizar ningún almacenamiento en disco.
Los requisitos de la aplicación son:
1.	Validaciones:
•	Nombre: máximo 160 caracteres en UTF‐8
•	Descripción: máximo 258 caracteres en UTF‐8
•	Imagen en formato .jpg o .png
2.	OK La url del producto  es: http://localhost/productos/{id_producto}
3.	OK Se permite la exportación a un fichero XML de todos los productos con todos sus datos
Datos de acceso BD:
Host: localhost
User: root
Pass: (vacía)
Acceso al código desplegado:
	DocumentRoot: C:\xampp\htdocs

Se solicita:

Corregir todos los errores para que se cumplan los requisitos indicados en la prueba
1-	Arreglar todos los errores que se encuentren en el código (detallar todos los errores detectados y corregirlos)

	Site.php
cambiar:
private $defaultAction = "index";
Por:
private $defaultAction = "actionIndex"; 

Metodo:  public function getDefaultAction()
Cambiar  
return $this->$defaultAction;
Por:
return $this->defaultAction;

	Producto.php: 
Método: public function setImagen( $imagen )
cambiar:
$this->imagen = $$imagen;
Por:
$this->imagen = $imagen;



	index.php:
cambiar: 
$action = "action".ucwords( $ctrl->getDefaultAction() );
por:
$action =  $ctrl->getDefaultAction() ;
	Site.php:
Metodo: actionProductos()
cambiar:
Producto::setDescripcion( $_POST[ "descripcion" ] );
por:
$producto->setDescripcion( $_POST[ "descripcion" ] );


2-	OK Completar el método para exportar a xml (exportXML()) 
3-	OK Añadir las validaciones de los campos de Producto (validate())
Añadir las siguientes funcionalidades nuevas:
1-	OK Permitir crear categorías con nombre y descripción (vista con listado de categorías, crear, editar y eliminar categorías) 
2-	OK Añadir categoría a los productos (se permite seleccionar de entre las categorías existentes) 
3-	OK Permitir exportar un único producto a xml 
4-	OK Añadir confirmación al eliminar un producto 
5-	OK Hacer que la imagen no sea obligatoria y permitir eliminar la imagen de un producto ya existente
