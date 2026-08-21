<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Your CribSearch House Details Are Ready</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f1f5f9;
    font-family: Arial, Helvetica, sans-serif;
    color: #1e293b;
">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center" style="padding: 40px 15px;">

            <table
                width="600"
                cellpadding="0"
                cellspacing="0"
                border="0"
                style="
                    max-width: 600px;
                    width: 100%;
                    background: #ffffff;
                    border-radius: 18px;
                    overflow: hidden;
                    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
                "
            >

                {{-- Header --}}
                <tr>
                    <td style="
                        background: #0f172a;
                        padding: 30px;
                        text-align: center;
                    ">

                        <h1 style="
                            margin: 0;
                            color: #f59e0b;
                            font-size: 28px;
                            font-weight: 800;
                        ">
                            CribSearch
                        </h1>

                        <p style="
                            margin: 8px 0 0;
                            color: #cbd5e1;
                            font-size: 14px;
                        ">
                            Find a place you'll call home
                        </p>

                    </td>
                </tr>


                {{-- Main Content --}}
                <tr>
                    <td style="padding: 40px 35px;">

                        <h2 style="
                            margin: 0 0 15px;
                            font-size: 24px;
                            color: #0f172a;
                        ">
                            Your house details are ready 🎉
                        </h2>

                        <p style="
                            font-size: 16px;
                            line-height: 1.7;
                            color: #475569;
                        ">
                            Your payment has been confirmed and the
                            house information you unlocked is now ready.
                        </p>


                        {{-- House Information --}}
                        <div style="
                            background: #f8fafc;
                            border: 1px solid #e2e8f0;
                            border-radius: 12px;
                            padding: 20px;
                            margin: 25px 0;
                        ">

                            <h3 style="
                                margin: 0 0 8px;
                                color: #0f172a;
                                font-size: 20px;
                            ">
                                {{ $house->name }}
                            </h3>

                            @if($house->location)
                                <p style="
                                    margin: 0;
                                    color: #64748b;
                                    font-size: 14px;
                                ">
                                    📍 {{ $house->location }}
                                </p>
                            @endif

                        </div>


                        {{-- Caretaker Contact --}}
                        @if($caretakerPhone)

                            <div style="
                                background: #fffbeb;
                                border: 1px solid #fde68a;
                                border-radius: 12px;
                                padding: 20px;
                                margin: 25px 0;
                            ">

                                <p style="
                                    margin: 0 0 8px;
                                    font-size: 13px;
                                    font-weight: 700;
                                    text-transform: uppercase;
                                    letter-spacing: 0.5px;
                                    color: #92400e;
                                ">
                                    Caretaker Contact
                                </p>

                                <p style="
                                    margin: 0;
                                    font-size: 20px;
                                    font-weight: 700;
                                    color: #78350f;
                                ">
                                    {{ $caretakerPhone }}
                                </p>

                                <p style="
                                    margin: 8px 0 0;
                                    font-size: 13px;
                                    color: #92400e;
                                ">
                                    Contact the caretaker when you are
                                    ready to arrange your viewing.
                                </p>

                            </div>

                        @else

                            <div style="
                                background: #fef2f2;
                                border: 1px solid #fecaca;
                                border-radius: 12px;
                                padding: 18px;
                                margin: 25px 0;
                            ">

                                <p style="
                                    margin: 0;
                                    font-size: 14px;
                                    color: #991b1b;
                                ">
                                    Caretaker contact information is currently
                                    unavailable. Please contact CribSearch
                                    support for assistance.
                                </p>

                            </div>

                        @endif


                        {{-- Navigation --}}
                        <p style="
                            font-size: 15px;
                            line-height: 1.6;
                            color: #475569;
                        ">
                            Use the button below to get directions to the
                            property.
                        </p>

                        <div style="
                            text-align: center;
                            margin: 30px 0;
                        ">

                            <a
                                href="{{ $navigationUrl }}"
                                style="
                                    display: inline-block;
                                    background: #f59e0b;
                                    color: #ffffff;
                                    text-decoration: none;
                                    font-weight: 700;
                                    padding: 14px 28px;
                                    border-radius: 10px;
                                    font-size: 15px;
                                "
                            >
                                📍 Get Directions
                            </a>

                        </div>


                        {{-- URL fallback --}}
                        <p style="
                            font-size: 13px;
                            line-height: 1.6;
                            color: #94a3b8;
                        ">
                            If the button doesn't work, copy and paste this
                            link into your browser:
                        </p>

                        <p style="
                            word-break: break-all;
                            font-size: 12px;
                            color: #64748b;
                        ">
                            {{ $navigationUrl }}
                        </p>

                    </td>
                </tr>


                {{-- Footer --}}
                <tr>
                    <td style="
                        background: #f8fafc;
                        padding: 25px;
                        text-align: center;
                        border-top: 1px solid #e2e8f0;
                    ">

                        <p style="
                            margin: 0;
                            font-size: 13px;
                            color: #64748b;
                        ">
                            Thank you for using
                            <strong style="color: #0f172a;">
                                CribSearch
                            </strong>.
                        </p>

                        <p style="
                            margin: 8px 0 0;
                            font-size: 12px;
                            color: #94a3b8;
                        ">
                            Find your next crib with confidence.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>