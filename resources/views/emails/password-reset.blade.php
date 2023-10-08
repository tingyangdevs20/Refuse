<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>
    <p>Hello {{ $username }},</p>
    
    <p>We received a request to reset your password for your account with the email address: {{ $email }}.</p>
    
    <p>To reset your password, click the following link:</p>
    
    <a href="{{ $resetLink }}">Password Reset</a>
    
    <p>If you did not request a password reset, you can ignore this email. Your password will remain unchanged.</p>
    
    <p>Thank you!</p>
</body>
</html>