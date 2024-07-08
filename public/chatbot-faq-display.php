<?php

function load_chatbot_public_assets() {
    wp_enqueue_style('chatbot-style', plugins_url('chatbot-style.css', __FILE__));
    wp_enqueue_script('chatbot-script', plugins_url('chatbot-script.js', __FILE__),
         array('jquery'), null, true);

    $faq_design_data = get_option('chatbot_faq_design_data', array(
        'question_bg_color' => '#ffffff',
        'question_text_color' => '#000000',
        'answer_bg_color' => '#f0f0f0',
        'answer_text_color' => '#000000',
        'title_bg_color' => '#ffffff',
        'title_text_color' => '#000000',
        'chat_width_desktop' => '300',
        'chat_width_mobile' => '100'
    ));

    $chat_width_desktop = isset($faq_design_data['chat_width_desktop']) ? 
        $faq_design_data['chat_width_desktop'] : '300';
    $chat_width_mobile = isset($faq_design_data['chat_width_mobile']) ?
        $faq_design_data['chat_width_mobile'] : '100';
    $sticky_title = isset($faq_data['sticky_title']) ? 
        $faq_data['sticky_title'] : false;
    $title_bg_color = isset($faq_design_data['title_bg_color']) ? 
        $faq_design_data['title_bg_color'] : '#ffffff';
    $title_text_color = isset($faq_design_data['title_text_color']) ? 
        $faq_design_data['title_text_color'] : '#000000';

    $custom_css = "
    .chatbot-question {
        background-color: {$faq_design_data['question_bg_color']};
        color: {$faq_design_data['question_text_color']};
    }
    .chatbot-answer {
        background-color: {$faq_design_data['answer_bg_color']};
        color: {$faq_design_data['answer_text_color']};
    }
    .sticky-wrapper {
        background-color: {$faq_design_data['title_bg_color']};
        color: {$faq_design_data['title_text_color']};
        position: -webkit-sticky; /* Safari */
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    #chatbot-faq h2 {
        background-color: {$title_bg_color};
        color: {$title_text_color};
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
    }";
    wp_add_inline_style('chatbot-style', $custom_css);

    // Add sticky title variable
    wp_add_inline_script('chatbot-script', 'var chatbot_faq_sticky_title = ' 
        . json_encode($sticky_title) . ';', 'before');
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

    $icon_url = !empty($faq_design_data['custom_icon']) ? 
        $faq_design_data['custom_icon'] : plugin_dir_url(__FILE__) . 'icons/' . $faq_design_data['icon'];
    ?>
    <div id="chatbot-icon-wrapper">
        <img src="<?php echo esc_url($icon_url); ?>" id="chatbot-icon" alt="Chatbot Icon">
        <div id="chatbot-faq">
            <div class="<?php echo ($faq_data['sticky_title']) ? 'sticky-wrapper' : ''; ?>">
                <h2><?php echo esc_html($faq_data['title']); ?></h2>
                <button id="close-chatbot" class="<?php echo 
                    ($faq_data['sticky_title']) ? 'sticky' : ''; ?>" style="display: none;">
                    X
                </button>
            </div>
            <?php echo do_shortcode('[chatbot_faq]'); ?>
        </div>
    </div>
    <?php
}

add_action('wp_footer', 'display_chatbot_icon');

function render_chatbot_faq() {
    $faq_data = get_option('chatbot_faq_data',
        array('title' => 'Chatbot FAQ', 'questions' => array()));
    $title = isset($faq_data['title']) ? $faq_data['title'] : 'Chatbot FAQ';
    $questions = isset($faq_data['questions']) ? $faq_data['questions'] : array();

    ob_start();
    ?>

    <ul class="chatbot-faq-list clearfix">
        <?php foreach ($questions as $index => $faq) : ?>
            <li class="chatbot-question">
                <span class="chatbot-text">
                    <?php echo nl2br(esc_html(preg_replace('/^\s+|\s+$/m', '', 
                        trim($faq['question'])))); 
                    ?>
                </span>
            </li>
            <li class="chatbot-answer">
                <span class="chatbot-text">
                    <?php echo wp_kses_post(preg_replace('/^\s+|\s+$/m', '', trim($faq['answer']))); ?>
                </span>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php
    return ob_get_clean();
}
add_shortcode('chatbot_faq', 'render_chatbot_faq');

?>
