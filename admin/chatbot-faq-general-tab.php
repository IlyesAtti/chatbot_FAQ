<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function get_chatbot_faq_data() {
    return get_option('chatbot_faq_data', array(
        'title' => 'Chatbot FAQ',
        'questions' => array(),
        'active' => false,
        'sticky_title' => false,
    ));
}

function chatbot_faq_save_options() {
    if ( ! isset( $_POST['chatbot_faq_nonce_field'] ) || ! wp_verify_nonce( $_POST['chatbot_faq_nonce_field'], 'chatbot_faq_nonce_action' ) ) {
        wp_die('Nonce verification failed');
    }

    $faq_data = array(
        'title' => sanitize_text_field( $_POST['chatbot_faq_data']['title'] ),
        'questions' => array(),
        'active' => isset( $_POST['chatbot_faq_data']['active'] ) ? (bool) $_POST['chatbot_faq_data']['active'] : false,
        'sticky_title' => isset( $_POST['chatbot_faq_data']['sticky_title'] ) ? (bool) $_POST['chatbot_faq_data']['sticky_title'] : false,
    );

    if ( isset( $_POST['chatbot_faq_data']['questions'] ) ) {
        foreach ( $_POST['chatbot_faq_data']['questions'] as $index => $faq ) {
            $faq_data['questions'][] = array(
                'question' => wp_kses_post( $faq['question'] ),
                'answer'   => wp_kses_post( $faq['answer'] )
            );
        }
    }

    update_option( 'chatbot_faq_data', $faq_data );

    wp_redirect( admin_url( 'admin.php?page=chatbot_faq' ) );
    exit;
}
add_action('admin_post_save_chatbot_faq_settings', 'chatbot_faq_save_options');

function chatbot_faq_general_tab() {
    $faq_data = get_chatbot_faq_data();
    
    $sticky_title = isset($faq_data['sticky_title']) ? $faq_data['sticky_title'] : false;
    $active = isset($faq_data['active']) ? $faq_data['active'] : false;
    ?>
    <form method="post" action="options.php">
        <?php
        settings_fields('chatbot_faq_settings');
        wp_nonce_field('chatbot_faq_nonce_action', 'chatbot_faq_nonce_field');
        ?>
        <table class="form-table">
            <tr>
                <th scope="row">FAQ Title:</th>
                <td>
                    <input type="text" name="chatbot_faq_data[title]" value="<?php echo esc_attr($faq_data['title']); ?>" size="60">
                    <br>
                    <input type="checkbox" id="chatbot_faq_sticky_title" name="chatbot_faq_data[sticky_title]" value="1" <?php checked(1, $sticky_title, true); ?>>
                    <label for="chatbot_faq_sticky_title">
                        Sticky Title and Close Button
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row">Questions and Answers:</th>
                <td>
                    <div id="chatbot_faq_questions_wrapper">
                        <?php
                        if ( empty( $faq_data['questions'] ) ) {
                            $faq_data['questions'] = array(array('question' => '', 'answer' => ''));
                        }

                        foreach ( $faq_data['questions'] as $index => $faq ) {
                            $question = isset( $faq['question'] ) ? $faq['question'] : '';
                            $answer = isset( $faq['answer'] ) ? $faq['answer'] : '';
                            ?>
                            <div class="faq-item" data-index="<?php echo esc_attr( $index ); ?>">
                                <p>
                                    <label for="chatbot_faq_question_<?php echo esc_attr( $index ); ?>">Question:</label><br>
                                    <textarea id="chatbot_faq_question_<?php echo esc_attr($index); ?>" name="chatbot_faq_data[questions][<?php echo esc_attr($index); ?>][question]" rows="2" cols="60"><?php echo wp_kses_post($question); ?></textarea>
                                </p>
                                <p>
                                    <label for="chatbot_faq_answer_<?php echo esc_attr( $index ); ?>">Answer:</label><br>
                                    <textarea id="chatbot_faq_answer_<?php echo esc_attr($index); ?>" name="chatbot_faq_data[questions][<?php echo esc_attr($index); ?>][answer]" rows="5" cols="60"><?php echo wp_kses_post($answer); ?></textarea>
                                </p>
                                <button type="button" class="button remove_faq_item" data-index="<?php echo esc_attr( $index ); ?>">
                                    Remove FAQ Item
                                </button>
                                <hr>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <button type="button" class="button" id="add_faq_item">
                        Add New FAQ Item
                    </button>
                </td>
            </tr>
            <tr>
                <th scope="row">Activate Chatbot:</th>
                <td>
                    <input type="checkbox" id="chatbot_faq_active" name="chatbot_faq_data[active]" value="1" <?php checked(1, $active, true); ?>>
                    <label for="chatbot_faq_active">
                        Enable Chatbot
                    </label>
                </td>
            </tr>
        </table>
        <?php submit_button('Save Settings'); ?>
    </form>
    <?php
}
?>
