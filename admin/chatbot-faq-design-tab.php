<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function get_chatbot_faq_design_data() {
    $data = get_option('chatbot_faq_design_data');
    if (!is_array($data)) {
        $data = array(
            'question_bg_color' => '#ffffff',
            'question_text_color' => '#000000',
            'answer_bg_color' => '#f0f0f0',
            'answer_text_color' => '#000000',
            'title_bg_color' => '#ffffff',
            'title_text_color' => '#000000',
            'chat_width_desktop' => '25',
            'chat_width_mobile' => '80',
            'icon' => 'black-right.png',  // Default value
            'custom_icon' => '',
        );
    }
    return $data;
}

function chatbot_faq_design_tab() {
    $faq_design_data = get_chatbot_faq_design_data();

    // Verifică dacă cheia 'icon' există, dacă nu, folosește o valoare implicită
    $selected_icon = isset($faq_design_data['icon']) ? $faq_design_data['icon'] : 'black-right.png';
    $chat_width_desktop = isset($faq_design_data['chat_width_desktop']) ? $faq_design_data['chat_width_desktop'] : '25';
    $chat_width_mobile = isset($faq_design_data['chat_width_mobile']) ? $faq_design_data['chat_width_mobile'] : '80';
    $title_bg_color = isset($faq_design_data['title_bg_color']) ? $faq_design_data['title_bg_color'] : '#ffffff';
    $title_text_color = isset($faq_design_data['title_text_color']) ? $faq_design_data['title_text_color'] : '#000000';
    $question_bg_color = isset($faq_design_data['question_bg_color']) ? $faq_design_data['question_bg_color'] : '#ffffff';
    $question_text_color = isset($faq_design_data['question_text_color']) ? $faq_design_data['question_text_color'] : '#000000';
    $answer_bg_color = isset($faq_design_data['answer_bg_color']) ? $faq_design_data['answer_bg_color'] : '#ffffff';
    $answer_text_color = isset($faq_design_data['answer_text_color']) ? $faq_design_data['answer_text_color'] : '#000000';

    // Handle file upload
    if (isset($_FILES['chatbot_faq_custom_icon']) && !empty($_FILES['chatbot_faq_custom_icon']['name'])) {
        if (isset($_POST['chatbot_faq_nonce']) && wp_verify_nonce($_POST['chatbot_faq_nonce'], 'chatbot_faq_save_settings')) {
            $uploaded_file = $_FILES['chatbot_faq_custom_icon'];
            $upload_overrides = array('test_form' => false);

            $movefile = wp_handle_upload($uploaded_file, $upload_overrides);
            if ($movefile && !isset($movefile['error'])) {
                $faq_design_data['custom_icon'] = $movefile['url'];
                update_option('chatbot_faq_design_data', $faq_design_data);
                echo esc_attr('<div class="updated"><p>Icon uploaded successfully.</p></div>');
            } else {
                echo esc_attr('<div class="error"><p>Error: ' . esc_html($movefile['error']) . '</p></div>');
            }
        } else {
            // Nonce invalid
            echo esc_attr ('<div class="error"><p>Error: Nonce verification failed.</p></div>');
        }
    }

    ?>
    <form method="post" action="options.php" enctype="multipart/form-data">
        <?php
        wp_nonce_field('chatbot_faq_save_settings', 'chatbot_faq_nonce');
        settings_fields('chatbot_faq_design_settings');
        ?>
        <table class="form-table">
            <tr>
                <th scope="row">Title Background Color:</th>
                <td>
                    <input type="text" name="chatbot_faq_design_data[title_bg_color]" value="<?php echo esc_attr($title_bg_color); ?>" class="color-field">
                </td>
            </tr>
            <tr>
                <th scope="row">Title Text Color:</th>
                <td>
                    <input type="text" name="chatbot_faq_design_data[title_text_color]" value="<?php echo esc_attr($title_text_color); ?>" class="color-field">
                </td>
            </tr>
            <tr>
                <th scope="row">Question Background Color:</th>
                <td>
                    <input type="text" name="chatbot_faq_design_data[question_bg_color]" value="<?php echo esc_attr($question_bg_color); ?>" class="color-field">
                </td>
            </tr>
            <tr>
                <th scope="row">Question Text Color:</th>
                <td>
                    <input type="text" name="chatbot_faq_design_data[question_text_color]" value="<?php echo esc_attr($question_text_color); ?>" class="color-field">
                </td>
            </tr>
            <tr>
                <th scope="row">Answer Background Color:</th>
                <td>
                    <input type="text" name="chatbot_faq_design_data[answer_bg_color]" value="<?php echo esc_attr($answer_bg_color); ?>" class="color-field">
                </td>
            </tr>
            <tr>
                <th scope="row">Answer Text Color:</th>
                <td>
                    <input type="text" name="chatbot_faq_design_data[answer_text_color]" value="<?php echo esc_attr($answer_text_color); ?>" class="color-field">
                </td>
            </tr>
            <tr>
                <th scope="row">Select Icon:</th>
                <td>
                    <?php
                    $icons_dir = plugin_dir_url(__FILE__) . '../public/icons/';
                    $icons = array('black-left.png', 'black-right.png', 'white-left.png', 'white-right.png');
                    foreach ($icons as $icon) {
                        $checked = ($selected_icon === $icon) ? 'checked' : '';
                        ?>
                        <label>
                            <input type="radio" name="chatbot_faq_design_data[icon]" value="<?php echo esc_attr($icon); ?>" <?php echo esc_attr($checked); ?>>
                            <img src="<?php echo esc_url($icons_dir . $icon); ?>" alt="<?php echo esc_attr($icon); ?>" style="margin: 5px; width: 24px; height: 24px;">
                        </label>
                        <?php
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
                    <input type="range" id="chat_width_slider_desktop" name="chatbot_faq_design_data[chat_width_desktop]" value="<?php echo esc_attr($chat_width_desktop); ?>" min="10" max="95" oninput="document.getElementById('chat_width_text_desktop').value = this.value">
                    <input type="number" id="chat_width_text_desktop" name="chatbot_faq_design_data[chat_width_desktop]" value="<?php echo esc_attr($chat_width_desktop); ?>" min="10" max="95" oninput="document.getElementById('chat_width_slider_desktop').value = this.value"> %
                </td>
            </tr>
            <tr>
                <th scope="row">Chat Width Mobile (%):</th>
                <td>
                    <input type="range" id="chat_width_slider_mobile" name="chatbot_faq_design_data[chat_width_mobile]" value="<?php echo esc_attr($chat_width_mobile); ?>" min="10" max="95" oninput="document.getElementById('chat_width_text_mobile').value = this.value">
                    <input type="number" id="chat_width_text_mobile" name="chatbot_faq_design_data[chat_width_mobile]" value="<?php echo esc_attr($chat_width_mobile); ?>" min="10" max="95" oninput="document.getElementById('chat_width_slider_mobile').value = this.value"> %
                </td>
            </tr>
        </table>
        <?php submit_button('Save Settings'); ?>
    </form>
    <?php
}
?>
