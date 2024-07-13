<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function chatbot_faq_title_callback() {
    $faq_data = get_option('chatbot_faq_data', array('title' => 'Chatbot FAQ'));
    $title = isset($faq_data['title']) ? $faq_data['title'] : 'Chatbot FAQ';
    ?>
    <input type="text" id="chatbot_faq_title" name="chatbot_faq_data[title]" 
        value="<?php echo esc_attr($title); ?>" size="60">
    <?php
}

function chatbot_faq_questions_callback() {
    $faq_data = get_option('chatbot_faq_data', array('questions' => array()));
    $questions = isset($faq_data['questions']) ? $faq_data['questions'] : array();

    if (!is_array($questions)) {
        $questions = array();
    }
    ?>
    <div id="chatbot_faq_questions_wrapper">
        <?php
        if (empty($questions)) {
            $questions = array(
                array('question' => '', 'answer' => ''),
            );
        }

        foreach ($questions as $index => $faq) {
            $question = isset($faq['question']) ? preg_replace('/^\s+|\s+$/m', '', 
                trim($faq['question'])) : '';
            $answer = isset($faq['answer']) ? preg_replace('/^\s+|\s+$/m', '', 
                trim($faq['answer'])) : '';
            ?>
            <div class="faq-item">
                <p>
                    <label for="chatbot_faq_question_<?php echo esc_attr($index); ?>">
                        Question:
                    </label><br>
                    <textarea id="chatbot_faq_question_<?php echo esc_attr($index); ?>" 
                        name="chatbot_faq_data[questions][<?php echo esc_attr($index); ?>
                        ][question]" rows="2" cols="60"><?php echo esc_textarea($question); ?>
                    </textarea>
                </p>
                <p>
                    <label for="chatbot_faq_answer_<?php echo esc_attr($index); ?>">
                        Answer:
                    </label><br>
                    <textarea id="chatbot_faq_answer_<?php echo esc_attr($index); ?>"
                        name="chatbot_faq_data[questions][<?php echo esc_attr($index); ?>
                        ][answer]" rows="5" cols="60"><?php echo esc_textarea($answer); ?>
                    </textarea>
                </p>
                <hr>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}

function chatbot_faq_active_callback() {
    $faq_data = get_option('chatbot_faq_data', array('active' => false));
    $active = isset($faq_data['active']) ? $faq_data['active'] : false;
    ?>
    <input type="checkbox" id="chatbot_faq_active" name="chatbot_faq_data[active]"
         value="1" <?php checked(1, $active, true); ?>>
    <label for="chatbot_faq_active">
        Enable Chatbot
    </label>
    <?php
}

function chatbot_faq_question_bg_color_callback() {
    $faq_design_data = get_option('chatbot_faq_design_data', 
        array('question_bg_color' => '#ffffff'));
    $question_bg_color = isset($faq_design_data['question_bg_color']) ?
         $faq_design_data['question_bg_color'] : '#ffffff';
    ?>
    <input type="text" name="chatbot_faq_design_data[question_bg_color]" 
        value="<?php echo esc_attr($question_bg_color); ?>" class="color-field">
    <?php
}

function chatbot_faq_question_text_color_callback() {
    $faq_design_data = get_option('chatbot_faq_design_data', 
        array('question_text_color' => '#000000'));
    $question_text_color = isset($faq_design_data['question_text_color']) ? 
        $faq_design_data['question_text_color'] : '#000000';
    ?>
    <input type="text" name="chatbot_faq_design_data[question_text_color]" 
        value="<?php echo esc_attr($question_text_color); ?>" class="color-field">
    <?php
}

function chatbot_faq_answer_bg_color_callback() {
    $faq_design_data = get_option('chatbot_faq_design_data', 
        array('answer_bg_color' => '#f0f0f0'));
    $answer_bg_color = isset($faq_design_data['answer_bg_color']) ? 
        $faq_design_data['answer_bg_color'] : '#f0f0f0';
    ?>
    <input type="text" name="chatbot_faq_design_data[answer_bg_color]" 
        value="<?php echo esc_attr($answer_bg_color); ?>" class="color-field">
    <?php
}

function chatbot_faq_answer_text_color_callback() {
    $faq_design_data = get_option('chatbot_faq_design_data', 
        array('answer_text_color' => '#000000'));
    $answer_text_color = isset($faq_design_data['answer_text_color']) ? 
        $faq_design_data['answer_text_color'] : '#000000';
    ?>
    <input type="text" name="chatbot_faq_design_data[answer_text_color]" 
        value="<?php echo esc_attr($answer_text_color); ?>" class="color-field">
    <?php
}

function chatbot_faq_title_bg_color_callback() {
    $faq_design_data = get_option('chatbot_faq_design_data', 
        array('title_bg_color' => '#ffffff'));
    $title_bg_color = isset($faq_design_data['title_bg_color']) ? 
        $faq_design_data['title_bg_color'] : '#ffffff';
    ?>
    <input type="text" name="chatbot_faq_design_data[title_bg_color]" 
        value="<?php echo esc_attr($title_bg_color); ?>" class="color-field">
    <?php
}

function chatbot_faq_title_text_color_callback() {
    $faq_design_data = get_option('chatbot_faq_design_data', 
        array('title_text_color' => '#000000'));
    $title_text_color = isset($faq_design_data['title_text_color']) ? 
        $faq_design_data['title_text_color'] : '#000000';
    ?>
    <input type="text" name="chatbot_faq_design_data[title_text_color]" 
        value="<?php echo esc_attr($title_text_color); ?>" class="color-field">
    <?php
}

function chatbot_faq_icon_callback() {
    $faq_design_data = get_option('chatbot_faq_design_data', 
        array('icon' => '', 'custom_icon' => ''));
    $icons_dir = plugin_dir_url(__FILE__) . '../public/icons/';

    $icons = array('black-left.png', 'black-right.png', 'white-left.png', 'white-right.png');

    foreach ($icons as $icon) {
        $checked = (isset($faq_design_data['icon']) && 
            $faq_design_data['icon'] === $icon) ? 'checked' : '';
        echo '<label>';
        echo '<input type="radio" name="chatbot_faq_design_data[icon]" value="' . esc_attr($icon) . '" ' . esc_attr($checked) . '>';
        echo '<img src="' . esc_url($icons_dir . $icon) . '" 
            alt="' . esc_attr($icon) . '" style="margin: 5px; width: 24px; height: 24px;">';
        echo '</label>';
    }

    echo '<br><br>';
    echo '<label for="chatbot_faq_custom_icon">Or upload custom icon:</label>';
    echo '<input type="file" name="chatbot_faq_custom_icon" id="chatbot_faq_custom_icon">';
    if (!empty($faq_design_data['custom_icon'])) {
        echo '<img src="' . esc_url($faq_design_data['custom_icon']) . '" 
            alt="Custom Icon" style="margin-top: 10px; width: 50px; height: 50px;">';
    }
}
