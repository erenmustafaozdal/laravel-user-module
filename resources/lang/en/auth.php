<?php

return [
    // register
    'register_success'              => '<p>Account created! To activate the account, we have sent an email to the email address <strong>:email</strong>. Visit email address and activate the account.</p><p>Mail of the activation to arrive by our server density can sometimes take up to 5 minutes. Please do not forget to also check the <em>Spam</em> folder of email!</p>',
    // activation
    'activation' => [
        'activation_mail_subject'       => 'Please Activate The Account',
        'not_found'                     => 'Aktivation link not found.',
        'fail'                          => 'Account is not activated.',
        'success'                       => 'Account is activated.'
    ],
    // login
    'login' => [
        'title'                         => 'Login',
        'fail'                          => 'Login failed! Please check your information and try again. If you\'ve been new members, you can not access the account without the account activation.',
        'exception' => [
            'throttling' => [
                'global'                => 'Our system currently seems to be under attack. We had to call our service up until this passes. Please make entry: try again after the historic :date',
                'ip'                    => 'IP addresses are made from a lot of unauthorized login attempts. : Wait before attempting to re-enter before the deadline :date !',
                'user'                  => 'We received a lot of requests to access your account from unauthorized access. For safety: up to :date account of the history we have mass.'
            ],
            'not_activate'              => 'You can not login to the account is not active.'
        ]
    ],
    // forget password and reset password
    'mail_subject'                  => 'Your Password Reset Link',
];