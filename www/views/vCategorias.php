<html>
<head>
    <meta charset="UTF-8">
    <title>Categorias</title>
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
			Categorias:&nbsp; 
			<a class="btn btn-success" href="/categoria">Nueva categoria</a>&nbsp;&nbsp; 
			<a class="btn btn-success" href="/index.php" >Productos</a>
		</h3>

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Nombre</th>
					<th>Descripci&oacute;n</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php if ( !empty( $models[ "categorias"  ] ) ) : ?>
               <?php foreach ( $models[ "categorias"  ] as $p ) : ?>
            	<tr>
					<td><?= htmlentities( $p->getId() ) ?></td>
					<td><?= htmlentities( $p->getNombre() ) ?></td>
					<td><?= htmlentities( $p->getDescripcion() ) ?></td>
					<td><a class="btn btn-primary" href="/categoria/<?= $p->getId() ?>">Editar</a>
						<a class="btn btn-primary" data-toggle="modal"
						data-target="#EliminarCategoriaModal" id="Eliminar"
						data-id="<?= $p->getId() ?>">Eliminar</a></td>
			    </tr>
               <?php endforeach; ?>
            <?php else: ?>
                <tr>
					<td colspan="5">No hay categorias.</td>
				</tr>
            <?php endif; ?>
            </tbody>
		</table>
	</div>

	<div class="modal fade" id="EliminarCategoriaModal" tabindex="-1"
		role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">ELIMINAR CATEGORIA<div id="idCategoria"></div></h5>
					<button class="close" type="button" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style="text-align: left;">
					<br> 
					<a class="btn btn-danger" href="#" id="EliminarCategoriaLink">Eliminar</a> 
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
    $('#EliminarCategoriaModal').on('show.bs.modal', function(e) {  
     	$("#idCategoria").html( $(e.relatedTarget).data('id') ); 
        $("#EliminarCategoriaLink").attr("href", "/categoria/"+$(e.relatedTarget).data('id')+"/delete");
    });
</script>

