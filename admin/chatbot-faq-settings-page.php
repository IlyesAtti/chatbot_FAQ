<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function chatbot_faq_settings_page() {

    if (isset($_GET['_wpnonce'])) {
        $nonce = sanitize_text_field(wp_unslash($_GET['_wpnonce']));
        if (!wp_verify_nonce($nonce, 'chatbot-faq-settings')) {
            echo '<div class="error"><p>Nonce verification failed. Please try again.</p></div>';
            return;
        }
    } 

    $tab = isset($_GET['tab']) ? sanitize_text_field(wp_unslash($_GET['tab'])) : 'general';
    $tab = ($tab === 'design') ? 'design' : 'general';
    
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Chatbot FAQ Settings', 'your-text-domain'); ?></h1>
        
        <h2 class="nav-tab-wrapper">
            <a href="<?php echo esc_url(admin_url('options-general.php?page=chatbot-faq-settings&_wpnonce=' . wp_create_nonce('chatbot-faq-settings'))); ?>" class="nav-tab <?php echo esc_url ($tab === 'general') ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('General', 'your-text-domain'); ?>
            </a>
            <a href="<?php echo esc_url(admin_url('options-general.php?page=chatbot-faq-settings&tab=design&_wpnonce=' . wp_create_nonce('chatbot-faq-settings'))); ?>" class="nav-tab <?php echo esc_url ($tab === 'design') ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Design', 'your-text-domain'); ?>
            </a>
        </h2>

        <?php

        if ($tab === 'design') {
            chatbot_faq_design_tab();
        } else {
            chatbot_faq_general_tab();
        }
        ?>
    </div>
    <?php
}