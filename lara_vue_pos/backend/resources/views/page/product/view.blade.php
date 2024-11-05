<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Homepage - POS Dashbaord</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>

    <div class="container-fluid">
        @include('extend.header')
        <div class="row">
            @include('extend.sidebar')
            <div class="col-md-10">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{asset($collection->image)}}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h1 class="card-title">{{$collection->name}}</h1>
                                <p><b>Price:</b> {{$collection->price}}</p>
                                <p><b>Quantity:</b> {{$collection->qty}}</p>
                                <p><b>SKU:</b> {{$collection->sku}}</p>
                                <p><b>Maximum Order:</b> {{$collection->max_order}}</p>
                                <p><b>Unit:</b> {{$collection->unit}}</p>
                                <p><b>Category:</b> {{$collection->category}}</p>
                                <p><b>Promo Code:</b> {{$collection->promo_code}}</p>
                                <p><b>Description:</b> {{$collection->desc}}</p>
                                <p class="card-text"><a href="{{route('product.edit', $collection->id)}}">Update Product</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS Files --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
