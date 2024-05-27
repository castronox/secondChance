<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Éxito - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Éxito en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>
	</head>
	<body>
		<?= (TEMPLATE)::getLogin() ?>
		<?= (TEMPLATE)::getHeader('Éxito') ?>
		<?= (TEMPLATE)::getMenu() ?>
		<?= (TEMPLATE)::getBreadCrumbs(["Éxito" => NULL]) ?>
		<?= (TEMPLATE)::getFlashes() ?>
		
		<main>
    		<h2>Éxito en la operación solicitada</h2>
    
    		<div class='success'>
    			<?= $mensaje ?>
			</div>
			
			<nav class="enlaces centrado">
    			<a class="button" onclick="history.back()">Atrás</a>  
    		</nav>
    		
		</main>
		<?= (TEMPLATE)::getFooter() ?>
	</body>
</html>

