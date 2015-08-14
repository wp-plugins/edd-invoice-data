<?php
/**
 * Ładuje skrypty potrzebne do działania wtyczki ( front-end oraz back-end )
 */

// Zakoncz, jeżeli plik jest załadowany bezpośrednio
if ( !defined( 'ABSPATH' ) ) exit;


/*
 * Załącza skrypty js ( frontend )
 */
function bpmj_edd_invoice_data_load_scripts() {

    wp_enqueue_script( 'bpmj_edd_invoice_data_scripts', BPMJ_EDD_ID_PLUGINS_URL . 'assets/js/scripts.js', array( 'jquery' ), BPMJ_EDD_ID_VERSION );
}
add_action( 'wp_enqueue_scripts', 'bpmj_edd_invoice_data_load_scripts' );


/*
 * Załącza arkusze styli CSS ( frontend )
 */
function bpmj_edd_invoice_data_load_styles() {

    wp_register_style( 'bpmj_edd_invoice_data_form', BPMJ_EDD_ID_PLUGINS_URL . 'assets/css/style.css');
    wp_enqueue_style( 'bpmj_edd_invoice_data_form' );
}
add_action( 'wp_enqueue_scripts', 'bpmj_edd_invoice_data_load_styles' );
