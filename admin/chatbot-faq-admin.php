<?php
require_once plugin_dir_path(__FILE__) . 'chatbot-faq-settings-page.php';
require_once plugin_dir_path(__FILE__) . 'chatbot-faq-general-tab.php';
require_once plugin_dir_path(__FILE__) . 'chatbot-faq-design-tab.php';
require_once plugin_dir_path(__FILE__) . 'chatbot-faq-settings.php';

function chatbot_faq_add_admin_menu() {
    add_options_page(
        'Chatbot FAQ Settings',
        'Chatbot FAQ',
        'manage_options',
        'chatbot-faq-settings',
        'chatbot_faq_settings_page'
    );
}
add_action('admin_menu', 'chatbot_faq_add_admin_menu');
