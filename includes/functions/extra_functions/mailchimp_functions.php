<?php
    // Marketing API
    // v. 3.0.81
    /**
     *  developed, copyrighted and brought to you by @proseLA (github)
     *  https://mxworks.cc
     *  copyright 2024 proseLA
     *  03/2024  project: mailchimp v5.0.0 file: mailchimp_functions.php
     */

    function mailchimp_add(string $email, string $email_format = 'html', bool $subscribe = true)
    {
        include_once DIR_WS_INCLUDES . 'mailchimp-marketing-php/vendor/autoload.php';

        $client = new MailchimpMarketing\ApiClient();

        $serverPrefix = explode('-', BOX_MAILCHIMP_NEWSLETTER_API_KEY)[1];

        $client->setConfig([
                               'apiKey' => BOX_MAILCHIMP_NEWSLETTER_API_KEY,
                               'server' => $serverPrefix,
                           ]);

        if ($email_format === 'TEXT') {
            $format = 'text';
        } else {
            $format = 'html';
        }
        $status = 'unsubscribed';
        $errorMessageStart = 'Problem Unsubscribing!';
        if ($subscribe) {
            $status = 'subscribed';
            $errorMessageStart = 'Problem adding Subscriber!';
        }

        $list_id = BOX_MAILCHIMP_NEWSLETTER_ID;
        $hash = md5(strtolower($email));

        try {
            $response = $client->lists->setListMember($list_id, $hash, [
                'email_address' => $email,
                'status_if_new' => $status,
                'email_type' => $format,
                'status' => $status,
            ]);
        } catch (Exception $e) {
            $httpResponseCode = $e->getCode();
            $message = $e->getMessage();
            $errorMessage = $errorMessageStart . "\n" .
                "  email: " . $email . "\n" .
                "  code: " . $httpResponseCode . "\n" .
                "  Msg: " . $message . "\n";
            $file = DIR_FS_LOGS . '/' . 'MailChimp.log';
            if ($fp = @fopen($file, 'a')) {
                fwrite($fp, $errorMessage);
                fclose($fp);
            }
        }
    }

    function mailchimp_del(string $email)
    {
        mailchimp_add($email, 'html', false);
    }

