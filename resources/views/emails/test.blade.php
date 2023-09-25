<!DOCTYPE html>
<html lang="en-US">
  <head>
      <style>
        .btn-danger {
            color: #fff;
            background-color: #f46a6a;
            border-color: #f46a6a;
        }
      </style>
    <meta charset="utf-8" />
  </head>
  <body>
    <p><?php echo htmlspecialchars_decode(stripslashes($test_message)); ?></p>

    <hr style="margin:10px 0px;">
    <p>You're receiving this email because of your relationship with ninjamarketing To stop future emails <a href="{{ $unsub_link }}">Unsubscribe.</a> To update email preferences Manage Notifications</p>
    <!--<p><b></b></p>-->
  </body>
</html>
