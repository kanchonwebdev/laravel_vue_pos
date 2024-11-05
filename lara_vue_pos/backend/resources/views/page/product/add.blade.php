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
                <form class="row g-3 p-4 border mt-2" method="POST" enctype="multipart/form-data"
                    action="{{ route('product.store') }}">
                    @csrf
                    <div class="col-12">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="col-md-6">
                        <label for="price" class="form-label">Product Price</label>
                        <input type="number" class="form-control" name="price" id="price">
                    </div>
                    <div class="col-md-6">
                        <label for="qty" class="form-label">Product Quantity</label>
                        <input type="number" class="form-control" name="qty" id="qty">
                    </div>
                    <div class="col-md-6">
                        <label for="sku" class="form-label">SKU</label>
                        <input type="number" class="form-control" name="sku" value="{{ rand() . time() }}" id="sku">
                    </div>
                    <div class="col-md-6">
                        <label for="max_order" class="form-label">Max Order</label>
                        <input type="text" class="form-control" name="max_order" id="max_order">
                    </div>
                    <div class="col-md-6">
                        <label for="unit" class="form-label">Unit</label>
                        <select id="unit" name="unit" class="form-select">
                            <option value="Litter">Litter</option>
                            <option value="KG">KG</option>
                            <option value="PC">PC</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="category" class="form-label">Category</label>
                        <select id="category" name="category" class="form-select">
                            <option>Baby Sofa</option>
                            <option>Men Shirt</option>
                            <option>Milk Powder</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="promo_code" class="form-label">Promo Code</label>
                        <input type="text" class="form-control" name="promo_code" id="promo_code"
                            placeholder="Promo code">
                    </div>

                    <div class="col-md-12">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                    <div class="col-12">
                        <label for="desc" class="form-label">Product Description</label>
                        <textarea class="form-control" id="desc" name="desc" cols="10" rows="5"></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary form-control">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS Files --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
