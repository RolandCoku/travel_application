<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    <link href="<?= base_url('css/animate.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">

    <link href="<?= base_url('font-awesome/css/font-awesome.css') ?>"  rel="stylesheet">


    <!-- Toastr style -->
    <link href="<?= base_url('css/plugins/toastr/toastr.min.css') ?>" rel="stylesheet">

    <!-- slick carousel-->
    <link href="<?= base_url('css/plugins/slick/slick.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/plugins/slick/slick-theme.css') ?>" rel="stylesheet">
</head>
<body class="white-bg">
<?php include app_path('includes/user-navbar.php'); ?>

<div class="container">

    <div class="row  wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10 pt-3">
            <h2>Product name</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="home-page.php">Home</a>
                </li>
                <li>
                    <div class="separator px-2">/</div>
                </li>
                <li class="active">
                    <a href="product-page.php">Product-Category</a>
                </li>
                <li>
                    <div class="separator px-2">/</div>
                </li>
                <li class="active">
                    <strong>Product name</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="ibox product-detail">
                <div class="ibox-content">

                    <div class="row">
                        <div class="col-md-5">


                            <div class="product-images">

                                <div>
                                    <div class="image-imitation">
                                        [IMAGE 1]
                                    </div>
                                </div>
                                <div>
                                    <div class="image-imitation">
                                        [IMAGE 2]
                                    </div>
                                </div>
                                <div>
                                    <div class="image-imitation">
                                        [IMAGE 3]
                                    </div>
                                </div>


                            </div>

                        </div>
                        <div class="col-md-7">

                            <h2 class="font-bold m-b-xs">
                                Desktop publishing software
                            </h2>
                            <small>Many desktop publishing packages and web page editors now.</small>
                            <div class="m-t-md">
                                <h2 class="product-main-price">$406,602 <small class="text-muted">Exclude
                                        Tax</small></h2>
                            </div>
                            <hr>

                            <h4>Product description</h4>

                            <div class="small text-muted">
                                It is a long established fact that a reader will be distracted by the readable
                                content of a page when looking at its layout. The point of using Lorem Ipsum is

                                <br/>
                                <br/>
                                There are many variations of passages of Lorem Ipsum available, but the majority
                                have suffered alteration in some form, by injected humour, or randomised words
                                which don't look even slightly believable.
                            </div>
                            <dl class="small m-t-md">
                                <dt>Description lists</dt>
                                <dd>A description list is perfect for defining terms.</dd>
                                <dt>Euismod</dt>
                                <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec
                                    elit.
                                </dd>
                                <dd>Donec id elit non mi porta gravida at eget metus.</dd>
                                <dt>Malesuada porta</dt>
                                <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
                            </dl>
                            <hr>

                            <div>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-cart-plus"></i> Add to
                                        cart
                                    </button>
                                    <button class="btn btn-white btn-sm"><i class="fa fa-star"></i> Add to wishlist
                                    </button>
                                    <button class="btn btn-white btn-sm"><i class="fa fa-envelope"></i> Contact with
                                        author
                                    </button>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
                <div class="ibox-footer">
                            <span class="pull-right">
                                Full stock - <i class="fa fa-clock-o"></i> 14.04.2016 10:04 pm
                            </span>
                    The generated Lorem Ipsum is therefore always free
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Mainly scripts -->
<script src="../../js/jquery-3.1.1.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="../../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="../../js/inspinia.js"></script>
<script src="../../js/plugins/pace/pace.min.js"></script>

<!-- slick carousel-->
<script src="../../js/plugins/slick/slick.min.js"></script>

<script>
    $(document).ready(function(){

        $('.product-images').slick({
            dots: true
        });

    });
</script>

</body>
</html>