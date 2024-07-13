<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function chatbot_faq_settings_page() {

    $tab = isset($_GET['tab']) && sanitize_text_field(wp_unslash($_GET['tab'])) === 'design' ? 'design' : 'general';

    ?>
    <div class="wrap">
        <h1>Chatbot FAQ Settings</h1>

        <h2 class="nav-tab-wrapper">
            <a href="?page=chatbot-faq-settings&_wpnonce=<?php echo esc_attr(wp_create_nonce('chatbot-faq-settings')); ?>" class="nav-tab <?php echo (!isset($_GET['tab']) || sanitize_text_field(wp_unslash($_GET['tab'])) === 'general') ? 'nav-tab-active' : ''; ?>">
                General
            </a>
            <a href="?page=chatbot-faq-settings&tab=design&_wpnonce=<?php echo esc_attr(wp_create_nonce('chatbot-faq-settings')); ?>" class="nav-tab <?php echo (isset($_GET['tab']) && sanitize_text_field(wp_unslash($_GET['tab'])) === 'design') ? 'nav-tab-active' : ''; ?>">
                Design
            </a>
        </h2>

        <?php
        // Verificăm nonce-ul pentru a proteja procesarea datelor formularului
        if (isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'chatbot-faq-settings')) {
            if ($tab === 'design') {
                chatbot_faq_design_tab();
            } else {
                chatbot_faq_general_tab();
            }
        } else {
            echo '<p>Nonce verification failed. Please try again.</p>';
        }
        ?>
    </div>
    <?php
}
?>
