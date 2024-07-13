<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

global $wpdb;

// Function to delete options and cache.
function chatbot_faq_delete_options_cache($option_name) {
    delete_option($option_name);
    wp_cache_delete($option_name, 'options');
}

// Get all options related to the plugin.
$options = get_option('chatbot_faq_options');

if ($options) {
    foreach ($options as $option_name => $option_value) {
        chatbot_faq_delete_options_cache($option_name);
    }
}
?>
