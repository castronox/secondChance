<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>LogIn - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Nueva clave en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>
	</head>
	<body>
		<?= (TEMPLATE)::getLogin() ?>
		<?= (TEMPLATE)::getHeader('Nueva clave') ?>
		<?= (TEMPLATE)::getMenu() ?>
		<?= 
		  (TEMPLATE)::getBreadCrumbs([
		    "LogIn" => "/Login",
		    "Nueva clave" => NULL
		  ]) 
		?>
		<?= (TEMPLATE)::getFlashes() ?>
		
		<main>
			
    			
        		<form class="w50 bloque-centrado" method="POST" autocomplete="off" id="login" action="/Forgotpassword/send">
        			
        			<h2>Recuperación de password</h2>
    				<p class="justificado">Introduce tus datos y se te enviará una 
    					nueva clave con la que podrás acceder a la aplicación. 
    					Recuerda que debes cambiarla lo antes posible.</p>
    		
    				<div style="margin: 10px;">
            			<label for="email">email:</label>
            			<input type="email" name="email" id="email" value="<?= old('email') ?>" required>
            			<br>
            			<label for="phone">teléfono:</label>
            			<input type="text" name="phone" id="phone" value="<?= old('phone') ?>" required>
        			</div>
        			
        			<div class="centrado">
        				<input type="submit" class="button" name="nueva" value="Nueva clave">
        			</div>  
        			<div class="derecha">
    				<a href="/Login">Volver a Login</a>
    			</div>      			
        		</form>
        		
        		
    		
		</main>
		
		<?= (TEMPLATE)::getFooter() ?>
	</body>
</html>

