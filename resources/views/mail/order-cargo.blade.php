<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Faturası</title>
</head>
<body>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Faturası</title>
</head>
<body>

<table border="0" width="600" cellspacing="0" cellpadding="0" align="center">
    <tbody>
    <tr>
        <td style="padding:40px 0;border:1px solid #f2f2f2;border-radius:5px" bgcolor="#fafafa">
            <table border="0" width="480" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                <tr>
                    <td style="line-height:1;color:#3c3c3c;font-size:21px;font-weight:600;font-family:'Open Sans',Helvetica,sans-serif" align="left">
                        <div><span>Sayın {{$data['name']}} Adlı Müşterimiz,</span></div>
                    </td>
                </tr>
                <tr>
                    <td height="30">&nbsp;</td>
                </tr>
                <tr>
                    <td style="line-height:1;color:#3c3c3c;font-size:18px;font-weight:600;font-family:'Open Sans',Helvetica,sans-serif" align="left">
                        <div><span>Siparişiniz Kargoya verilmiştir.</span></div>
                    </td>
                </tr>
                <tr>
                    <td height="25">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center"><img width="200" src="https://cdn-icons-png.flaticon.com/512/9457/9457484.png"></td>
                </tr>
                <tr>
                    <td style="line-height:1.8;color:#3c3c3c;font-size:16px;font-weight:400;font-family:'Open Sans',Helvetica,sans-serif" align="left">
                        <div><span><strong>{{$data['time']}}</strong> tarihinde oluşturulan <strong>#{{$data['code']}}</strong> numaralı Siparişiniz Kargoya verilmiştir kargo takip kodu için kargo firmasından gelen mesajı bekleyiniz.
                            <br>Kargo ulaşım süreci 1 ila 3 gün arasıdır<br>Bu süre içinde gelmeyen kargolarınız için kargo firmasına başvurunuz lütfen.</span></div>
                    </td>
                </tr>
                <tr>
                    <td height="25">&nbsp;</td>
                </tr>

                <tr>
                    <td style="line-height:1.8;color:#3c3c3c;font-size:16px;font-weight:400;font-family:'Open Sans',Helvetica,sans-serif" align="left">
                        <div><span> <strong>Sipariş Durumu:</strong> {{$data['shipment_status']}}.<br></span></div>
                    </td>
                </tr>
                <tr>
                    <td style="line-height:1.8;color:#3c3c3c;font-size:16px;font-weight:400;font-family:'Open Sans',Helvetica,sans-serif" align="left">
                        <div><span> <strong>Kargo Dahil Sipariş Tutarı:</strong> {{$data['total_price']}} TL.<br></span></div>
                    </td>
                </tr>
                <tr>
                    <td height="25">&nbsp;</td>
                </tr>
                <tr>
                    <td style="line-height:1.8;color:#3c3c3c;font-size:16px;font-weight:400;font-family:'Open Sans',Helvetica,sans-serif" align="left">
                        <div><span>Sipariş Faturası Ürünler ile birlikte gelecektir değişim ve iade için faturayı kullanınız.<br>İyi Günler Dilerim..</span></div>
                    </td>
                </tr>
                <tr>
                    <td height="50">&nbsp;</td>
                </tr>
                <tr>
                    <td style="line-height:1;color:#6a6a6a;font-style:italic;font-size:14px;font-weight:400;font-family:'Open Sans',Helvetica,sans-serif" align="center">
                        <div><span>Muhasebe Departmanı</span></div>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>


</body>
</html>
