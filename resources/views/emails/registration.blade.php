<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Confirmation</title>

</head>
<body>
<div class="container" style="background-color: #ffffff; border-radius: 8px; padding: 20px; max-width: 600px; margin: 0 auto;">
    <h1 class="welcome" style="color: #333;">Welcome to Beat Believers!</h1>
    <p style="font-size: 16px; line-height: 1.5; color: #333;">{{ $content }}</p>
    <p style="font-size: 16px; line-height: 1.5; color: #333;">To complete your registration, please click the link below:</p>
    <a href="{{ $verificationLink }}" style="display: inline-block; padding: 10px 20px; margin-top: 20px; border-radius: 4px; background-color: #4a90e2; color: #ffffff; text-decoration: none; font-weight: bold;">Confirm Registration</a>
</div>

</body>
</html>
