<main class="contenedor seccion contenido-centrado">
    <h1 data-cy="titulo-propiedad"><?php echo $propiedad->titulo; ?></h1>

    <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="Imagen de la propiedad" />

    <div class="resumen-propiedad">
        <p class="precio"><?php echo $propiedad->precio; ?></p>

        <ul class="iconos-caracteristicas">
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="Icono wc" />
                <p><?php echo $propiedad->wc; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="Icono estacionamiento" />
                <p><?php echo $propiedad->parqueaderos; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="Icono habitaciones" />
                <p><?php echo $propiedad->habitaciones; ?></p>
            </li>
        </ul>
        <?php echo $propiedad->descripcion; ?>
    </div>
</main>