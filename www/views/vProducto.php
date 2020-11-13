<html>
    <head>
        <meta charset="UTF-8">
        <title>Productos</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <?php if ( !empty( $models[ "producto" ] ) ) : ?>
                <?php
                $id = $models[ "producto" ]->getId();
                ?>
                <h3>Producto: <?= ( !empty( $id ) ? $id : "Nuevo" ) ?></h3>
				<!-- FORMULARIO NUEVO PRODUCTO  -->
                <form class="form" method="POST" enctype="multipart/form-data">
                    <?php if ( !empty( $models[ "error" ] ) ) : ?>
                        <div class="alert alert-danger"><?= htmlentities( $models[ "error" ] ) ?></div>
                    <?php endif; ?>
                    <input type="hidden" name="id" value="<?= $models[ "producto" ]->getId() ?>" />
                    <input type="hidden" name="action" value="save" />
                    <div class="form-group">
                        <label for="nombre" class="control-label">Nombre</label>
                        <input class="form-control" maxlength="160" type="text" id="nombre" name="nombre" value="<?= htmlentities( $models[ "producto" ]->getNombre() ) ?>" />
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="control-label">Categoria</label>
                        <input style="display:none"  id="idCategoria" name="idCategoria" value="<?= htmlentities( $models[ "producto" ]->getIdCategoria() ) ?>" />
                        <select class="form-control" id="categorias">
                            <option value = "0">Seleciona una opci&oacute;n</option>
                            <?php
                             foreach ($models[ "categorias" ] as $categoria){ 
                                 ?>
                                 <option value = "<?=$categoria->getId()?>">  <?=$categoria->getNombre()?></option>
                                 <?php 
                             }
                             ?>
                         </select>
                    </div>                   
                    <div class="form-group">
                        <label for="descripcion" class="control-label">Descripci&oacute;n</label>
                        <textarea class="form-control" maxlength="258" id="descripcion" name="descripcion"><?= htmlentities( $models[ "producto" ]->getDescripcion() ) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="imagen" class="control-label">Imagen</label>
                        <input class="form-control" id="imagen" name="imagen" type="file" />
                    </div>
                    <div>
               
                    <div style="position: relative;">

                     	<?php if ( !empty( $models[ "producto" ] ) && $models[ "producto" ]->getImagen() != null ) : ?>
                    	<img src="/productos/<?= htmlentities( $models[ "producto" ]->getId() ) ?>?image=1" />
                    	<div style="position: absolute; left: 0px; top: 0px;">
                    	 <a class="alert alert-danger" data-toggle="modal" data-target="#EliminarImagenModal" data-id="<?= htmlentities( $models[ "producto" ]->getId() ) ?>">Eliminar</a>    
                    	</div>                    	
                    	<?php endif; ?>
                    
                    </div>

                    <br>
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a class="btn btn-success" href="/index.php" >Cancelar</a>
                </form>
            <?php endif; ?>
        </div>
        <!-- V MODAL ELIMINA IMAGEN -->
    	<div class="modal fade" id="EliminarImagenModal" tabindex="-1"
    		role="dialog" aria-hidden="true">
    		<div class="modal-dialog" role="document">
    			<div class="modal-content">
    				<div class="modal-header">
    					<h5 class="modal-title" id="exampleModalLabel">ELIMINAR IMAGEN: <div id="idImagen"></div></h5>
    					<button class="close" type="button" data-dismiss="modal"
    						aria-label="Close">
    						<span aria-hidden="true">&times;</span>
    					</button>
    				</div>
    				<div class="modal-body" style="text-align: left;">
    					<br> 
    					<a class="btn btn-danger" href="#" id="EliminarImagenLink">Eliminar</a> 
    					<a class="btn btn-danger" data-dismiss="modal">Cancelar</a> <br>
    				</div>
    				<div class="modal-footer"></div>
    			</div>
    		</div>
    	</div>        
    </body>
</html>
<script>
    $("#categorias").on('change',function(){
        $("#idCategoria").val( $(this).val() ); 
    });
    
    $('#EliminarImagenModal').on('show.bs.modal', function(e) {
        $("#idImagen").html( $(e.relatedTarget).data('id') );  
        $("#EliminarImagenLink").attr( "href", "/imagen/"+$(e.relatedTarget).data('id')+"/delete" );
    });
    
    $( document ).ready(function() {
   		$('#categorias').val(<?=  $models[ "producto" ]->getIdCategoria() != null  ? $models[ "producto" ]->getIdCategoria() : 0  ?>);
	});
</script>