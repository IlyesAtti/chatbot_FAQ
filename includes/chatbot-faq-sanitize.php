<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function custom_wp_kses_allowed_html() {
    return array(
        'a' => array(
            'href' => true,
            'title' => true,
            'class' => true,
        ),
        'br' => array(),
        'p' => array(),
    );
}
add_filter('wp_kses_allowed_html', 'custom_wp_kses_allowed_html');

function chatbot_faq_sanitize_callback_function($input) {
    // Verify nonce and sanitize input
    if ( ! isset($_POST['chatbot_faq_nonce_field']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['chatbot_faq_nonce_field'])), 'chatbot_faq_nonce_action') ) {
        return; // Nonce invalid
    }

    // Sanitize texts
    if ( ! function_exists('chatbot_faq_recursive_sanitize_text_field') ) {
        function chatbot_faq_recursive_sanitize_text_field($value) {
            if (is_array($value)) {
                return array_map('chatbot_faq_recursive_sanitize_text_field', $value);
            } else {
                return wp_kses($value, array(
                    'a' => array(
                        'href' => true,
                        'title' => true,
                        'class' => true,
                    ),
                    'br' => array(),
                    'p' => array(),
                    'strong' => array(),
                    'em' => array(),
                    'u' => array(),
                    
                ));
            }
        }
    }

    $output = chatbot_faq_recursive_sanitize_text_field($input);

    // Handle file upload for custom icon
    if ( isset($_FILES['chatbot_faq_custom_icon']) && $_FILES['chatbot_faq_custom_icon']['size'] > 0 ) {
        $allowed_file_types = array('image/jpeg', 'image/png', 'image/gif');
        $file_type = wp_check_filetype($_FILES['chatbot_faq_custom_icon']['name']);
        
        if (in_array($file_type['type'], $allowed_file_types)) {
            $uploaded = media_handle_upload('chatbot_faq_custom_icon', 0);
            if ( ! is_wp_error($uploaded) ) {
                $output['custom_icon'] = wp_get_attachment_url($uploaded);
            } else {
                add_settings_error('chatbot_faq_design_data', 'upload_error', 'Eșec la încărcarea pictogramei personalizate.');
            }
        } else {
            add_settings_error('chatbot_faq_design_data', 'upload_error', 'Tip de fișier nevalid pentru pictograma personalizată.');
        }
    } elseif ( isset($input['custom_icon']) ) {
        $output['custom_icon'] = sanitize_text_field($input['custom_icon']); // Sanitize icon URL
    }

    // Sanitize chat width
    if ( isset($input['chat_width_desktop']) && is_numeric($input['chat_width_desktop']) ) {
        $output['chat_width_desktop'] = min(max(intval($input['chat_width_desktop']), 10), 95); // Limit to 10-95%
    }
    if ( isset($input['chat_width_mobile']) && is_numeric($input['chat_width_mobile']) ) {
        $output['chat_width_mobile'] = min(max(intval($input['chat_width_mobile']), 10), 95); // Limit to 10-95%
    }
    
    // Sanitize sticky title
    $output['sticky_title'] = isset($input['sticky_title']) ? 1 : 0;

    return $output;
}
?>
