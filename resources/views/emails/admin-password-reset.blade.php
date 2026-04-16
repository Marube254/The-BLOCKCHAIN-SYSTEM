<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset - IUEA Voting System</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; border-top: 5px solid #8B0000;">
        <div style="text-align: center;">
            <img src="{{ asset('images/iuea-logo.png') }}" alt="IUEA Logo" style="height: 70px;">
            <h2 style="color: #8B0000; margin-top: 15px;">Password Reset Request</h2>
        </div>
        
        <p style="font-size: 16px; color: #333;">Hello <strong>{{ $name }}</strong>,</p>
        
        <p style="color: #555;">We received a request to reset your password for the IUEA Voting System Admin Panel.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $resetLink }}" style="background-color: #8B0000; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">
                Reset Password
            </a>
        </div>
        
        <p style="color: #555;">If the button doesn't work, copy and paste this link into your browser:</p>
        <p style="background: #f0f0f0; padding: 10px; word-break: break-all; font-size: 12px;">{{ $resetLink }}</p>
        
        <p style="color: #777; font-size: 12px;">This link will expire in 1 hour for security reasons.</p>
        
        <hr style="margin: 20px 0;">
        
        <p style="color: #999; font-size: 12px; text-align: center;">
            If you did not request this password reset, please ignore this email.<br>
            © 2026 IUEA Voting System. All rights reserved.
        </p>
    </div>
</body>
</html>