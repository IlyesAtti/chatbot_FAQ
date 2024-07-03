<?php

function load_chatbot_public_assets() {
    wp_enqueue_style('chatbot-style', plugins_url('chatbot-style.css', __FILE__));
    wp_enqueue_script('chatbot-script', plugins_url('chatbot-script.js', __FILE__), array('jquery'), null, true);

    $faq_design_data = get_option('chatbot_faq_design_data', array(
        'question_bg_color' => '#ffffff',
        'question_text_color' => '#000000',
        'answer_bg_color' => '#f0f0f0',
        'answer_text_color' => '#000000',
        'chat_width_desktop' => '300',
        'chat_width_mobile' => '100'
    ));

    $chat_width_desktop = isset($faq_design_data['chat_width_desktop']) ? $faq_design_data['chat_width_desktop'] : '300';
    $chat_width_mobile = isset($faq_design_data['chat_width_mobile']) ? $faq_design_data['chat_width_mobile'] : '100';

    $custom_css = "
    .chatbot-question {
        background-color: {$faq_design_data['question_bg_color']};
        color: {$faq_design_data['question_text_color']};
    }
    .chatbot-answer {
        background-color: {$faq_design_data['answer_bg_color']};
        color: {$faq_design_data['answer_text_color']};
    }
    @media (min-width: 768px) {
        #chatbot-faq {
            width: {$chat_width_desktop}%;
        }
    }
    @media (max-width: 767px) {
        #chatbot-faq {
            width: {$chat_width_mobile}%;
        }
    }
    .sticky-wrapper {
        position: relative;
    }
    .sticky-title {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 10;
        padding: 10px 0;
    }";
    wp_add_inline_style('chatbot-style', $custom_css);
}

add_action('wp_enqueue_scripts', 'load_chatbot_public_assets');

function display_chatbot_icon() {
    $faq_data = get_option('chatbot_faq_data', array(
        'active' => false,
        'questions' => array(),
        'sticky_title' => false,
    ));
    $faq_design_data = get_option('chatbot_faq_design_data', array(
        'icon' => '',
        'custom_icon' => ''
    ));

    if (!$faq_data['active']) {
        return;
    }

    $icon_url = !empty($faq_design_data['custom_icon']) ? $faq_design_data['custom_icon'] : plugin_dir_url(__FILE__) . 'icons/' . $faq_design_data['icon'];
    ?>
    <div id="chatbot-icon-wrapper">
        <img src="<?php echo esc_url($icon_url); ?>" id="chatbot-icon" alt="Chatbot Icon">
        <div id="chatbot-faq">
            <div class="sticky-wrapper <?php if ($faq_data['sticky_title']) echo 'sticky-title'; ?>">
                <button id="close-chatbot">X</button>
                <h2><?php echo esc_html($faq_data['title']); ?></h2>
            </div>
            <?php echo do_shortcode('[chatbot_faq]'); ?>
        </div>
    </div>
    <?php
}

add_action('wp_footer', 'display_chatbot_icon');

function render_chatbot_faq() {
    $faq_data = get_option('chatbot_faq_data', array('questions' => array()));
    $questions = isset($faq_data['questions']) ? $faq_data['questions'] : array();

    ob_start();
    ?>
    <ul class="chatbot-faq-list clearfix">
        <?php foreach ($questions as $index => $faq) : ?>
            <li class="chatbot-question">
                <span class="chatbot-text"><?php echo nl2br(esc_html(preg_replace('/^\s+|\s+$/m', '', trim($faq['question'])))); ?></span>
            </li>
            <li class="chatbot-answer">
                <span class="chatbot-text"><?php echo wp_kses_post(preg_replace('/^\s+|\s+$/m', '', trim($faq['answer']))); ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
    return ob_get_clean();
}
add_shortcode('chatbot_faq', 'render_chatbot_faq');

add_action('wp_enqueue_scripts', 'load_chatbot_public_assets');

function load_chatbot_script() {
    wp_enqueue_script('chatbot-script', plugins_url('chatbot-script.js', __FILE__), array('jquery'), null, true);
    wp_enqueue_style('chatbot-style', plugins_url('chatbot-style.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'load_chatbot_script');
?>
