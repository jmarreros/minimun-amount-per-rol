<div class="wrap">

<h1>Monto Mínimo por Rol</h1>

<form action="options.php" method="post">
    <?php

        settings_errors( 'dcms_messages' );

        settings_fields('dcms_send_amount_options_bd');
        do_settings_sections('dcms_amount_sfields');
        submit_button();
    ?>
</form>

</div>