<!DOCTYPE html>
<html>
<head>
    <title>Your Order Details</title>
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your order!</p>
    <p>Order ID: {{ $order->MaDonHang }}</p>
    <p>Order Date: {{ $order->NgayDat }}</p>
    <p>Total Price: {{ $order->TongGia }}</p>
    <p>Shipping Fee: {{ $order->PhiVanChuyen }}</p>
    <p>Payment Status: {{ $order->TrangThaiThanhToan }}</p>
    <p>Delivery Address: {{ $order->DiaChiGiaoHang }}</p>
    <p>Recipient Phone: {{ $order->RecipientPhone }}</p>
    
    <h2>Order Details</h2>
    <ul>
        @foreach($order->orderDetails as $detail)
            <li>{{ $detail->SoLuong }} x {{ $detail->productDetails->product->TenSanPham }} - {{ $detail->Gia }}</li>
        @endforeach
    </ul>
</body>
</html>
