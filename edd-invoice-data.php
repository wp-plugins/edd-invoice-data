<?php

/*
  Plugin Name: Easy Digital Downloads - Invoice Data
  Plugin URI: 
  Description: This plugin allows you to gather invoice data for any EDD payment gateway
  Version: 1.0.1
  Author: upSell.pl & Better Profits
  Author URI: http://upsell.pl

 */

if ( ! defined( 'BPMJ_UPSELL_STORE_URL' ) ) {
    define( 'BPMJ_UPSELL_STORE_URL', 'http://upsell.pl' );
}
define( 'BPMJ_EDD_ID_NAME', 'EDD Invoice Data' );

// Definiowanie stałych
define('BPMJ_EDD_ID_DIR', dirname(__FILE__)); // Główny katalog wtyczki
define('BPMJ_EDD_ID_PLUGINS_URL', plugins_url('/', __FILE__));
define('BPMJ_EDD_ID_INC', plugins_url('includes', __FILE__)); // URL do katalogu incudes

// Licencja / Autoaklualizacja
if ( ! defined( 'BPMJ_EDD_ID_VERSION' ) ) {
	define( 'BPMJ_EDD_ID_VERSION', '1.0.1' );
}

//  Dołącza wymagane pliki
include_once('includes/actions.php'); // Plik z akcjami
include_once('includes/functions.php'); // Plik z funckjami
include_once('includes/scripts.php'); // Skrypty


if (is_admin()) {
    include_once('includes/admin/settings.php');
}

/**
 * - Rejestracja domeny dla tłumaczeń
 */
function bpmj_edd_invoice_data_add_textdomain() {
    load_plugin_textdomain('bpmj-edd-invoice-data', false, dirname( plugin_basename( __FILE__ ) ) . '/languages');
}
add_action('plugins_loaded', 'bpmj_edd_invoice_data_add_textdomain');