<?php

class WC_Gateway_ATH_Movil_Payment_Gateway extends WC_Payment_Gateway {
    public function __construct() {
        $this->id = 'ath_movil';
        $this->icon = null;
        $this->method_title = 'ATH Móvil';
        $this->has_fields = false;

        /* Definir los campos del formulario de las opciones de la pasarela */
        $this->init_form_fields();
        $this->init_settings();

        $this->title = $this->get_option('title');
        $this->method_description = $this->get_option('description');

        // Hook para guardar las opciones del formulario del admin
        add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
    }

    public function init_form_fields() {

        $this->form_fields = array(
            'enabled' => array(
                'title' => __( 'Enable/Disable', 'woocommerce' ),
                'type' => 'checkbox',
                'label' => __( 'Enable ATH Móvil Payment', 'evolution-functions' ),
                'default' => 'yes'
            ),
            'title' => array(
                'title' => __( 'ATH Móvil Payment Gateway', 'woocommerce' ),
                'type' => 'text',
                'description' => __( 'Esto controla el título que el usuario ve durante el checkout.', 'evolution-functions' ),
                'default' => __( 'ATH Móvil', 'woocommerce' ),
                'desc_tip'      => true,
            ),
            'description' => array(
                'title' => __( 'Mensaje para el cliente', 'woocommerce' ),
                'type' => 'textarea',
                'default' => ''
            )
        );
    }

    /**
     * Handle para procesar el pago.
     */
    public function process_payment( $order_id ) {
        global $woocommerce;
        $order = new WC_Order( $order_id );
    
        // Marcar pago completado
        $order->payment_complete();

        // Clear cart
        $woocommerce->cart->empty_cart();

        return array(
            'result' => 'success',
            'redirect' => $this->get_return_url( $order )
        );
    }
}