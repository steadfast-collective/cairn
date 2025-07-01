<?php

return [
    'fields' => [
        'first_name' => [
            'label' => "First name",
            'placeholder' => "Enter your first name",
        ],
        'last_name' => [
            'label' => "Last name",
            'placeholder' => "Enter your last name",
        ],
        'name' => [
            'label' => "Name",
            'placeholder' => "Enter your name",
        ],
        'email' => [
            'label' => "Email Address",
            'placeholder' => "Enter your email"
        ],
        'password' => [
            'label' => "Password"
        ],
        'current_password' => [
            'label' => "Current Password"
        ],
        'new_password' => [
            'label' => "New Password"
        ],
        'new_password_confirmation' => [
            'label' => "Confirm New Password"
        ],
        'password_confirmation' => [
            'label' => "Confirm Password",
        ],
        'remember_me' => [
            'label' => "Remember Me"
        ],
        'code' => [
            'label' => "Enter verification code",
        ],
    ],
    'login' => [
        'seo_title' => 'Login',
        'title' => "Login",
        'forgot_password_link' => "Forgotten password",
        'socialite' => [
            'google' => "Login with Google",
            'github' => "Login with Github",
            'facebook' => "Login with Facebook",
        ]
    ],
    'log_out' => "Log out",
    'logged_out' => "Logged out",
    'credentials_incorrect' => "The provided credentials do not match our records.",
    'forgotten_password' => [
        'seo_title' => "Forgotten Password",
    ],
    'password_reset_link_sent' => [
        'seo_title' => "Password Reset Link Sent"
    ],
    'reset_password' => [
        'seo_title' => "Reset Password"
    ],
    'account_recovery_success' => [
        'seo_title' => "Account Recovery Success",
    ],
    'password_reset_token' => [
        'expired' => [
            'seo_title' => "Password Reset Link Expired",
            'message' => "Your password reset link has expired. Please request a new one.",
        ],
        'invalid' => [
            'seo_title' => "Invalid Password Reset Link",
            'message' => "The password reset link is invalid or has been used.",
        ],
    ],
    'register' => [
        'seo_title' => "Create your account",
    ],
    'password_reset_email' => [
        'subject' => "Password Reset",
        'title' => "Password Reset Request",
        'greeting' => "Hello :name,",
        'line_1' => "You are receiving this email because we received a password reset request for your account.",
        'line_2' => "Click the button below to reset your password. This password reset link will expire in 60 minutes.",
        'button_label' => "Reset Password",
        'line_3' => "If you did not request a password reset, no further action is required.",
        'sign_off' => "Thanks,",
        'link_help' => "If you're having trouble clicking the 'Reset Password' button, copy and paste the URL below into your web browser:"
    ],
    'account' => [
        'seo_title' => "My Account",
        'details' => [
            'title' => "My Details",
            'update-success' => "Account details updated successfully.",
            'button_label' => "Update My Details",
        ],
        'password' => [
            'title'=> "My Password",
            'update-success' => "Password updated successfully.",
            'update-error' => "Something went wrong while updating your password. Please try again later.",
            'incorrect' => "The :attribute is incorrect.",
            'must-not-match' => "The :attribute must not be the same as your current password.",
            'button_label' => "Update password"
        ],
        'two_factor' => [
            'title' => "Two Factor Authentication",
            'disabled' => "Two Factor authentication is not enabled.",
            'enable_button' => "Enable",
            'active' => "Two Factor authentication is enabled.",
            'disable_button' => "Disable",
            'description' => "Protect your account with additional security by enabling two-factor authentication (2FA). You'll be required to enter both your password and an authentication code to sign in.",
            'auth_methods' => "Authentication Methods",
            'recovery_codes_updated' => "Your recovery codes have been updated. Keep them somewhere safe! You'll need these if you lose access to your authenticator app. You won't see these again.",
            'auth_app' => [
                'title' => "Authenticator App",
                'description' =>  "Set up an authenticator app to receive verification codes from the authenticator app on your mobile device.",
            ],
            'recovery_codes' => [
                'title' => "Recovery Codes",
                'unused' => ":count Unused code|:count Unused Codes",
                'reset' => "Reset Codes",
                'notice' => "Latest use of recovery codes: :date at :time. If this wasn't you, use the above button to generate new codes.",
                'save_prompt' => "These are your recovery codes. Keep them somewhere safe! You'll need these if you lose access to your authenticator app. You won't see these again.",
            ],
            'confirm_page' => [
                'title' => "Setup Authenticator App",
                'seo_title' => "Activate 2FA",
                'setup_key_title' => "Can't scan the QR code?",
                'setup_key_instructions' => "Enter this code instead:",
                'description' => "Each time you log in, in addition to your password, you'll use an authenticator app to generate a one-time code.",
                'step_1' => [
                    'step' => "Step 1",
                    'title' => "Scan QR Code",
                    'instructions' => "Scan the QR code below or manually enter the secret key into your authenticator app."
                ],
                'step_2' => [
                    'step' => "Step 2",
                    'title' => "Get Verification Code",
                    'instructions' => "Enter the 6-digit code you see in your authenticator app."
                ],
                'activate_button' => "Activate",
            ],
            'activated_success' => "Two factor authentication has been activated successfully.",
            'deactivated_success' => "Two factor authentication has been deactivated successfully.",
            'challenge' => [
                'title' => 'Two Factor Authentication',
                'seo_title' => 'Verify your identity',
                'code' => [
                    'label' => "Please enter the verification code from your authenticator app to continue.",
                    'placeholder' => "Enter 6-digit code"
                ],
                'other_methods' => [
                    'prompt' => "Having trouble?",
                    'button' => "See other methods",
                    'title' => "Choose a method",
                    'description' => "Select a verification method to login to your account.",
                    'back_to_primary' => "Back To Primary Method",
                    'use_recovery' => "Use A Recovery Code"
                ],
                'recovery_code' => [
                    'label' => "Enter one of your recovery codes below.",
                    'placeholder' => "Enter recovery code",
                ],
                'verify_code' => "Verify",
            ]
        ],
        'delete_account' => [
            'button' => 'Delete Account',
            'success' => 'Account deleted successfully.'
        ]
    ],
    'validation' => [
        'invalid_code' => 'The provided code is invalid.',
        'invalid_recovery_code' => 'The provided recovery code is invalid.',
        'throttle' => 'Too many attempts. Please wait before retrying.',
    ]
];
