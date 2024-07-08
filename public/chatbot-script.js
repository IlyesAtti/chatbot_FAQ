jQuery(document).ready(function($) {
    // Hide all answers initially
    $('.chatbot-answer').hide();

    // Toggle answer visibility on question click
    $('.chatbot-question').click(function() {
        $(this).next('.chatbot-answer').slideToggle();
    });

    // Hide answers when clicking outside the FAQ area
    $(document).click(function(e) {
        if (!$(e.target).closest('#chatbot-faq, #chatbot-icon').length) {
            $('.chatbot-answer').slideUp();
        }
    });

    // Toggle FAQ visibility on icon click
    $('#chatbot-icon').click(function() {
        $('#chatbot-faq').toggle();
        $('#close-chatbot').toggle($('#chatbot-faq').is(':visible'));
    });

    // Close FAQ on close button click
    $('#close-chatbot').click(function() {
        $('#chatbot-faq').hide();
        $('#close-chatbot').hide();
    });

    // Apply sticky class if enabled
    if (chatbot_faq_sticky_title) {
        $('#chatbot-faq .sticky-wrapper').addClass('sticky');
    }

    if ($('.sticky-wrapper').length > 0) {
        $('#close-chatbot').show();
    }
});
