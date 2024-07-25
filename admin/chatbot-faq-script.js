jQuery(document).ready(function($) {

    // Apply sticky class if enabled
    if (chatbot_faq_sticky_title) {
        $('#chatbot-faq .sticky-wrapper').addClass('sticky');
    }

    if ($('.sticky-wrapper').length > 0) {
        $('#close-chatbot').show();
    }

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

