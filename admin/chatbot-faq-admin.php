<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

require_once plugin_dir_path(__FILE__) . 'chatbot-faq-settings-page.php';
require_once plugin_dir_path(__FILE__) . 'chatbot-faq-general-tab.php';
require_once plugin_dir_path(__FILE__) . 'chatbot-faq-design-tab.php';
require_once plugin_dir_path(__FILE__) . 'chatbot-faq-settings.php';

function chatbot_faq_add_admin_menu() {
    if (current_user_can('manage_options')) {
        add_options_page(
            'Chatbot FAQ Settings',
            'Chatbot FAQ',
            'manage_options',
            'chatbot-faq-settings',
            'chatbot_faq_settings_page'
        );
    }
}
add_action('admin_menu', 'chatbot_faq_add_admin_menu');

function chatbot_faq_enqueue_scripts($hook) {
    if ('settings_page_chatbot-faq-settings' !== $hook) {
        return;
    }
    
    wp_enqueue_script('chatbot-faq-script', plugins_url('chatbot-faq-script.js', __FILE__), array('jquery'), '1.0.0', true);

    $sticky_title = get_option('chatbot_faq_sticky_title', false);
    error_log('chatbot_faq_sticky_title: ' . $sticky_title);

    wp_localize_script('chatbot-faq-script', 'chatbotFaqSettings', array(
        'sticky_title' => $sticky_title
    ));
}
add_action('admin_enqueue_scripts', 'chatbot_faq_enqueue_scripts');
?>
