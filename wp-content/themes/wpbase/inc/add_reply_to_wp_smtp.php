<?php
/* Set a Custom Reply-To Email
*
* Original doc: https://wpmailsmtp.com/docs/setting-a-custom-reply-to-email/
*/

function wp_mail_smtp_dev_reply_to($args)
{

    $reply_to = 'Reply-To: Name website <doamin@gmail.com>';

    if (! empty($args['headers'])) {
        if (! is_array($args['headers'])) {
            $args['headers'] = array_filter(explode("\n", str_replace("\r\n", "\n", $args['headers'])));
        }

        // Filter out all other Reply-To headers.
        $args['headers'] = array_filter($args['headers'], function ($header) {
            return strpos(strtolower($header), 'reply-to') !== 0;
        });
    } else {
        $args['headers'] = [];
    }

    $args['headers'][] = $reply_to;

    return $args;
}
add_filter('wp_mail', 'wp_mail_smtp_dev_reply_to', PHP_INT_MAX);
