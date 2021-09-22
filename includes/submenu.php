<?php

namespace dcms\minamount\includes;

/**
 * Class for creating a dashboard submenu
 */
class Submenu{
    // Constructor
    public function __construct(){
        add_action('admin_menu', [$this, 'register_submenu']);
    }

    // Register submenu
    public function register_submenu(){
        add_submenu_page(
            DCMS_MINAMOUNT_SUBMENU,
            __('Monto Mínimo Rol','dcms-min-amount-per-rol'),
            __('Monto Mínimo Rol','dcms-min-amount-per-rol'),
            'manage_options',
            'dcms-minamount',
            [$this, 'submenu_page_callback']
        );
    }

    // Callback, show view
    public function submenu_page_callback(){
        include_once (DCMS_MINAMOUNT_PATH. '/views/main-screen.php');
    }
}