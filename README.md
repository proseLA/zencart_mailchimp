# MailChimp Integration for Zen Cart
(Formerly called MailChimp Sidebox)
Version 4.2

Note: This uses MailChimp API 3.0. All prior versions have been deprecated.    
If you also use Newsletter Discount, you MUST update that too. 

Author: Scott Wilson
http://www.thatsoftwareguy.com 
Zen Forum PM swguy

Released under the GNU General Purpose License 
See LICENSE for details.

Donations welcome at https://donate.thatsoftwareguy.com/

Even more information on this contribution is provided in
https://www.thatsoftwareguy.com/zencart_mailchimp.html

No warranties expressed or implied; use at your own risk.  Released under the GPL.

--------------------------------------------------
Overview: 
Provides a subscription mechanism you can put in a sidebox if you
are using MailChimp for your newsletters, as well as a modification to
account creation so subscriptions will work there too.

MailChimp is a great newsletter management service that has a per-
message pricing model.  This makes it much more affordable than
Constant Contact for small businesses with low email volumes.
(Constant Contact charges a monthly fee irrespective of how much 
mail you send.)

To sign up for their service, go to https://www.mailchimp.com

--------------------------------------------------

Pre-Installation Preparation: 

0. Read the MailChimp Email Marketing Guide at 
https://mailchimp.com/resources/email-marketing-field-guide/

1. Sign up for mailchimp at https://www.mailchimp.com

2. Create a list for your newsletter (press the Lists tab
at the top of the page, then "Create New List").  In your Sign-up form, I suggest only having email address (if you want more fields, you'll have to modify this contribution).

3. Press the "Forms" link for your new list.
Scroll down to the link that says "Signup Form" and click it.
This will take you to a screen which will show you your signup form.

    Look at the HTML code.  
    At the top of the form will be something that looks like this: 
    `<form action="http://list-manage.com/subscribe/post" method="POST">`

    Note the URL. 

    At the bottom of the form will be something like this: 
    ```
    <td align="left"><INPUT TYPE='submit' NAME='submit' VALUE='Subscribe'>
    <input type="hidden" name="id" value="5331068383">
    <input type="hidden" name="u" value="0dcb1c9808"></td>
    ```

    Note the the values of "u" and "id" - you will be 
    embedding them in the language file during the installation process.

    Find the line that starts with "real people should not fill this in and expect good       things".  Underneath this, between a start and end `<div>` tag is the bot prevention code.  Note this.

4. At the top of the Mailchimp page is a dropdown called "Account."
Select "api keys & info" and add an api key to your account.  
Note the value; you will be embedding
it in the language file during the installation process.

5. Take the time to test and customize MailChimp before 
adding it to your site.


--------------------------------------------------

Installation Instructions: 

1. Back up everything!  Try this in a test environment prior to installing
it on a live shop.

1. Copy the contents of the folder you have unzipped to 
the root directory of your shop.  

1. Edit the file
`includes/languages/english/extra_definitions/mailchimp_sidebox_defines.php`
set the `BOX_MAILCHIMP_NEWSLETTER_ID` to the "id" value you noted 
in step 3 of the pre-installation instructions.
set the `BOX_MAILCHIMP_NEWSLETTER_U` to the "u" value you noted 
in step 3 of the pre-installation instructions.
Set `BOX_MAILCHIMP_NEWSLETTER_URL` to the URL value you noted in 
step 3 of the pre-installation instructions.
For US based sites, this will be `http://us1.list-manage.com/subscribe/post`
Set `BOX_MAILCHIMP_APIKEY` to the value you noted in step 4 of the 
pre-installation instructions.

1. Edit the file `includes/templates/template_default/sideboxes/tpl_mailchimp_sidebox.php`.  Add in the bot prevention part of the form under the line that says
Put the bot signup prevention code here.

1. In Admin->Tools->Layout Boxes Controller, turn on the MailChimp
   sidebox.

1. Changes to your Zen Cart configuration: 
   a) In Configuration->Customer Details, set Show Newsletter Checkbox to 1.
   b) In Configuration->Email Options, set Display "Newsletter Unsubscribe"
      Link to false.  
      (To subscribe, people use the MailChimp sidebox; to unsubscribe, they
      use the link at the bottom of the newsletter.)

1. If you do not yet have an 
       `includes/modules/YOUR_TEMPLATE/create_account.php`, 

   create one: copy `includes/modules/create_account.php` to 
       `includes/modules/YOUR_TEMPLATE/create_account.php`

   Look for the line: 
   ```
   $zco_notifier->notify('NOTIFY_LOGIN_SUCCESS_VIA_CREATE_ACCOUNT');
   ```

   right below it, add the code: 
   ```
   if ((int)$newsletter == 1) { 
       mailchimp_add($email_address);
   }
   ```

1. In `includes/modules/pages/account_newsletters/header_php.php `
   change 
   
```
$newsletter_query = "SELECT customers_newsletter
```

to 
```
$newsletter_query = "SELECT customers_newsletter, customers_email_address
```
Then right above 
```
$sql = "UPDATE " . TABLE_CUSTOMERS . "
```
add 
```
    // Not the same? Then update MailChimp 
    $email_address = $newsletter->fields['customers_email_address']; 
    if ($newsletter_general == '0') {
       mailchimp_del($email_address);
    } else {
       mailchimp_add($email_address);
    }

```
--------------------------------------------------

