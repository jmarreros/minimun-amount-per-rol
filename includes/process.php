<?php

namespace dcms\minamount\includes;

/**
 * Class for processing hooks
 */
class Process{

    public function __construct(){
        add_action( 'woocommerce_checkout_process', [ $this, 'wc_minimum_order_amount' ] );
        add_action( 'woocommerce_before_cart', [ $this, 'wc_minimum_order_amount' ] );
    }

    function wc_minimum_order_amount() {

        // Validation Rol and First buy
        if ( ! $this->is_user_rol() || ! $this->is_first_buy() ) return;

        $dcms_amount = get_option('dcms_amount_options', 0);
        $minimum = (float)$dcms_amount['dcms_min_amount_rol'];

        if ( WC()->cart->total < $minimum ) {

            if( is_cart() ) {

                wc_print_notice(
                    sprintf( 'Your current order total is %s — you must have an order with a minimum of %s to place your order ' ,
                        wc_price( WC()->cart->total ),
                        wc_price( $minimum )
                    ), 'error'
                );

            } else {

                wc_add_notice(
                    sprintf( 'Your current order total is %s — you must have an order with a minimum of %s to place your order' ,
                        wc_price( WC()->cart->total ),
                        wc_price( $minimum )
                    ), 'error'
                );

            }
        }
    }


    private function is_user_rol(){
        $user = wp_get_current_user();
        return in_array( DCMS_MINAMOUNT_ROL, (array) $user->roles );
    }

    private function is_first_buy(){
        return $this->get_total_orders_user() == 0;
    }

    private function get_total_orders_user(){
        $current_user = wp_get_current_user();
        $numorders = wc_get_customer_order_count( $current_user->ID );

        $args = array(
            'customer_id' => $current_user->ID,
            'post_status' => 'cancelled',
            'post_type' => 'shop_order',
            'return' => 'ids',
        );
        $numorders_cancelled = 0;
        $numorders_cancelled = count( wc_get_orders( $args ) );

        return $numorders - $numorders_cancelled;
    }
}


