<?php
/*
Plugin Name: Chatbot FAQ
Plugin URI: https://example.com
Description: A simple plugin for frequently asked questions in a chat format with several customization options.
Version: 1.0.2
Author: Attila Ilyes
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: chatbot-faq
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
