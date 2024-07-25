<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

require_once plugin_dir_path(__FILE__) . 'chatbot-faq-callbacks.php';

function chatbot_faq_init() {
    register_setting(
        'chatbot_faq_settings',
        'chatbot_faq_data',
        'chatbot_faq_sanitize_data' // Update sanitize callback
    );

    register_setting(
        'chatbot_faq_design_settings',
        'chatbot_faq_design_data',
        'chatbot_faq_sanitize_data' // Update sanitize callback
    );

    add_settings_section(
        'chatbot_faq_section',
        'Chatbot FAQ Settings',
        'chatbot_faq_section_callback',
        'chatbot-faq-settings'
    );

    add_settings_section(
        'chatbot_faq_design_section',
        'Chatbot FAQ Design Settings',
        'chatbot_faq_design_section_callback',
        'chatbot-faq-design-settings'
    );

    // Add fields for the General tab
    add_settings_field(
        'chatbot_faq_title',
        'FAQ Title',
        'chatbot_faq_title_callback',
        'chatbot-faq-settings',
        'chatbot_faq_section'
    );

    add_settings_field(
        'chatbot_faq_questions',
        'Questions and Answers',
        'chatbot_faq_questions_callback',
        'chatbot-faq-settings',
        'chatbot_faq_section'
    );

    add_settings_field(
        'chatbot_faq_active',
        'Activate Chatbot',
        'chatbot_faq_active_callback',
        'chatbot-faq-settings',
        'chatbot_faq_section'
    );

    // Add fields for the Design tab
    add_settings_field(
        'chatbot_faq_title_bg_color',
        'Title Background Color',
        'chatbot_faq_title_bg_color_callback',
        'chatbot-faq-design-settings',
        'chatbot_faq_design_section'
    );

    add_settings_field(
        'chatbot_faq_title_text_color',
        'Title Text Color',
        'chatbot_faq_title_text_color_callback',
        'chatbot-faq-design-settings',
        'chatbot_faq_design_section'
    );

    add_settings_field(
        'chatbot_faq_question_bg_color',
        'Question Background Color',
        'chatbot_faq_question_bg_color_callback',
        'chatbot-faq-design-settings',
        'chatbot_faq_design_section'
    );

    add_settings_field(
        'chatbot_faq_question_text_color',
        'Question Text Color',
        'chatbot_faq_question_text_color_callback',
        'chatbot-faq-design-settings',
        'chatbot_faq_design_section'
    );

    add_settings_field(
        'chatbot_faq_answer_bg_color',
        'Answer Background Color',
        'chatbot_faq_answer_bg_color_callback',
        'chatbot-faq-design-settings',
        'chatbot_faq_design_section'
    );

    add_settings_field(
        'chatbot_faq_answer_text_color',
        'Answer Text Color',
        'chatbot_faq_answer_text_color_callback',
        'chatbot-faq-design-settings',
        'chatbot_faq_design_section'
    );

    add_settings_field(
        'chatbot_faq_icon',
        'Select Icon',
        'chatbot_faq_icon_callback',
        'chatbot-faq-design-settings',
        'chatbot_faq_design_section'
    );
}
add_action('admin_init', 'chatbot_faq_init');

function chatbot_faq_section_callback() {
    // Empty function to render the section
}

function chatbot_faq_design_section_callback() {
    // Empty function to render the section
}

function chatbot_faq_sanitize_data($input) {
    $output = array();
    foreach ($input as $key => $value) {
        if (is_array($value)) {
            $output[$key] = chatbot_faq_sanitize_data($value);
        } else {
            if ($key === 'questions') {
                // Allow HTML code in Questions and Answers for formatting purposes
                $output[$key] = array_map('wp_kses_post', $value);
            } else {
                $output[$key] = sanitize_text_field($value);
            }
        }
    }
    return $output;
}