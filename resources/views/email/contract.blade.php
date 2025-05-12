<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contract Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            padding: 40px 0;
            color: #333;
        }
        .wrapper {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        .header {
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }
        .logo {
            width: 80px;
            margin-bottom: 10px;
        }
        .content {
            padding: 30px;
        }
        h1 {
            font-size: 22px;
            color: #1a202c;
        }
        p {
            line-height: 1.6;
            margin: 16px 0;
            font-size: 15px;
        }
        .button {
            display: inline-block;
            margin: 25px 0;
            background-color: #00a896;
            color: #ffffff !important;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #718096;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <img src="https://i.imgur.com/23Q8lZE.png" alt="Stak Logo" class="logo">
            <h1 style="font-size: 24px; font-weight: bold; color: #2d3748; margin: 0;">Your Contract Form</h1>
            <p style="font-size: 14px; color: #4a5568; margin-top: 8px;">Please review and complete the form below.</p>
        </div>
        <div class="content">
            <p>Hello!</p>
            <p>Please click the button below to access your contract form:</p>
            <p style="text-align: center;">
                <a href="{{ $contractLink }}" class="button">View Contract</a>
            </p>
            <p>This link will expire in 7 days.</p>
            <p>If you did not request this contract, you can safely ignore this email.</p>
        </div>
    </div>
</body>
</html>
