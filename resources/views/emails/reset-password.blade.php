<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu - Vegetable Store</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;   
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 40px 20px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1f2937;
        }
        .message {
            font-size: 16px;
            margin-bottom: 30px;
            color: #4b5563;
        }
        .reset-button {
            display: inline-block;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        .reset-button:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
        }
        .warning {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            color: #92400e;
        }
        .warning-icon {
            color: #f59e0b;
            margin-right: 8px;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            border-top: 1px solid #e5e7eb;
        }
        .footer a {
            color: #10b981;
            text-decoration: none;
        }
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🥬 Vegetable Store</h1>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Đặt lại mật khẩu</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Xin chào!
            </div>

            <div class="message">
                Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn tại Vegetable Store.
            </div>

            <div style="text-align: center;">
                <a href="{{ $resetUrl }}" class="reset-button">
                    🔐 Đặt lại mật khẩu
                </a>
            </div>

            <div class="message">
                Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này. Mật khẩu của bạn sẽ không bị thay đổi.
            </div>

            <div class="warning">
                <strong>⚠️ Lưu ý quan trọng:</strong><br>
                • Link này chỉ có hiệu lực trong 60 phút<br>
                • Chỉ sử dụng được một lần<br>
                • Nếu không thể click vào link, hãy copy và paste vào trình duyệt
            </div>

            <div class="divider"></div>

            <div style="font-size: 14px; color: #6b7280;">
                <strong>Thông tin tài khoản:</strong><br>
                Email: {{ $email }}<br>
                Thời gian yêu cầu: {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                <strong>Vegetable Store</strong><br>
                Cửa hàng rau củ quả tươi ngon
            </p>
            <p>
                Nếu bạn cần hỗ trợ, vui lòng liên hệ:
                <a href="mailto:support@vegetable-store.com">support@vegetable-store.com</a>
            </p>
            <div class="divider"></div>
            <p style="font-size: 12px; margin: 0;">
                © {{ date('Y') }} Vegetable Store. Tất cả quyền được bảo lưu.
            </p>
        </div>
    </div>
</body>
</html>

