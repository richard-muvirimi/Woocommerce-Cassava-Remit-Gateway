<?php
if (!defined('ABSPATH')) exit(); // Exit if accessed directly

/*
 * Plugin Name: WooCommerce Cassava Remit Gateway
 * Plugin URI: http://tyganeutronics.com/shop/cassavaremit
 * Description: Adds Cassava Remit Gateway to WooCommerce e-commerce plugin
 * Version: 1.0.0
 * Author: Tyganeutronics
 * Author URI: https://tyganeutronics.com/
 */

// Include our Gateway Class and register Payment Gateway with WooCommerce
add_action('plugins_loaded', 'woo_cassavaremit_init', 0);

function woo_cassavaremit_init()
{

	// If the parent WC_Payment_Gateway class doesn't exist
	// it means WooCommerce is not installed on the site
	// so do nothing
	if (!class_exists('WC_Payment_Gateway')) return;

	// If we made it this far, then include our Gateway Class
	include_once('woo-cassava-remit.php');

	// Now that we have successfully included our class,
	// Lets add it too WooCommerce
	add_filter('woocommerce_payment_gateways', 'woo_add_cassavaremit_gateway');

	function woo_add_cassavaremit_gateway($methods)
	{

		$methods[] = 'WC_Gateway_Cassava_Remit';
		return $methods;
	}
}

// Add custom action links
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'cassavaremit_options_link');

function cassavaremit_options_link($links)
{

	$plugin_links = array('<a href="' . admin_url('admin.php?page=wc-settings&tab=checkout&section=cassavaremit') . '">' . __('Settings', 'woocommerce') . '</a>');

	// Merge our new link with the default ones
	return array_merge($plugin_links, $links);
}