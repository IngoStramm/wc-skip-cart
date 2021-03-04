<?php

add_action('wp_enqueue_scripts', 'wc_skip_cart_frontend_scripts');

function wc_skip_cart_frontend_scripts()
{

    $min = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', '10.0.0.3'))) ? '' : '.min';

    if (empty($min)) :
        wp_enqueue_script('wc-skip-cart-livereload', 'http://localhost:35729/livereload.js?snipver=1', array(), null, true);
    endif;

    wp_register_script('wc-skip-cart-script', WC_SKIP_CART_URL . 'assets/js/wc-skip-cart' . $min . '.js', array('jquery'), '1.0.0', true);

    wp_enqueue_script('wc-skip-cart-script');

    wp_localize_script('wc-skip-cart-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_enqueue_style('wc-skip-cart-style', WC_SKIP_CART_URL . 'assets/css/wc-skip-cart.css', array(), false, 'all');
}
