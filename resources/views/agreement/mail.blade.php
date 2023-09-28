<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
    <meta content='width=device-width, initial-scale=1.0' name='viewport' />
    <meta content='text/html; charset=utf-8' http-equiv='Content-Type' />
    <meta content='light' name='color-scheme' />
    <meta content='light' name='supported-color-schemes' />
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>

<body>
    <span data-gr-ext-installed="" data-new-gr-c-s-check-loaded="14.1016.0"
        style="box-sizing: border-box;  position: relative; -webkit-text-size-adjust: none; background-color: #ffffff; color: #718096; height: 100%; line-height: 1.4; margin: 0; padding: 0; width: 100% !important;">
        <table cellpadding="0" cellspacing="0" class="wrapper" role="presentation"
            style="box-sizing: border-box; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; margin: 0; padding: 0; width: 100%;"
            width="100%">
            <tbody>
                <tr>
                    <td align="center" style="box-sizing: border-box; position: relative;">
                        <table cellpadding="0" cellspacing="0" class="content" role="presentation"
                            style="box-sizing: border-box; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 0; padding: 0; width: 100%;"
                            width="100%">
                            <tbody>
                                <tr>
                                    <td class="header"
                                        style="box-sizing: border-box; position: relative; padding: 25px 0; text-align: center;">
                                        <a href="{{ config('app.url') }}"
                                            style="box-sizing: border-box; position: relative; color: #3d4852; font-size: 19px; font-weight: bold; text-decoration: none; display: inline-block;">
                                            {{ config('app.name') }}
                                        </a>
                                    </td>
                                </tr>
                                <!-- Email Body -->
                                <tr>
                                    <td class="body"
                                        style="box-sizing: border-box; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; border-bottom: 1px solid #edf2f7; border-top: 1px solid #edf2f7; margin: 0; padding: 0; width: 100%;"
                                        width="100%">
                                        <table align="center" cellpadding="0" cellspacing="0" class="inner-body"
                                            role="presentation"
                                            style="box-sizing: border-box; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; background-color: #ffffff; border-color: #e8e5ef; border-radius: 2px; border-width: 1px; box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015); margin: 0 auto; padding: 0; width: 570px;"
                                            width="570">
                                            <!-- Body content -->
                                            <tbody>
                                                <tr>
                                                    <td class="content-cell"
                                                        style="box-sizing: border-box; position: relative; max-width: 100vw; padding: 32px;">
                                                        <p
                                                            style="box-sizing: border-box; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                                            Date :- {{ date("Y-m-d") }}
                                                        </p>
                                                        <h1
                                                            style="box-sizing: border-box; position: relative; color: #3d4852; font-size: 18px; font-weight: bold; margin-top: 0; text-align: left;">
                                                            Hello, {{ $userName }}
                                                        </h1>
                                                        <p
                                                            style="box-sizing: border-box; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                                            In the link below you have the contract signed in PDF format
                                                        </p>
                                                        <table align="center" cellpadding="0" cellspacing="0"
                                                            class="action" role="presentation"
                                                            style="box-sizing: border-box; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 30px auto; padding: 0; text-align: center; width: 100%;"
                                                            width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center"
                                                                        style="box-sizing: border-box; position: relative;">
                                                                        <table border="0" cellpadding="0"
                                                                            cellspacing="0" role="presentation"
                                                                            style="box-sizing: border-box; position: relative;"
                                                                            width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="center"
                                                                                        style="box-sizing: border-box; position: relative;">
                                                                                        <table border="0"
                                                                                            cellpadding="0"
                                                                                            cellspacing="0"
                                                                                            role="presentation"
                                                                                            style="box-sizing: border-box; position: relative;">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td
                                                                                                        style="box-sizing: border-box; position: relative;">
                                                                                                        <a class="button button-primary"
                                                                                                            href="{{ $url }}"
                                                                                                            rel="noopener"
                                                                                                            style="box-sizing: border-box; position: relative; -webkit-text-size-adjust: none; border-radius: 4px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #2d3748; border-bottom: 8px solid #2d3748; border-left: 18px solid #2d3748; border-right: 18px solid #2d3748; border-top: 8px solid #2d3748;"
                                                                                                            target="_blank">
                                                                                                            Download
                                                                                                            Agreement
                                                                                                        </a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <p
                                                            style="box-sizing: border-box; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                                            Please let me know if you have any query in this regard.
                                                        </p>
                                                        <p
                                                            style="box-sizing: border-box; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                                            Thanks,
                                                            <br />
                                                            {{ config('app.name') }}
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="box-sizing: border-box; position: relative;">
                                        <table align="center" cellpadding="0" cellspacing="0" class="footer"
                                            role="presentation"
                                            style="box-sizing: border-box; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; margin: 0 auto; padding: 0; text-align: center; width: 570px;"
                                            width="570">
                                            <tbody>
                                                <tr>
                                                    <td align="center" class="content-cell"
                                                        style="box-sizing: border-box; position: relative; max-width: 100vw; padding: 32px;">
                                                        <p
                                                            style="box-sizing: border-box; position: relative; line-height: 1.5em; margin-top: 0; color: #b0adc5; font-size: 12px; text-align: center;">
                                                            © {{ date("Y") }} {{ config('app.name') }}. All rights
                                                            reserved.
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </span>
</body>

</html>
