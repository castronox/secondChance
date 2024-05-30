<?php
# Implementa el acceso al rol de administrador o de bibliotecario
Auth::oneRole(['ROLE_ADMIN', 'ROLE_VENDOR']);
?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <title> Perfil de <?= $user->displayname ?> </title>

    <!-- META -->
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta name='description' content='Lista de libros de <?= APP_NAME ?>'>
    <meta name='author' content='Cristian Castro'>


    <!-- FAVICON -->
    <link rel='shortcut icon' href='/favicon.ico' type='image/png'>


    <!-- CSS -->
    <?= (TEMPLATE)::getCss() ?>
</head>

<body>
    <?= (TEMPLATE)::getLogin() ?>
    <?= (TEMPLATE)::getHeader('Perfil de ' . $user->displayname) ?>
    <?= (TEMPLATE)::getMenu() ?>
    <?= (TEMPLATE)::getFlashes() ?>


    <!-- MIGAS -->
    <?= (TEMPLATE)::getBreadCrumbs([

        'Inicio' => '/',
        'Home' => NULL,
    ]) ?>
    <main>
        <h1>Perfil de <?= $user->displayname ?> en <?= APP_NAME ?></h1>

        <div class="flex-container">
            <section class="flex2">

                <h2><?= "Datos de $user->displayname" ?></h2>

                <p><b>Nombre:</b> <?= $user->displayname ?> </p>
                <p><b>Email:</b> <?= $user->email ?> </p>
                <p><b>Teléfono</b> <?= $user->phone ?> </p>
                <p><b>Fecha de alta:</b> <?= $user->created_at ?> </p>
                <p><b>Última modificación:</b> <?= $user->updated_at ?? '--' ?> </p>

            </section>


            <figure class="flex1 centrado">

                <img src="<?= USER_IMAGE_FOLDER . '/' . ($user->picture ?? DEFAULT_USER_IMAGE) ?>" class="cover"
                    alt="Imagen de perfil de <?= $user->displayname ?>">
                <figcaption>Imagen de perfil de <?= $user->displayname ?></figcaption>
            </figure>

        </div>

        <h2>anuncios de <?= $user->displayname ?></h2>
        <?php
        if (!$anuncios) {
            echo "<p>No hay anuncios de este usuario.</p>";
        } else { ?>

<table>
    <tr>
        <th>Foto</th>
        <th>ID Anuncio</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Estado</th>
    </tr>
    <?php
    foreach ($anuncios as $anuncio) {
        echo "<tr>";
        echo "<td class='centrado'>";
        echo "<img src='" . ANUNCIO_IMAGE_FOLDER . '/' . ($anuncio->foto ?? DEFAULT_ANUNCIO_IMAGE) . "' class='cover-mini' alt='Portada de " . htmlspecialchars($anuncio->nombre, ENT_QUOTES, 'UTF-8') . "'>";
        echo "</td>";
        echo "<td>$anuncio->id</td>";
        echo "<td>$anuncio->nombre</td>";
        echo "<td>$anuncio->precio €</td> ";
        echo "<td>$anuncio->estado</td>";
        echo "</tr>";
    }
    ?>
</table>

        <?php } ?>



    </main>

    <?= (TEMPLATE)::getFooter() ?>
</body>

</html>



