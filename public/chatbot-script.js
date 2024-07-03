/*
* chatbot scripts
*/
jQuery(document).ready(function($) {
    $('.chatbot-answer').hide();

    $('.chatbot-question').click(function() {
        $(this).next('.chatbot-answer').slideToggle();
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#chatbot-faq, #chatbot-icon').length) {
            $('.chatbot-answer').slideUp();
        }
    });

    $('#chatbot-icon').click(function() {
        $('#chatbot-faq').toggle();
        $('#close-chatbot').toggle($('#chatbot-faq').is(':visible'));
    });

    $('#close-chatbot').click(function() {
        $('#chatbot-faq').hide();
        $('#close-chatbot').hide();
    });
});
