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
                <div class="row">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Image</th>
                            <th scope="col">Available Quantity</th>
                            <th scope="col">Return Quantity</th>
                            <th scope="col">Sales Quantity</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <img src="{{ asset($item->image) }}" style="width: 100px" height="100px" alt="">
                                </td>
                                <td>{{ $item->qty }}</td>
                                <td>0</td>
                                <td>0</td>
                                <td class="text-center">
                                    <a href="{{ route('product.view', $item->id) }}"
                                        class="btn btn-info text-white">View Product</a>
                                    <a href="{{ route('product.edit', $item->id) }}"
                                        class="btn btn-success text-white">Update Product</a>
                                    <a href="{{ route('product.destroy', $item->id) }}"
                                        class="btn btn-danger text-white">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS Files --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
