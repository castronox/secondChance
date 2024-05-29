<!DOCTYPE html>
<html lang='es'>
<head>
<meta charset='UTF-8'>
<title> AÑADIR TITULO </title>

<!-- META -->
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<meta name='description' content='Lista de anuncios de <?= APP_NAME ?>'>
<meta name='author' content='Cristian Castro'>


<!-- FAVICON -->
<link rel='shortcut icon' href='/favicon.ico' type='image/png'>


<!-- CSS -->
<?= (TEMPLATE)::getCss()?>
</head>
<body>
<?=(TEMPLATE)::getLogin()?>
<?= (TEMPLATE)::getHeader('AÑADE AQUÍ EL HEADER')?>
<?=(TEMPLATE)::getMenu()?>
<?=(TEMPLATE)::getFlashes()?>

<main>
<h1><?= APP_NAME ?></h1>

<h2>Nuevo anuncio</h2>
		<div class="flex-container">
			<section class="flex1 centrado">
				<form method="POST" enctype="multipart/form-data" action="/anuncio/store">
                <input type="hidden" name="idusuario" value="<?= $user->id ?>">
					<label>Nombre</label>
					<input type="text" name="nombre" value="<?= old('nombre') ?>">
					<br>
					<label>Descripción</label>
					<input type="text" name="descripcion" value="<?= old('descripcion') ?>">
					<br>
					<label>Año</label>
					<input type="text" name="anyo" value="<?= old('anyo') ?>">
					<br><br><br>
					<hr><br>
					<label>Foto</label>
					<input type="file" name="foto" accept="image/*" id="file-with-preview">
					<br>
                    <br><br>
					<hr><br>
					<label>Estado</label>
					<select name="estado">
						<option value="Como_nuevo" <?= oldSelected('estado', 'Como nuevo') ?>>Como nuevo</option>
						<option value="Usado" <?= oldSelected('estado', 'Usado') ?>>Usado</option>
						<option value="Por_restaurar" <?= oldSelected('estado', 'Por restaurar') ?>>Por restaurar</option>
					</select><br><br>
					<label>Precio</label>
					<input type="number" name="precio" value="<?= old('precio') ?>">
					<br><br><br>

					<input type="submit" class="button" name="guardar" value="Guardar">
				</form>
			</section>
			<section class="flex1 centrado">
				<script src="/js/Preview.js"></script>

				<br>

				<figure class="flex1 centrado">
					<img src="<?= ANUNCIO_IMAGE_FOLDER . '/' . DEFAULT_ANUNCIO_IMAGE ?>" id="preview-image" class="cover"
						alt="Previsualización de la portada">
					<figcaption>Previsualización de la portada</figcaption>
				</figure>
			</section>
		</div>
		<br><br>

		<div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a> <a class="button" href="/anuncio/list">Lista de
				anuncios</a>
		</div>



</main>

<?=(TEMPLATE)::getFooter()?>
</body>
</html>