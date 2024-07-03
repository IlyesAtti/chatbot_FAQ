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
        'sticky_title' => false,
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
                    <br>
                    <input type="checkbox" id="chatbot_faq_sticky_title" name="chatbot_faq_data[sticky_title]" value="1" <?php checked(1, $faq_data['sticky_title'], true); ?>>
                    <label for="chatbot_faq_sticky_title">Sticky Title and Close Button</label>
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
                            $question = isset($faq['question']) ? preg_replace('/^\s+|\s+$/m', '', trim($faq['question'])) : '';
                            $answer = isset($faq['answer']) ? preg_replace('/^\s+|\s+$/m', '', trim($faq['answer'])) : '';
                            ?>
                            <div class="faq-item" data-index="<?php echo $index; ?>">
                                <p>
                                    <label for="chatbot_faq_question_<?php echo $index; ?>">Question:</label><br>
                                    <textarea id="chatbot_faq_question_<?php echo $index; ?>" name="chatbot_faq_data[questions][<?php echo $index; ?>][question]" rows="2" cols="60"><?php echo esc_textarea($question); ?></textarea>
                                </p>
                                <p>
                                    <label for="chatbot_faq_answer_<?php echo $index; ?>">Answer:</label><br>
                                    <textarea id="chatbot_faq_answer_<?php echo $index; ?>" name="chatbot_faq_data[questions][<?php echo $index; ?>][answer]" rows="5" cols="60"><?php echo esc_textarea($answer); ?></textarea>
                                </p>
                                <button class="button remove_faq_item">Remove FAQ Item</button>
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
                    <div class="faq-item" data-index="${index}">
                        <p>
                            <label for="chatbot_faq_question_${index}">Question:</label><br>
                            <textarea id="chatbot_faq_question_${index}" name="chatbot_faq_data[questions][${index}][question]" rows="2" cols="60"></textarea>
                        </p>
                        <p>
                            <label for="chatbot_faq_answer_${index}">Answer:</label><br>
                            <textarea id="chatbot_faq_answer_${index}" name="chatbot_faq_data[questions][${index}][answer]" rows="5" cols="60"></textarea>
                        </p>
                        <button class="button remove_faq_item">Remove FAQ Item</button>
                        <hr>
                    </div>`;
                $('#chatbot_faq_questions_wrapper').append(newFaqItem);
            });

            $('#chatbot_faq_questions_wrapper').on('click', '.remove_faq_item', function(e) {
                e.preventDefault();
                $(this).closest('.faq-item').remove();
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
        'icon' => '',
        'custom_icon' => '',
        'chat_width_desktop' => '50',
        'chat_width_mobile' => '100'
    ));

    $chat_width_desktop = isset($faq_design_data['chat_width_desktop']) ? $faq_design_data['chat_width_desktop'] : '50';
    $chat_width_mobile = isset($faq_design_data['chat_width_mobile']) ? $faq_design_data['chat_width_mobile'] : '100';
    ?>
    <form method="post" action="options.php" enctype="multipart/form-data">
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
                    <br><br>
                    <label for="chatbot_faq_custom_icon">Or upload custom icon:</label>
                    <input type="file" name="chatbot_faq_custom_icon" id="chatbot_faq_custom_icon">
                    <?php if (!empty($faq_design_data['custom_icon'])) : ?>
                        <img src="<?php echo esc_url($faq_design_data['custom_icon']); ?>" alt="Custom Icon" style="margin-top: 10px; width: 50px; height: 50px;">
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Chat Width Desktop (%):</th>
                <td>
                    <input type="range" id="chat_width_slider_desktop" name="chatbot_faq_design_data[chat_width_desktop]" value="<?php echo esc_attr($chat_width_desktop); ?>" min="10" max="100" oninput="document.getElementById('chat_width_text_desktop').value = this.value">
                    <input type="number" id="chat_width_text_desktop" name="chatbot_faq_design_data[chat_width_desktop]" value="<?php echo esc_attr($chat_width_desktop); ?>" min="10" max="100" oninput="document.getElementById('chat_width_slider_desktop').value = this.value"> %
                </td>
            </tr>
            <tr>
                <th scope="row">Chat Width Mobile (%):</th>
                <td>
                    <input type="range" id="chat_width_slider_mobile" name="chatbot_faq_design_data[chat_width_mobile]" value="<?php echo esc_attr($chat_width_mobile); ?>" min="10" max="100" oninput="document.getElementById('chat_width_text_mobile').value = this.value">
                    <input type="number" id="chat_width_text_mobile" name="chatbot_faq_design_data[chat_width_mobile]" value="<?php echo esc_attr($chat_width_mobile); ?>" min="10" max="100" oninput="document.getElementById('chat_width_slider_mobile').value = this.value"> %
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
            $question = isset($faq['question']) ? preg_replace('/^\s+|\s+$/m', '', trim($faq['question'])) : '';
            $answer = isset($faq['answer']) ? preg_replace('/^\s+|\s+$/m', '', trim($faq['answer'])) : '';
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
    $faq_design_data = get_option('chatbot_faq_design_data', array('icon' => '', 'custom_icon' => ''));
    $icons_dir = plugin_dir_url(__FILE__) . '../public/icons/';

    $icons = array('black-left.png', 'black-right.png', 'white-left.png', 'white-right.png');

    foreach ($icons as $icon) {
        $checked = (isset($faq_design_data['icon']) && $faq_design_data['icon'] === $icon) ? 'checked' : '';
        echo '<label>';
        echo '<input type="radio" name="chatbot_faq_design_data[icon]" value="' . esc_attr($icon) . '" ' . $checked . '>';
        echo '<img src="' . esc_url($icons_dir . $icon) . '" alt="' . esc_attr($icon) . '" style="margin: 5px; width: 24px; height: 24px;">';
        echo '</label>';
    }

    echo '<br><br>';
    echo '<label for="chatbot_faq_custom_icon">Or upload custom icon:</label>';
    echo '<input type="file" name="chatbot_faq_custom_icon" id="chatbot_faq_custom_icon">';
    if (!empty($faq_design_data['custom_icon'])) {
        echo '<img src="' . esc_url($faq_design_data['custom_icon']) . '" alt="Custom Icon" style="margin-top: 10px; width: 50px; height: 50px;">';
    }
}

function sanitize_callback_function($input) {
    if (!function_exists('recursive_sanitize_text_field')) {
        function recursive_sanitize_text_field($value) {
            if (is_array($value)) {
                return array_map('recursive_sanitize_text_field', $value);
            } else {
                return wp_kses_post($value);
            }
        }
    }

    // Sanitize the input data
    $output = recursive_sanitize_text_field($input);

    // Handle file upload
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
        $output['chat_width_desktop'] = min(max(intval($input['chat_width_desktop']), 10), 100); // Limit to 10-100%
    }
    if (isset($input['chat_width_mobile']) && is_numeric($input['chat_width_mobile'])) {
        $output['chat_width_mobile'] = min(max(intval($input['chat_width_mobile']), 10), 100); // Limit to 10-100%
    }

    // Sanitize sticky title
    $output['sticky_title'] = isset($input['sticky_title']) ? 1 : 0;

    return $output;
}
add_action('admin_init', 'chatbot_faq_init');
