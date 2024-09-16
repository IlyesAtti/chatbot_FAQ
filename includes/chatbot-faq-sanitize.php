<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function verify_chatbot_faq_nonce() {
    if ( ! isset( $_POST['chatbot_faq_nonce_field'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['chatbot_faq_nonce_field'])), 'chatbot_faq_nonce_action' )) {
        wp_die( 'Nonce verification failed!' );
    }
}

function chatbot_faq_sanitize_callback_function($input) {
    verify_chatbot_faq_nonce();

    if (!function_exists('recursive_sanitize_text_field')) {
        function recursive_sanitize_text_field($value) {
            if (is_array($value)) {
                return array_map('recursive_sanitize_text_field', $value);
            } else {
                return sanitize_text_field($value);
            }
        }
    }

    $output = recursive_sanitize_text_field($input);

    if (isset($_POST['chatbot_faq_nonce_field']) && wp_verify_nonce( sanitize_text_field( wp_unslash ($_POST['chatbot_faq_nonce_field'])), 'chatbot_faq_nonce_action')) {
        if (isset($_FILES['chatbot_faq_custom_icon']) && isset($_FILES['chatbot_faq_custom_icon']['size']) && $_FILES['chatbot_faq_custom_icon']['size'] > 0) {
            $uploaded = media_handle_upload('chatbot_faq_custom_icon', 0);
            if (!is_wp_error($uploaded)) {
                $output['custom_icon'] = wp_get_attachment_url($uploaded);
            } else {
                $error_message = sprintf(
                    // translators: %s: Error message received during custom icon upload.
                    esc_html__('Failed to upload custom icon. Error: %s', 'chatbot_FAQ'),
                    esc_html($uploaded->get_error_message())
                );
                add_settings_error(
                    'chatbot_faq_design_data',
                    'upload_error',
                    $error_message
                );
            }
        } elseif (isset($input['custom_icon'])) {
            $output['custom_icon'] = sanitize_text_field($input['custom_icon']);
        }
    } else {
        wp_die('Security verification: verification failed.');
    }

    if (isset($input['chat_width_desktop']) && is_numeric($input['chat_width_desktop'])) {
        $output['chat_width_desktop'] = min(max(intval($input['chat_width_desktop']), 10), 95);
    }
    if (isset($input['chat_width_mobile']) && is_numeric($input['chat_width_mobile'])) {
        $output['chat_width_mobile'] = min(max(intval($input['chat_width_mobile']), 10), 95);
    }

    $output['sticky_title'] = isset($input['sticky_title']) ? 1 : 0;

    return $output;
}
?>
