<!-- resources/views/top_sale_products.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 8 Sale Products</title>
</head>
<body>
    <h1>Top 8 Sale Products 1</h1>
    <ul>
        @foreach($products as $product)
            <li>
                <h3>{{ $product->TenSP }}</h3>
                <p>Price: {{ $product->Gia }}</p>
                <p>Sale Percentage: {{ $product->PhanTramGiamGia }}</p>
                <p>Description: {{ $product->MoTa }}</p>
            </li>
        @endforeach
    </ul>
</body>
</html>

