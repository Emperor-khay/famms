<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>{{ $title }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style type="text/css">
    body {
        background: rgb(204,204,204);
    }

    page[size="A4"] {
        background: #F5F6F7;
        width: 21cm;
        height: 29.7cm;
        display: block;
        margin: 0 auto;
        margin-bottom: 0.5cm;
        box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        border: 1.25cm solid #F5F6F7;
        font-family: 'Mallory', Arial, Verdana, Sans-serif;
    }

    @media print {
        body, page[size="A4"] {
            margin: 0;
            box-shadow: 0;
        }
    }

    .card {
        box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid rgba(0,0,0,.125);
        border-radius: 1rem;
    }

    .invoice-title {
        margin-bottom: 20px;
    }

    .text-muted a {
        text-decoration: none;
        color: inherit;
    }
</style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <h4 class="float-end font-size-15">Invoice #000{{ $order->id }} <span class="badge bg-success font-size-12 ms-2">{{ $order->payment_status }}</span></h4>
                            <div class="mb-4">
                                <h2 class="mb-1 text-muted">FAMMS</h2>
                            </div>
                            <div class="text-muted">
                                <p class="mb-1"><i class="bi bi-geo-alt me-1"></i>3184 Spruce Drive Pittsburgh, PA 15201</p>
                                <p class="mb-1"><i class="bi bi-envelope-at me-1"></i> <a href="mailto:empror.khay17@gmail.com">empror.khay17@gmail.com</a></p>
                                <p><i class="bi bi-telephone me-1"></i> 012-345-6789</p>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Billed To:</h5>
                                    <h5 class="font-size-15 mb-2">{{ $order->name }}</h5>
                                    <p class="mb-1">{{ $order->address }}</p>
                                    <p class="mb-1"><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
                                    <p>{{ $order->phone }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <div class="text-muted">
                                    <h5 class="font-size-15 mb-1">Invoice No:</h5>
                                    <p>#{{ $order->id }}</p>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                        <p>{{ $date }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Order No:</h5>
                                        <p>#{{ $order->id }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-2">
                            <h5 class="font-size-15">Order Summary</h5>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">No.</th>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th class="text-end" style="width: 120px;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>
                                                <div>
                                                    <h5 class="text-truncate font-size-14 mb-1">{{ $product->title }}</h5>
                                                    <p class="text-muted text-truncate mb-0">{{ $product->category }}</p>
                                                </div>
                                            </td>
                                            <td>$ {{ $product->price }}</td>
                                            <td>{{ $order->quantity }}</td>
                                            <td class="text-end">
                                                @php
                                                    $totalPrice = $product->price * $order->quantity;
                                                @endphp
                                                ${{ number_format($totalPrice, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">Discount :</th>
                                            @php
                                                $difference = 0;
                                            @endphp
                                            @if(isset($product->discount_price) && $product->discount_price)
                                                @php
                                                    $difference = $product->price - $product->discount_price;
                                                @endphp
                                                <td class="border-0 text-end">- ${{ number_format($difference * $order->quantity, 2) }}</td>
                                            @else
                                                <td class="border-0 text-end">None</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">Total</th>
                                            <td class="border-0 text-end">
                                                <h4 class="m-0 fw-semibold">
                                                    @php
                                                        $discountedTotal = $totalPrice;
                                                        if (isset($product->discount_price) && $product->discount_price) {
                                                            $discountedTotal = $totalPrice - ($difference * $order->quantity);
                                                        }
                                                    @endphp
                                                    ${{ number_format($discountedTotal, 2) }}
                                                </h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
