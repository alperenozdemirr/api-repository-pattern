<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Faturası</title>
</head>
<body>

<div style="font-family: 'Arial', sans-serif; margin: 20px;">
    <div style="text-align: center; margin-bottom: 20px;">
        <h1 style="color: black;">Sipariş Faturası</h1>
    </div>

    <div style="margin-bottom: 20px;">
        <p><strong>Sipariş Numarası:</strong> #{{$data['order_number']}}</p>
        <p><strong>Tarih:</strong> {{$data['time']}}</p>
        <p><strong>Sipariş Durumu:</strong>{{$data['order_status']}}</p>
    </div>

    <div style="margin-bottom: 20px;padding-left:30px;background-color: #ddd; display: flex; justify-content: space-between;">

        <div style="width: 48%;">
            <h2>Teslimat Adresi</h2>
            <p><strong>Başlık:</strong> {{$address->title}}</p>
            <p><strong>Adres:</strong> {{$address->address}}</p>
            <p><strong>Şehir:</strong> {{$address->city->name}}</p>
        </div>

        <div style="width: 48%;">
            <h2>Fatura Adresi</h2>
            <p><strong>Başlık:</strong> {{$invoice->title}}</p>
            <p><strong>Adres:</strong> {{$invoice->address}}</p>
            <p><strong>Şehir:</strong> {{$invoice->city->name}}</p>
        </div>

    </div>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
        <tr>
            <th style="border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Ürün Adı</th>
            <th style="border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Fiyat</th>
            <th style="border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Adet</th>
            <th style="border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Toplam</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">{{$product->products->name}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">{{$product->product_price}} TL</td>
            <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">{{$product->product_amount}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">{{$product->product_price * $product->product_amount}} TL</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; text-align: right;">
        <p><strong>Kargo Ücreti:</strong> {{$data['shipping_cost']}} TL</p>
        <p><strong>Toplam Fiyat:</strong> {{$data['total_price']}} TL</p>
    </div>
</div>

</body>
</html>
