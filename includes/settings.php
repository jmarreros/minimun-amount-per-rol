<?php

namespace dcms\minamount\includes;

/**
 * Class for creating the settings
 */
class Settings{

    public function __construct(){
        add_action('admin_init', [$this, 'init_configuration']);
    }

    // Register seccions and fields
    public function init_configuration(){
        register_setting('dcms_send_amount_options_bd', 'dcms_amount_options', [$this, 'dcms_validate_cb'] );


        // Excel Fields section
        add_settings_section('dcms_form_amount_section',
                            __('Configurar monto', 'dcms-min-amount-per-rol'),
                            [$this,'dcms_section_cb'],
                            'dcms_amount_sfields' );

        add_settings_field('dcms_min_amount_rol',
                            __('Monto Mínimo Rol Distribuidor', 'dcms-min-amount-per-rol'),
                            [$this, 'dcms_section_input_cb'],
                            'dcms_amount_sfields',
                            'dcms_form_amount_section',
                            ['label_for' => 'dcms_min_amount_rol',
                             'required' => true,
                             'description' => 'Ingresa el monto mínimo de la primera compra']
        );


    }

    // Callback section
    public function dcms_section_cb(){
		echo '<hr/>';
	}

    // Callback input field callback
    public function dcms_section_input_cb($args){
        $id = $args['label_for'];
        $req = isset($args['required']) ? 'required' : '';
        $class = isset($args['class']) ? "class='".$args['class']."'" : '';
        $desc = isset($args['description']) ? $args['description'] : '';

        $options = get_option( 'dcms_amount_options' );
        $val = isset( $options[$id] ) ? $options[$id] : '';

        printf("<input id='%s' name='dcms_amount_options[%s]' class='regular-text' type='text' value='%s' %s %s>",
                $id, $id, $val, $req, $class);

        if ( $desc ) printf("<p class='description'>%s</p> ", $desc);

    }

    // Inputs fields sanitation and validation
    public function dcms_validate_cb($input){

        if ( ! is_numeric($input['dcms_min_amount_rol']) ) {
            add_settings_error( 'dcms_messages', 'dcms_file_error', __( 'Ingresa un monto válido', 'dcms-min-amount-per-rol' ), 'error' );
            return false;
        }

        return $input;
    }

}
