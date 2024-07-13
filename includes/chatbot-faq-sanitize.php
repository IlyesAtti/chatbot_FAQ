<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function chatbot_faq_sanitize_callback_function($input) {
    if (!isset($_POST['chatbot_faq_nonce_field']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['chatbot_faq_nonce_field'])), 'chatbot_faq_nonce_action')) {
        return;
    }

    if (!function_exists('chatbot_faq_recursive_sanitize_text_field')) {
        function chatbot_faq_recursive_sanitize_text_field($value) {
            if (is_array($value)) {
                return array_map('chatbot_faq_recursive_sanitize_text_field', $value);
            } else {
                return wp_kses_post($value);
            }
        }
    }

    // Sanitize the input data
    $output = chatbot_faq_recursive_sanitize_text_field($input);

    // Handle file upload for custom icon
    if (isset($_FILES['chatbot_faq_custom_icon']) && $_FILES['chatbot_faq_custom_icon']['size'] > 0) {
        $uploaded = media_handle_upload('chatbot_faq_custom_icon', 0);
        if (!is_wp_error($uploaded)) {
            $output['custom_icon'] = wp_get_attachment_url($uploaded);
        } else {
            // Handle the error
            add_settings_error('chatbot_faq_design_data', 'upload_error', 'Failed to upload custom icon.');
        }
    } elseif (isset($input['custom_icon'])) {
        $output['custom_icon'] = sanitize_text_field($input['custom_icon']);
    }

    // Sanitize chat width
    if (isset($input['chat_width_desktop']) && is_numeric($input['chat_width_desktop'])) {
        // Limit to 10-95%
        $output['chat_width_desktop'] = min(max(intval($input['chat_width_desktop']), 10), 95); 
    }
    if (isset($input['chat_width_mobile']) && is_numeric($input['chat_width_mobile'])) {
        // Limit to 10-95%
        $output['chat_width_mobile'] = min(max(intval($input['chat_width_mobile']), 10), 95); 
    }

    // Sanitize sticky title
    $output['sticky_title'] = isset($input['sticky_title']) ? 1 : 0;

    return $output;
}
?>
