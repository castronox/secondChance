
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <title><?= $anuncio->nombre ?> </title>

    <!-- META -->
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta name='description' content='Mostrar usuario.'>
    <meta name='author' content='Cristian Castro'>


    <!-- FAVICON -->
    <link rel='shortcut icon' href='/favicon.ico' type='image/png'>


    <!-- CSS -->
    <?= (TEMPLATE)::getCss() ?>
</head>

<body>
    <?= (TEMPLATE)::getLogin() ?>
    <?= (TEMPLATE)::getHeader('Lista') ?>
    <?= (TEMPLATE)::getMenu() ?>
    <?= (TEMPLATE)::getFlashes() ?>
    <!-- MIGAS -->

    <?php
    // Detectar el origen de la navegación desde la URL o cualquier otra fuente
    $from = $_GET['from'] ?? 'show'; // Por defecto es 'show' si no se especifica
    
    // Definir las migas de pan
    $migas = [
        'Inicio' => '/',
        'Lista de anuncios' => '/anuncio/list',
    ];

    if ($from === 'list') {
        $migas["Editar anuncio $anuncio->id"] = NULL;
    } else {
        // Asumimos que el origen es 'show' o cualquier otro valor
        $migas["Mostrar anuncio $anuncio->id"] = "/anuncio/show/$anuncio->id";
        $migas["Editar anuncio $anuncio->id"] = NULL;
    }
    ?>
        
    <?= (TEMPLATE)::getBreadCrumbs($migas) ?>
    <main>
        <h1><?= APP_NAME ?></h1>

        <div class="flex-container">
            <section class="flex1 centrado">
                <h2><?= $anuncio->nombre ?></h2>

                <p><b>Nombre del anuncio</b>: <?= $anuncio->nombre ?></p>
                <p><b>Descripción</b><?= $anuncio->descripcion ?></p>
                <p><b>Año: </b><?= $anuncio->anyo ?></p>
                <p><b>Estado: </b><?= $anuncio->estado ?></p>
                <p><b>Año: </b><?= $precio->precio ?></p>

            </section>
            <section class="flex1 centrado">

                <figure class="flex1 centrado">
                    <img src="<?= ANUNCIO_IMAGE_FOLDER. '/' . ($anuncio->foto ?? DEFAULT_ANUNCIO_IMAGE) ?>" class="cover"  
                        alt="Portada de <?= $anuncio->descripcion ?>">
                        <figcaption>Usuario: <?= $anuncio->descripcion ?></figcaption>

                </figure>
            </section>
        </div>
        <br><br><br>
        <div class="centrado">
			<a class="button" onclick="history.back()">Atrás</a>
			<a class="button" href="/anuncio/list">Lista de usuarios</a>



		</div>



    </main>

    <?= (TEMPLATE)::getFooter() ?>
</body>

</html>