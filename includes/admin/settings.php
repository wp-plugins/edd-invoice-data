<?php

function bpmj_edd_invoice_data_add_settings($settings) {

    $edd_invoice_data_settings = array(
        'edd_id_header' => array(
            'id' => 'edd_id_header',
            'name' => '<strong>' . __('Invoice data', 'bpmj-edd-invoice-data') . '</strong>',
            'type' => 'header'
        ),
        /*
        'edd_id_invoice' => array(
            'id' => 'edd_id_invoice',
            'name' => __('Dane do faktury', 'bpmj-edd-invoice-data'),
            'desc' => __('Po zaznaczeniu tej opcji, podczas składania zamówienia pojawią się dodatkowe pola umożliwiające pobranie danych do faktury', 'bpmj-edd-invoice-data'),
            'type' => 'checkbox'
        ),
         *
         */
        'edd_id_gateways' => array(
            'id'      => 'edd_id_gateways',
            'name'    => __( 'Payment gateways', 'bpmj-edd-invoice-data' ),
            'desc'    => __( 'Select for which payment gateways enable billing.', 'bpmj-edd-invoice-data' ),
            'type'    => 'bpmj_edd_id_gateways',
            'options' => edd_get_payment_gateways()
        ),
        'edd_id_force' => array(
            'id' => 'edd_id_force',
            'name' => __('Require the invoice', 'bpmj-edd-invoice-data'),
            'desc' => __('When you select this option, enter the invoice data will be mandatory', 'bpmj-edd-invoice-data'),
            'type' => 'checkbox'
        ),
        'edd_id_person' => array(
            'id' => 'edd_id_person',
            'name' => __('Invoices also for individuals', 'bpmj-edd-invoice-data'),
            'desc' => __('When you select this option, billing will also be able to give individuals (name and address)', 'bpmj-edd-invoice-data'),
            'type' => 'checkbox'
        )
    );

    return array_merge($settings, $edd_invoice_data_settings);
}

add_filter('edd_settings_gateways', 'bpmj_edd_invoice_data_add_settings', 1);

function edd_bpmj_edd_id_gateways_callback( $args ) {
    global $edd_options;
    foreach ( $args['options'] as $key => $option ) :
        if ( isset( $edd_options[ $args['id'] ][ $key ] ) )
                $enabled = '1';
        else
                $enabled = null;
        echo '<input name="edd_settings[' . $args['id'] . '][' . $key . ']"" id="edd_settings[' . $args['id'] . '][' . $key . ']" type="checkbox" value="1" ' . checked('1', $enabled, false) . '/>&nbsp;';
        echo '<label for="edd_settings[' . $args['id'] . '][' . $key . ']">' . $option['admin_label'] . '</label><br/>';
    endforeach;

    echo '<p class="description">' . $args['desc'] . '</p>';
}

?>