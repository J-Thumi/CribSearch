<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verify your CribSearch email</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f1f5f9;
    font-family: Arial, Helvetica, sans-serif;
    color: #1e293b;
">

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="background-color: #f1f5f9; padding: 40px 15px;"
>
    <tr>
        <td align="center">

            <!-- Main container -->
            <table
                width="100%"
                cellpadding="0"
                cellspacing="0"
                border="0"
                style="
                    max-width: 600px;
                    background-color: #ffffff;
                    border-radius: 16px;
                    overflow: hidden;
                    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08);
                "
            >

                <!-- Header -->
                <tr>
                    <td
                        align="center"
                        style="
                            background-color: #2563eb;
                            padding: 30px 20px;
                        "
                    >
                        <div
                            style="
                                font-size: 30px;
                                font-weight: 800;
                                color: #ffffff;
                                letter-spacing: -1px;
                            "
                        >
                            CribSearch
                        </div>

                        <div
                            style="
                                margin-top: 6px;
                                color: #dbeafe;
                                font-size: 14px;
                            "
                        >
                            Find your next place to call home
                        </div>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding: 40px 35px;">

                        <h1
                            style="
                                margin: 0 0 20px;
                                font-size: 26px;
                                line-height: 1.3;
                                color: #0f172a;
                            "
                        >
                            Welcome to CribSearch, {{ $user->name }}! 👋
                        </h1>

                        <p
                            style="
                                margin: 0 0 18px;
                                font-size: 16px;
                                line-height: 1.7;
                                color: #475569;
                            "
                        >
                            Thanks for creating your CribSearch account.
                        </p>

                        <p
                            style="
                                margin: 0 0 28px;
                                font-size: 16px;
                                line-height: 1.7;
                                color: #475569;
                            "
                        >
                            Please verify your email address to complete your
                            registration and start discovering houses that fit
                            what you're looking for.
                        </p>

                        <!-- Button -->
                        <table
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            width="100%"
                        >
                            <tr>
                                <td align="center">

                                    <a
                                        href="{{ $verificationUrl }}"
                                        style="
                                            display: inline-block;
                                            background-color: #2563eb;
                                            color: #ffffff;
                                            text-decoration: none;
                                            font-size: 16px;
                                            font-weight: 700;
                                            padding: 14px 30px;
                                            border-radius: 10px;
                                        "
                                    >
                                        Verify My Email
                                    </a>

                                </td>
                            </tr>
                        </table>

                        <!-- Expiration -->
                        <p
                            style="
                                margin: 30px 0 0;
                                font-size: 13px;
                                line-height: 1.6;
                                color: #64748b;
                                text-align: center;
                            "
                        >
                            This verification link will expire in
                            {{ config('auth.verification.expire', 60) }}
                            minutes.
                        </p>

                        <!-- Fallback URL -->
                        <div
                            style="
                                margin-top: 30px;
                                padding: 18px;
                                background-color: #f8fafc;
                                border-radius: 10px;
                            "
                        >
                            <p
                                style="
                                    margin: 0 0 8px;
                                    font-size: 13px;
                                    color: #64748b;
                                "
                            >
                                If the button doesn't work, copy and paste this
                                link into your browser:
                            </p>

                            <a
                                href="{{ $verificationUrl }}"
                                style="
                                    font-size: 12px;
                                    line-height: 1.6;
                                    color: #2563eb;
                                    word-break: break-all;
                                    text-decoration: none;
                                "
                            >
                                {{ $verificationUrl }}
                            </a>
                        </div>

                        <p
                            style="
                                margin: 30px 0 0;
                                font-size: 14px;
                                line-height: 1.6;
                                color: #64748b;
                            "
                        >
                            If you didn't create a CribSearch account, you can
                            safely ignore this email.
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td
                        align="center"
                        style="
                            background-color: #f8fafc;
                            padding: 25px 20px;
                            border-top: 1px solid #e2e8f0;
                        "
                    >

                        <div
                            style="
                                font-size: 14px;
                                font-weight: 700;
                                color: #334155;
                            "
                        >
                            CribSearch
                        </div>

                        <div
                            style="
                                margin-top: 6px;
                                font-size: 12px;
                                color: #94a3b8;
                            "
                        >
                            Find your next place to call home.
                        </div>

                        <div
                            style="
                                margin-top: 12px;
                                font-size: 11px;
                                color: #94a3b8;
                            "
                        >
                            © {{ date('Y') }} CribSearch. All rights reserved.
                        </div>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>