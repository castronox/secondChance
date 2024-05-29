<!DOCTYPE html>
<html lang='es'>
<head>
<meta charset='UTF-8'>
<title> Lista de Anuncios</title>

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
<?= (TEMPLATE)::getHeader('Lista de anuncios')?>
<?=(TEMPLATE)::getMenu()?>
<?=(TEMPLATE)::getFlashes()?>

<main>
<h1><?= APP_NAME ?></h1>

<?php if ($filtro) {
			# El método removeFilterForm necesita conocer el filtro
			# y la ruta a la que se envía el formulario
			echo (TEMPLATE)::removeFilterForm($filtro, '/Anuncio/list');

		} else {

			echo (TEMPLATE)::filterForm(
				# Ruta a la que se envía el formulario
				'/Anuncio/list',
				# Lista de campos para "Buscar en"
				['Nombre' => 'nombre', 'Editorial' => 'editorial', 'Autor' => 'autor'],
				# Lista de campos para "ordenado por"
				['Nombre' => 'nombre', 'Editorial' => 'editorial', 'Autor' => 'autor'],
				# Valor por defecto para "Buscar en"		
				'Autor',
				# Valor por defecto para " Ordenado por"
				'Título'

			);
		} ?>

		<?php if ($anuncios) { ?>

			<div class="derecha">
				<?= $paginator->stats() ?>
			</div>

			<table>

				<tr>
					<th>Foto</th>
					<th>Nombre</th>					
					<th>Año</th>
					<th>Estado</th>
                    <th>Precio</th>
				</tr>

				<?php foreach ($anuncios as $anuncio) { ?>

					<tr class="centrado">
						<td class="centrado">
							<img src="<?= ANUNCIO_IMAGE_FOLDER . '/' . ($anuncio->foto ?? DEFAULT_ANUNCIO_IMAGE ) ?>" class="cover-mini"
								alt="Portada de <?= $anuncio->nombre ?>">

						</td>

						<td><a href='/anuncio/show/<?= $anuncio->id ?>'><?= $anuncio->nombre ?> </a></td>
						<td><?= $anuncio->anyo ?></td>
						<td><?= $anuncio->estado ?></td>
						
						<td>
							<a href='/anuncio/show/<?= $anuncio->id ?>'>Ver</a>
							<?php if (Login::oneRole(['ROLE_LIBRARIAN', 'ROLE_ADMIN'])) { ?>
								- <a href="/anuncio/edit/<?= $anuncio->id ?>?from=list">Editar</a> -
								<a href='/anuncio/delete/<?= $anuncio->id ?>?from=list'>Borrar</a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</table>
			<?= $paginator->ellipsisLinks() ?>
		<?php } else { ?>
			<p>No hay anuncios que mostrar.</p>
		<?php } ?>



</main>

<?=(TEMPLATE)::getFooter()?>
</body>
</html>