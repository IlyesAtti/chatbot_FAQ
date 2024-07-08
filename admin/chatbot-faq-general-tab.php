<?php

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
                    <input type="text" name="chatbot_faq_data[title]" 
                        value="<?php echo esc_attr($faq_data['title']); ?>" size="60">
                    <br>
                    <input type="checkbox" id="chatbot_faq_sticky_title" 
                        name="chatbot_faq_data[sticky_title]" value="1" <?php 
                        checked(1, $faq_data['sticky_title'], true); ?>>
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
                        if (empty($faq_data['questions'])) {
                            $faq_data['questions'] = array(array('question' => '', 'answer' => ''));
                        }

                        foreach ($faq_data['questions'] as $index => $faq) {
                            $question = isset($faq['question']) ? 
                            preg_replace('/^\s+|\s+$/m', '', trim($faq['question'])) : '';
                            $answer = isset($faq['answer']) ? 
                            preg_replace('/^\s+|\s+$/m', '', trim($faq['answer'])) : '';
                            ?>
                            <div class="faq-item" data-index="<?php echo $index; ?>">
                                <p>
                                    <label for="chatbot_faq_question_<?php 
                                        echo $index; ?>">Question:</label><br>
                                    <textarea id="chatbot_faq_question_
                                        <?php echo $index; ?>" name="chatbot_faq_data[questions][
                                        <?php echo $index; ?>][question]" rows="2" 
                                        cols="60"><?php echo esc_textarea($question); ?>
                                    </textarea>
                                </p>
                                <p>
                                    <label for="chatbot_faq_answer_
                                        <?php echo $index; ?>">
                                        Answer:
                                    </label><br>
                                    <textarea id="chatbot_faq_answer_
                                        <?php echo $index; ?>" name="chatbot_faq_data[questions][
                                        <?php echo $index; ?>][answer]" rows="5"
                                        cols="60"><?php echo esc_textarea($answer); ?>
                                    </textarea>
                                </p>
                                <button class="button remove_faq_item">
                                    Remove FAQ Item
                                </button>
                                <hr>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <button class="button" id="add_faq_item">
                        Add New FAQ Item
                    </button>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    Activate Chatbot:
                </th>
                <td>
                    <input type="checkbox" id="chatbot_faq_active" 
                        name="chatbot_faq_data[active]" value="1" 
                        <?php checked(1, $faq_data['active'], true); ?>>
                    <label for="chatbot_faq_active">
                        Enable Chatbot
                    </label>
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
                            <textarea id="chatbot_faq_question_${index}"
                                name="chatbot_faq_data[questions][${index}][question]"
                                rows="2" cols="60">
                            </textarea>
                        </p>
                        <p>
                            <label for="chatbot_faq_answer_${index}">Answer:</label><br>
                            <textarea id="chatbot_faq_answer_${index}" 
                                name="chatbot_faq_data[questions][${index}][answer]" 
                                rows="5" cols="60">
                            </textarea>
                        </p>
                        <button class="button remove_faq_item">
                            Remove FAQ Item
                        </button>
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
