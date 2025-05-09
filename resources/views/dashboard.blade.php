<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="{{asset('build/assets/image/Application Logo.jpg')}}" type="image/jpg">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Bootstrap Icons CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

        
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
            .backgroundLoarding {
                position: fixed; /* Fixes it to the full window */
                top: 0;
                left: 0;
                background: #80808024;
                width: 100%;
                height: 100%; /* Full page height */
                display: none;
                z-index: 9999;
            }
            .backgroundLoarding img {
                position: absolute;
                top: 50%;
                left: 50%;
                z-index: 99999;
                transform: translate(-50%, -50%);
            }
            body.dark-mode  div{
                background: black !important;
                color: white !important;
            }

            .card-body p{
                background: #d3d3d33d;
                padding: 10px;
                border-radius: 10px;
                color: cornflowerblue;
                height: 140px;
            }
        </style>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script type="text/javascript">

            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });


            $(document).ajaxError(function(event,jqxhr,settings){
                $('.spinner-border').hide();
                if(jqxhr.status==500){
                    swal.fire({
                        icon:'error',
                        text:'A server error occurred. Please refresh the page and try again.',
                        allowotsideClick:false,
                    })
                }else if(jqxhr.status==419){
                    swal.fire({
                        icon:'error',
                        text:'Something went wrong. Please contact the administrator.',
                        allowotsideClick:false,
                    })
                }else{
                    swal.fire({
                        icon:'error',
                        text:jqxhr.responseJSON.message,
                        allowotsideClick:false,
                    })
                }
            })
        </script>

    </head>
    <body class="font-sans antialiased">
        <div class="backgroundLoarding">
            <img src="{{asset('build/assets/image/Loeading Screen.gif')}}"/>
        </div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('navigation')

            <!-- Page Content -->
            <main class="p-3">
                <div class="row">
                    <div class="col-12 col-lg-4 col-md-12">
                        <div class="card mt-3 p-2" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                            <div class="card-title"><h5>Fetching all products with more than 10 stock.</h5></div>
                            <hr>
                            <div class="card-body p-0">
                                <h6>Eloquent Query</h6>
                                <p>
                                    $stock=(isset($request->stock))?$request->stock:10;
                                    $getProductData = products::where('stock', '>', $stock)->get();
                                </p>
                                <button class="btn btn-primary" onclick="DisplayOutput('getProduct')">Run</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 col-md-12">
                        <div class="card mt-3 p-2"  style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                            <div class="card-title"><h5>Fetching all orders placed by a specific user</h5></div>
                            <hr>
                            <div class="card-body p-0">
                                <h6>Eloquent Query</h6>
                                <p>
                                    $user_id=(isset($request->user_id))?$request->user_id:1;
                                    $getOrderData = orders::with('user')->where('user_id', '=', $user_id)->get();
                                </p>
                                <button class="btn btn-primary"  onclick="DisplayOutput('getOrderData')">Run</button>
                            </div>
                        </div>
                    </div>    
                    <div class="col-12 col-lg-4 col-md-12">
                        <div class="card mt-3 p-2"  style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                            <div class="card-title"> <h5>Updating product stock after an order is placed</h5></div>
                            <hr>
                            <div class="card-body p-0">
                                <h6>Eloquent Query</h6>
                                <p>
                                    $order = orders::with('items.product')->findOrFail($orderId);
                                    <span class="d-block">
                                    foreach ($order->items as $item) {
                                        $product = $item->product;
                                        $product->stock -= $item->quantity;
                                        $product->stock = ($product->stock<=0)?0:$product->stock;
                                        $product->save();
                                    }
                                    <span>
                                </p>
                                <button class="btn btn-primary"  onclick="DisplayOutput('UpdateProductStock')">Run</button>
                            </div>
                        </div>
                    </div>
                </div>   

                <div class="card QueryOutput mt-3 p-3"  style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                    <h1>Query Output List</h1>
                    <hr>
                    <div class="w-100 text-center">
                        <div class="spinner-border text-secondary" role="status" style="padding: 20px;font-size: 50px;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="QueryData"></div>
                </div>
            </main>
            
            @include('footer');
        </div>
    </body>
    <script type="text/javascript">
        $('.backgroundLoarding,.spinner-border').hide();
        function DisplayOutput(url){
            $('.QueryData').html('');
            $('.spinner-border').show();
            $.ajax({
                type:'post',
                url:url,
                data:{},
                success:function(response){
                    $('.spinner-border').hide();
                    $('.QueryData').html(response);
                    $('#QueryListOutput').DataTable();
                }
            })
        }
    </script>
</html>
