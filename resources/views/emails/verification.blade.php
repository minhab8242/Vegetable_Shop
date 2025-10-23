<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực tài khoản - Vegetable Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .button {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 20px 0;
        }
        .button:hover {
            background: #059669;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Vegetable Store</div>
        <p>Rau củ quả tươi ngon</p>
    </div>

    <div class="content">
        <h2>Chào mừng {{ $user->full_name }}!</h2>

        <p>Cảm ơn bạn đã đăng ký tài khoản tại <strong>Vegetable Store</strong>. Để hoàn tất quá trình đăng ký và kích hoạt tài khoản, vui lòng xác thực địa chỉ email của bạn.</p>

        <p>Nhấn vào nút bên dưới để xác thực tài khoản:</p>

        <div style="text-align: center;">
            <a href="{{ $verificationUrl }}" class="button">
                Xác thực tài khoản
            </a>
        </div>

        <p><strong>Lưu ý:</strong></p>
        <ul>
            <li>Link xác thực có hiệu lực trong 24 giờ</li>
            <li>Nếu bạn không thực hiện đăng ký này, vui lòng bỏ qua email này</li>
            <li>Để bảo mật, không chia sẻ link xác thực với bất kỳ ai</li>
        </ul>

        <p>Nếu nút không hoạt động, bạn có thể copy và paste link sau vào trình duyệt:</p>
        <p style="word-break: break-all; background: #f3f4f6; padding: 10px; border-radius: 5px; font-family: monospace;">
            {{ $verificationUrl }}
        </p>

        <p>Chúc bạn có những trải nghiệm mua sắm tuyệt vời tại Vegetable Store!</p>

        <p>Trân trọng,<br>
        <strong>Đội ngũ Vegetable Store</strong></p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} Vegetable Store. Tất cả quyền được bảo lưu.</p>
        <p>Email này được gửi tự động, vui lòng không trả lời.</p>
    </div>
</body>
</html>

