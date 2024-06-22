<?php
/**
 * Plugin Name: Chatbot-FAQ
 * Version: 1.0.1
 * Description: A simple chat plugin with predefined questions and answers!
 * Author: Attila Ilyes
 */


function chatbot_faq_activate() {
    // Activation 
}
register_activation_hook(__FILE__, 'chatbot_faq_activate');

function chatbot_faq_deactivate() {
    // Deactivation 
}
register_deactivation_hook(__FILE__, 'chatbot_faq_deactivate');

if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'admin/chatbot-faq-admin.php';
} else {
    require_once plugin_dir_path(__FILE__) . 'public/chatbot-faq-public.php';
}
?>
