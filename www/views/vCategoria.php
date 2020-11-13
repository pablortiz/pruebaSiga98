<html>
    <head>
        <meta charset="UTF-8">
        <title>Categoria</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <?php if ( !empty( $models[ "categoria" ] ) ) : ?>
                <?php
                $id = $models[ "categoria" ]->getId();
                ?>
                <h3>Categoria: <?= ( !empty( $id ) ? $id : "Nuevo" ) ?></h3>
				<!-- FORMULARIO NUEVA CATEGORIA  -->
                <form class="form" method="POST" enctype="multipart/form-data">
                    <?php if ( !empty( $models[ "error" ] ) ) : ?>
                        <div class="alert alert-danger"><?= htmlentities( $models[ "error" ] ) ?></div>
                    <?php endif; ?>
                    <input type="hidden" name="id" value="<?= $models[ "categoria" ]->getId() ?>" />
                    <input type="hidden" name="action" value="save" />
                    <div class="form-group">
                        <label for="nombre" class="control-label">Nombre</label>
                        <input class="form-control" maxlength="160" type="text" id="nombre" name="nombre" value="<?= htmlentities( $models[ "categoria" ]->getNombre() ) ?>" />
                    </div>
                    <div class="form-group">
                        <label for="descripcion" class="control-label">Descripci&oacute;n</label>
                        <textarea class="form-control" maxlength="258" id="descripcion" name="descripcion"><?= htmlentities( $models[ "categoria" ]->getDescripcion() ) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <a class="btn btn-success" href="/categorias" >Cancelar</a>
                </form>
            <?php endif; ?>
        </div>
    </body>
</html>