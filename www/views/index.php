<html>
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet"
    	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    	integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    	crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    	integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    	crossorigin="anonymous"></script>
    <script
    	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    	integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    	crossorigin="anonymous"></script>
    <script
    	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    	integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    	crossorigin="anonymous"></script>
    
    <style>
    .btn {
    	color: white !important;
    }
    </style>
</head>
<body>
	<div class="container">
		<h3>
			Productos <a class="btn btn-success" href="/productos">Nuevo producto</a>
			<a class="btn btn-primary" href="/xml" target="_blank">XML</a> 
			<a class="btn btn-success" href="categorias">Categorias</a>
		</h3>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>idCategoria</th>
					<th>Nombre</th>
					<th>Descripci&oacute;n</th>
					<th>Imagen</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
            <?php if ( !empty( $models[ "productos"  ] ) ) : ?>
                <?php foreach ( $models[ "productos"  ] as $p ) : ?>
                    <tr>
    					<td><?= htmlentities( $p->getId() ) ?></td>
    					<td><?= htmlentities( $p->getIdCategoria() ) ?></td>
    					<td><?= htmlentities( $p->getNombre() ) ?></td>
    					<td><?= htmlentities( $p->getDescripcion() ) ?></td>
    					<td><img id="imagenProducto" src="/productos/<?= $p->getId() ?>?image=1" /></td>
    					<td>
    					<a class="btn btn-primary"
    						href="/XmlOneProduct/<?= $p->getId() ?>" target="_blank">XML</a> <a
    						class="btn btn-primary" href="/productos/<?= $p->getId() ?>">Editar</a>
    					<a class="btn btn-primary" data-toggle="modal"
    						data-target="#EliminarProductoModal" id="Eliminar"
    						data-id="<?= $p->getId() ?>">Eliminar</a>
    					</td>
    				</tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
					<td colspan="5">No hay productos.</td>
				</tr>
            <?php endif; ?>
          </tbody>
		</table>
	</div>
	<!-- V MODAL ELIMINA PRODUCTO -->
    <div class="modal fade" id="EliminarProductoModal" tabindex="-1"
    	role="dialog" aria-hidden="true">
    	<div class="modal-dialog" role="document">
    		<div class="modal-content">
    			<div class="modal-header">
    				<h5 class="modal-title" id="exampleModalLabel">ELIMINAR PRODUCTO: <div id="idProducto"></div></h5>
    				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
    					<span aria-hidden="true">&times;</span>
    				</button>
    			</div>
    			<div class="modal-body" style="text-align: left;">
    				<br> 
    				<a class="btn btn-danger" href="#" id="EliminarProductoLink">Eliminar</a> 
    				<a class="btn btn-danger" data-dismiss="modal">Cancelar</a> 
    				<br>
    			</div>
    			<div class="modal-footer"></div>
    		</div>
    	</div>
    </div>

</body>
</html>
<script>
    $('#EliminarProductoModal').on('show.bs.modal', function(e) {
        $("#idProducto").html( $(e.relatedTarget).data('id') );  
        $("#EliminarProductoLink").attr( "href", "/productos/"+$(e.relatedTarget).data('id')+"/delete" );
    });
</script>

