<?php

function chatbot_faq_add_admin_menu() {
    add_options_page(
        'Chatbot FAQ Settings',
        'Chatbot FAQ',
        'manage_options',
        'chatbot-faq-settings',
        'chatbot_faq_settings_page'
    );
}

add_action('admin_menu', 'chatbot_faq_add_admin_menu');

function chatbot_faq_settings_page() {
    ?>
    <div class="wrap">
        <h1>Chatbot FAQ Settings</h1>

        <h2 class="nav-tab-wrapper">
            <a href="?page=chatbot-faq-settings" class="nav-tab">General</a>
            <a href="?page=chatbot-faq-settings&tab=design" class="nav-tab">Design</a>
        </h2>

        <?php
        if (isset($_GET['tab']) && $_GET['tab'] === 'design') {
            chatbot_faq_design_tab();
        } else {
            chatbot_faq_general_tab();
        }
        ?>
    </div>
    <?php
}

function chatbot_faq_general_tab() {
    $faq_data = get_option('chatbot_faq_data', array(
        'title' => 'Chatbot FAQ',
        'questions' => array(),
        'active' => false,
    ));
    ?>
    <form method="post" action="options.php">
        <?php
        settings_fields('chatbot_faq_settings');
        ?>
        <table class="form-table">
            <tr>
                <th scope="row">FAQ Title:</th>
                <td>
                    <input type="text" name="chatbot_faq_data[title]" value="<?php echo esc_attr($faq_data['title']); ?>" size="60">
                </td>
            </tr>
            <tr>
                <th scope="row">Questions and Answers:</th>
                <td>
                    <div id="chatbot_faq_questions_wrapper">
                        <?php
                        if (empty($faq_data['questions'])) {
                            $faq_data['questions'] = array(array('question' => '', 'answer' => ''));
                        }

                        foreach ($faq_data['questions'] as $index => $faq) {
                            $question = isset($faq['question']) ? $faq['question'] : '';
                            $answer = isset($faq['answer']) ? $faq['answer'] : '';
                            ?>
                            <div class="faq-item">
                                <p>
                                    <label for="chatbot_faq_question_<?php echo $index; ?>">Question:</label><br>
                                    <input type="text" id="chatbot_faq_question_<?php echo $index; ?>" name="chatbot_faq_data[questions][<?php echo $index; ?>][question]" value="<?php echo esc_attr($question); ?>" size="60">
                                </p>
                                <p>
                                    <label for="chatbot_faq_answer_<?php echo $index; ?>">Answer:</label><br>
                                    <textarea id="chatbot_faq_answer_<?php echo $index; ?>" name="chatbot_faq_data[questions][<?php echo $index; ?>][answer]" rows="5" cols="60"><?php echo esc_textarea($answer); ?></textarea>
                                </p>
                                <hr>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <button class="button" id="add_faq_item">Add New FAQ Item</button>
                </td>
            </tr>
            <tr>
                <th scope="row">Activate Chatbot:</th>
                <td>
                    <input type="checkbox" id="chatbot_faq_active" name="chatbot_faq_data[active]" value="1" <?php checked(1, $faq_data['active'], true); ?>>
                    <label for="chatbot_faq_active">Enable Chatbot</label>
                </td>
            </tr>
        </table>
        <?php submit_button('Save Settings'); ?>
    </form>
    <script>
        jQuery(document).ready(function($) {
            $('#add_faq_item').click(function(e) {
                e.preventDefault();
                var index = $('#chatbot_faq_questions_wrapper .faq-item').length;
                var newFaqItem = `
                    <div class="faq-item">
                        <p>
                            <label for="chatbot_faq_question_${index}">Question:</label><br>
                            <input type="text" id="chatbot_faq_question_${index}" name="chatbot_faq_data[questions][${index}][question]" value="" size="60">
                        </p>
                        <p>
                            <label for="chatbot_faq_answer_${index}">Answer:</label><br>
                            <textarea id="chatbot_faq_answer_${index}" name="chatbot_faq_data[questions][${index}][answer]" rows="5" cols="60"></textarea>
                        </p>
                        <hr>
                    </div>`;
                $('#chatbot_faq_questions_wrapper').append(newFaqItem);
            });
        });
    </script>
    <?php
}

function chatbot_faq_design_tab() {
    $faq_design_data = get_option('chatbot_faq_design_data', array(
        'question_bg_color' => '#ffffff',
        'question_text_color' => '#000000',
        'answer_bg_color' => '#f0f0f0',
        'answer_text_color' => '#000000',
        'icon' => ''
    ));
    ?>
    <form method="post" action="options.php">
        <?php
        settings_fields('chatbot_faq_design_settings');
        ?>
        <table class="form-table">
            <tr>
                <th scope="row">Question Background Color:</th>
                <td><input type="text" name="chatbot_faq_design_data[question_bg_color]" value="<?php echo esc_attr($faq_design_data['question_bg_color']); ?>" class="color-field"></td>
            </tr>
            <tr>
                <th scope="row">Question Text Color:</th>
                <td><input type="text" name="chatbot_faq_design_data[question_text_color]" value="<?php echo esc_attr($faq_design_data['question_text_color']); ?>" class="color-field"></td>
            </tr>
            <tr>
                <th scope="row">Answer Background Color:</th>
                <td><input type="text" name="chatbot_faq_design_data[answer_bg_color]" value="<?php echo esc_attr($faq_design_data['answer_bg_color']); ?>" class="color-field"></td>
            </tr>
            <tr>
                <th scope="row">Answer Text Color:</th>
                <td><input type="text" name="chatbot_faq_design_data[answer_text_color]" value="<?php echo esc_attr($faq_design_data['answer_text_color']); ?>" class="color-field"></td>
            </tr>
            <tr>
                <th scope="row">Select Icon:</th>
                <td>
                    <?php
                    $icons_dir = plugin_dir_url(__FILE__) . '../public/icons/';
                    $icons = array('black-left.png', 'black-right.png', 'white-left.png', 'white-right.png');
                    foreach ($icons as $icon) {
                        $checked = (isset($faq_design_data['icon']) && $faq_design_data['icon'] === $icon) ? 'checked' : '';
                        echo '<label>';
                        echo '<input type="radio" name="chatbot_faq_design_data[icon]" value="' . esc_attr($icon) . '" ' . $checked . '>';
                        echo '<img src="' . esc_url($icons_dir . $icon) . '" alt="' . esc_attr($icon) . '" style="margin: 5px; width: 24px; height: 24px;">';
                        echo '</label>';
                    }
                    ?>
                </td>
            </tr>
        </table>
        <?php submit_button('Save Settings'); ?>
    </form>
    <?php
}

function chatbot_faq_init() {
    register_setting(
        'chatbot_faq_settings',
        'chatbot_faq_data',
        'sanitize_callback_function'
    );

    register_setting(
        'chatbot_faq_design_settings',
        'chatbot_faq_design_data',
        'sanitize_callback_function'
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

function chatbot_faq_title_callback() {
    $faq_data = get_option('chatbot_faq_data', array('title' => 'Chatbot FAQ'));
    $title = isset($faq_data['title']) ? $faq_data['title'] : 'Chatbot FAQ';
    ?>
    <input type="text" id="chatbot_faq_title" name="chatbot_faq_data[title]" value="<?php echo esc_attr($title); ?>" size="60">
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
            $question = isset($faq['question']) ? $faq['question'] : '';
            $answer = isset($faq['answer']) ? $faq['answer'] : '';
            ?>
            <div class="faq-item">
                <p>
                    <label for="chatbot_faq_question_<?php echo $index; ?>">Question:</label><br>
                    <textarea id="chatbot_faq_question_<?php echo $index; ?>" name="chatbot_faq_data[questions][<?php echo $index; ?>][question]" rows="2" cols="60"><?php echo esc_textarea($question); ?></textarea>
                </p>
                <p>
                    <label for="chatbot_faq_answer_<?php echo $index; ?>">Answer:</label><br>
                    <textarea id="chatbot_faq_answer_<?php echo $index; ?>" name="chatbot_faq_data[questions][<?php echo $index; ?>][answer]" rows="5" cols="60"><?php echo esc_textarea($answer); ?></textarea>
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
    <input type="checkbox" id="chatbot_faq_active" name="chatbot_faq_data[active]" value="1" <?php checked(1, $active, true); ?>>
    <label for="chatbot_faq_active">Enable Chatbot</label>
    <?php
}

function chatbot_faq_question_bg_color_callback() {
    $faq_design_data = get_option('chatbot_faq_design_data', array('question_bg_color' => '#ffffff'));
    $question_bg_color = isset($faq_design_data['question_bg_color']) ? $faq_design_data['question_bg_color'] : '#ffffff';
    ?>
    <input type="text" name="chatbot_faq_design_data[question_bg_color]" value="<?php echo esc_attr($question_bg_color); ?>" class="color-field">
    <?php
}

function chatbot_faq_question_text_color_callback() {
    $faq_design_data = get_option('chatbot_faq_design_data', array('question_text_color' => '#000000'));
    $question_text_color = isset($faq_design_data['question_text_color']) ? $faq_design_data['question_text_color'] : '#000000';
    ?>
    <input type="text" name="chatbot_faq_design_data[question_text_color]" value="<?php echo esc_attr($question_text_color); ?>" class="color-field">
    <?php
}

function chatbot_faq_answer_bg_color_callback() {
    $faq_design_data = get_option('chatbot_faq_design_data', array('answer_bg_color' => '#f0f0f0'));
    $answer_bg_color = isset($faq_design_data['answer_bg_color']) ? $faq_design_data['answer_bg_color'] : '#f0f0f0';
    ?>
    <input type="text" name="chatbot_faq_design_data[answer_bg_color]" value="<?php echo esc_attr($answer_bg_color); ?>" class="color-field">
    <?php
}

function chatbot_faq_answer_text_color_callback() {
    $faq_design_data = get_option('chatbot_faq_design_data', array('answer_text_color' => '#000000'));
    $answer_text_color = isset($faq_design_data['answer_text_color']) ? $faq_design_data['answer_text_color'] : '#000000';
    ?>
    <input type="text" name="chatbot_faq_design_data[answer_text_color]" value="<?php echo esc_attr($answer_text_color); ?>" class="color-field">
    <?php
}

function chatbot_faq_icon_callback() {
    $faq_design_data = get_option('chatbot_faq_design_data', array('icon' => ''));
    $icons_dir = plugin_dir_url(__FILE__) . '../public/icons/';

    $icons = array('black-left.png', 'black-right.png', 'white-left.png', 'white-right.png');

    foreach ($icons as $icon) {
        $checked = (isset($faq_design_data['icon']) && $faq_design_data['icon'] === $icon) ? 'checked' : '';
        echo '<label>';
        echo '<input type="radio" name="chatbot_faq_design_data[icon]" value="' . esc_attr($icon) . '" ' . $checked . '>';
        echo '<img src="' . esc_url($icons_dir . $icon) . '" alt="' . esc_attr($icon) . '" style="margin: 5px; width: 24px; height: 24px;">';
        echo '</label>';
    }
}

function sanitize_callback_function($input) {
    if (!function_exists('recursive_sanitize_text_field')) {
        function recursive_sanitize_text_field($value) {
            if (is_array($value)) {
                return array_map('recursive_sanitize_text_field', $value);
            } else {
                return wp_kses_post($value); // Permite HTML de bază
            }
        }
    }    

    // Sanitize the input data
    $output = recursive_sanitize_text_field($input);
    return $output;
}
?>