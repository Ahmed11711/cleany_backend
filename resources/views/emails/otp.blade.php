<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>كود التحقق</title>
</head>
<body style="margin:0; padding:0; background:#F1EFE8; font-family: Arial, sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 16px;">
    <tr>
      <td align="center">
        <table width="480" cellpadding="0" cellspacing="0"
               style="background:#ffffff; border-radius:16px; overflow:hidden; border:1px solid #D3D1C7;">

          {{-- Header --}}
          <tr>
            <td style="background:#534AB7; padding:36px 32px; text-align:center;">
              <div style="width:48px; height:48px; border-radius:50%; background:rgba(255,255,255,0.15);
                          display:inline-flex; align-items:center; justify-content:center; margin-bottom:16px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"
                        fill="rgba(255,255,255,0.9)"/>
                </svg>
              </div>
              <p style="color:#EEEDFE; font-size:20px; font-weight:600; margin:0;">كود التحقق</p>
              <p style="color:#AFA9EC; font-size:13px; margin:8px 0 0;">Cleany — تحقق من هويتك</p>
            </td>
          </tr>

          {{-- Body --}}
          <tr>
            <td style="padding:36px 32px; text-align:center;">
              <p style="color:#5F5E5A; font-size:15px; line-height:1.7; margin:0 0 28px;">
                مرحباً! استخدم الكود أدناه للمتابعة.<br>
                لا تشارك هذا الكود مع أي شخص آخر.
              </p>

              {{-- OTP Box --}}
              <div style="background:#EEEDFE; border-radius:12px; padding:20px 32px; display:inline-block; margin-bottom:24px;">
                <p style="font-size:40px; font-weight:700; letter-spacing:14px;
                          color:#3C3489; margin:0; font-family:monospace;">
                  {{ $otp }}
                </p>
              </div>

              {{-- Timer note --}}
              <p style="color:#888780; font-size:13px; margin:0 0 28px;">
                ⏱ الكود صالح لمدة 10 دقائق فقط
              </p>

              <div style="border-top:1px solid #D3D1C7; padding-top:24px;">
                <p style="color:#B4B2A9; font-size:12px; line-height:1.7; margin:0;">
                  إذا لم تطلب هذا الكود، يمكنك تجاهل هذا البريد الإلكتروني بأمان.
                </p>
              </div>
            </td>
          </tr>

          {{-- Footer --}}
          <tr>
            <td style="background:#F1EFE8; padding:16px 32px; text-align:center;
                        border-top:1px solid #D3D1C7;">
              <p style="color:#888780; font-size:12px; margin:0;">
                © {{ date('Y') }} Cleany. جميع الحقوق محفوظة.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>