<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title>Learning how to code an HTML email</title>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=device-width" />
            <style>
            <!--- CSS will be here --->
            <style type="text/css">
                @media only screen and (max-width:590px){
                    .c1{
                        background-color:white !important;
                    }
                    .c3a,
                    .c3b{
                        width:100% !important;
                    }
                }
            </style>
        </head>
        <body>
            <center>
                <!-- Email template container-->
                <table border="0" cellpadding="0" height="100" width="100%">
                    <tr>
                        <td align="center" valign="top" class="email-container">
                            <!-- Email content -->
                            <table border="0" cellpadding="0" cellspacing="0" width="580">
                                <!-- Header -->
                                <tr>
                                    <td align="center" valign="middle" class="header" >
                                        <p><?= esc($user->name); ?>, Now there is very little left!</h1></p>
                                    </td>
                                </tr>
                                <!-- Content -->
                                <tr>
                                    <td align="left" valign="top" class="content">
                                        <p>Click on the link below to activate your account and enjoy what GamePlan has to offer.</p>
                                        <!-- Button as a separate table -->
                                        <table border="0" cellpadding="0" width="335" class="button-block">
                                            <tr>
                                                <td align="center" valign="middle" class="button">
                                                    <p><a href="<?= site_url('register/activate/' . $user->token) ?>">Activate my account.</a></p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Footer -->
                                <tr>
                                    <td align="center" valign="middle" class="footer">
                                        <p>GamePlan</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </center>
        </body>
    </html>
</body>
<h1>