<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f7; color: #51545e; margin: 0; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width: 570px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; padding: 32px; border: 1px solid #eaeaec;">
        <tr>
            <td>
                <h1 style="font-size: 20px; font-weight: bold; color: #333333; margin-bottom: 16px;">
                    Hello {{ $name }},
                </h1>

                <p style="font-size: 14px; line-height: 1.5; color: #51545e; margin-bottom: 24px;">
                    You are receiving this email because we received a password reset request for your account on <strong>{{ $appName }}</strong>.
                </p>

                <div style="text-align: center; margin-bottom: 24px;">
                    <a href="{{ $url }}" style="display: inline-block; background-color: #d97706; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: bold; font-size: 14px;">
                        Reset Password
                    </a>
                </div>

                <p style="font-size: 13px; line-height: 1.5; color: #6b7280; margin-bottom: 16px;">
                    This password reset link will expire in {{ $count }} minutes.
                </p>

                <p style="font-size: 13px; line-height: 1.5; color: #6b7280; margin-bottom: 24px;">
                    If you did not request a password reset, no further action is required.
                </p>

                <hr style="border: none; border-top: 1px solid #eaeaec; margin-bottom: 24px;">

                <p style="font-size: 12px; color: #9ca3af; margin: 0;">
                    If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:
                    <br>
                    <a href="{{ $url }}" style="color: #d97706; word-break: break-all;">{{ $url }}</a>
                </p>
            </td>
        </tr>
    </table>
</body>
</html>