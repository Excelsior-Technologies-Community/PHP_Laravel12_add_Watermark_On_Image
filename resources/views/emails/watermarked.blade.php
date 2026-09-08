<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Watermarked Image</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 10px; }
        h1 { color: #333; }
        p { color: #666; line-height: 1.6; }
        .footer { margin-top: 20px; font-size: 12px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Watermarked Image{{ count($images) > 1 ? 's' : '' }}</h1>

        <p>Hello,</p>

        <p>
            Your image{{ count($images) > 1 ? 's have' : ' has' }} been successfully watermarked.
            Please find the attachment{{ count($images) > 1 ? 's' : '' }} with this email.
        </p>

        <p>
            <strong>Total Images:</strong> {{ count($images) }}
        </p>

        <div class="footer">
            <p>
                This email was sent from the Image Watermark Tool.
            </p>
        </div>
    </div>
</body>
</html>
