<?php
/*
Plugin Name: Chatbot FAQ
Description: A simple plugin for frequently asked questions in a chat format with several customization options.
Version: 1.0.4
Author: Attila Ilyes
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: chatbot-faq
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include admin settings
if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'admin/chatbot-faq-admin.php';
    require_once plugin_dir_path(__FILE__) . 'admin/chatbot-faq-design-tab.php';
    require_once plugin_dir_path(__FILE__) . 'admin/chatbot-faq-general-tab.php';
    require_once plugin_dir_path(__FILE__) . 'admin/chatbot-faq-settings-page.php';
    require_once plugin_dir_path(__FILE__) . 'includes/chatbot-faq-sanitize.php';
}

// Include public functions
require_once plugin_dir_path(__FILE__) . 'public/chatbot-faq-public.php';
?>