<?php

function chatbot_faq_settings_page() {
    ?>
    <div class="wrap">
        <h1>Chatbot FAQ Settings</h1>

        <h2 class="nav-tab-wrapper">
            <a href="?page=chatbot-faq-settings" class="nav-tab 
                <?php echo (!isset($_GET['tab']) || $_GET['tab'] === 'general')
                ? 'nav-tab-active' : ''; ?>">
                General
            </a>
            <a href="?page=chatbot-faq-settings&tab=design" class="nav-tab 
                <?php echo (isset($_GET['tab']) && $_GET['tab'] === 'design') 
                ? 'nav-tab-active' : '';  ?>">
                Design
            </a>
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
