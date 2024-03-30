<?php
// Defines for newsletter sidebox

// IMPORTANT!  You must use your own values for the 
// four fields below.  PLEASE READ THE INSTRUCTIONS. 
// http://www.thatsoftwareguy.com/zencart_mailchimp.html
//
    /**
     *  developed, copyrighted and brought to you by @proseLA (github)
     *  https://mxworks.cc
     *  copyright 2024 proseLA
     *  03/2024  project: mailchimp v5.0.0 file: mailchimp_sidebox_defines.php
     */

    if (!defined('BOX_MAILCHIMP_NEWSLETTER_ID')) {
        define('BOX_MAILCHIMP_NEWSLETTER_ID', 'xxxxxxxxxx');
        define('BOX_MAILCHIMP_NEWSLETTER_U', 'yyyyyyyyyy');
        define('BOX_MAILCHIMP_NEWSLETTER_URL', 'http://YourSite.us1.list-manage.com/subscribe/post');
        define('BOX_MAILCHIMP_NEWSLETTER_API_KEY', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');

// Language defines for newsletter sidebox
        define('BOX_HEADING_MAILCHIMP_SIDEBOX', 'Newsletter');
        define('BOX_MAILCHIMP_PITCH', 'Subscribe to our newsletter for periodic updates and valuable coupons.');
        define('BOX_MAILCHIMP_SUBSCRIBE', 'Subscribe');
    }
