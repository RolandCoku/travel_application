<?php

global $products;

echo "<pre>";
foreach ($products as $product) {
    print_r($product);
}
echo "</pre>";
?>

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

    <link href="<?= base_url('css/animate.css') ?>">
    <link href="<?= base_url('css/style.css') ?>">

    <link href="<?= base_url('font-awesome/css/font-awesome.css') ?>"  rel="stylesheet">

    <!-- Toastr style -->
    <link href="<?= base_url('css/plugins/toastr/toastr.min.css') ?>" rel="stylesheet">
</head>
<body class="white-bg">

<?php include app_path('includes/user-navbar.php'); ?>

<div class="container">

    <div class="row  wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10 pt-3">
            <h2>Product Category</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="home-page.php">Home</a>
                </li>
                <li>
                    <div class="separator px-2">/</div>
                </li>
                <li class="active">
                    <strong>Product Category</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">

                        <div class="product-imitation">
                            [ INFO ]
                        </div>
                        <div class="product-desc">
                                <span class="product-price">
                                    $10
                                </span>
                            <small class="text-muted">Category</small>
                            <a href="product-detail.php" class="product-name"> Product</a>


                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">

                                <a href="product-detail.php" class="btn btn-xs btn-outline btn-primary">Info <i
                                            class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">

                        <div class="product-imitation">
                            [ INFO ]
                        </div>
                        <div class="product-desc">
                                <span class="product-price">
                                    $10
                                </span>
                            <small class="text-muted">Category</small>
                            <a href="product-detail.php" class="product-name"> Product</a>


                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">

                                <a href="product-detail.php" class="btn btn-xs btn-outline btn-primary">Info <i
                                            class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">

                        <div class="product-imitation">
                            [ INFO ]
                        </div>
                        <div class="product-desc">
                                <span class="product-price">
                                    $10
                                </span>
                            <small class="text-muted">Category</small>
                            <a href="product-detail.php" class="product-name"> Product</a>


                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">

                                <a href="product-detail.php" class="btn btn-xs btn-outline btn-primary">Info <i
                                            class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">

                        <div class="product-imitation">
                            [ INFO ]
                        </div>
                        <div class="product-desc">
                                <span class="product-price">
                                    $10
                                </span>
                            <small class="text-muted">Category</small>
                            <a href="product-detail.php" class="product-name"> Product</a>


                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">

                                <a href="product-detail.php" class="btn btn-xs btn-outline btn-primary">Info <i
                                            class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">

                        <div class="product-imitation">
                            [ INFO ]
                        </div>
                        <div class="product-desc">
                                <span class="product-price">
                                    $10
                                </span>
                            <small class="text-muted">Category</small>
                            <a href="product-detail.php" class="product-name"> Product</a>


                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">

                                <a href="product-detail.php" class="btn btn-xs btn-outline btn-primary">Info <i
                                            class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">

                        <div class="product-imitation">
                            [ INFO ]
                        </div>
                        <div class="product-desc">
                                <span class="product-price">
                                    $10
                                </span>
                            <small class="text-muted">Category</small>
                            <a href="product-detail.php" class="product-name"> Product</a>


                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">

                                <a href="product-detail.php" class="btn btn-xs btn-outline btn-primary">Info <i
                                            class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">

                        <div class="product-imitation">
                            [ INFO ]
                        </div>
                        <div class="product-desc">
                                <span class="product-price">
                                    $10
                                </span>
                            <small class="text-muted">Category</small>
                            <a href="product-detail.php" class="product-name"> Product</a>


                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">

                                <a href="product-detail.php" class="btn btn-xs btn-outline btn-primary">Info <i
                                            class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">

                        <div class="product-imitation">
                            [ INFO ]
                        </div>
                        <div class="product-desc">
                                <span class="product-price">
                                    $10
                                </span>
                            <small class="text-muted">Category</small>
                            <a href="product-detail.php" class="product-name"> Product</a>


                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">

                                <a href="product-detail.php" class="btn btn-xs btn-outline btn-primary">Info <i
                                            class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">

                        <div class="product-imitation">
                            [ INFO ]
                        </div>
                        <div class="product-desc">
                                <span class="product-price">
                                    $10
                                </span>
                            <small class="text-muted">Category</small>
                            <a href="product-detail.php" class="product-name"> Product</a>


                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">

                                <a href="product-detail.php" class="btn btn-xs btn-outline btn-primary">Info <i
                                            class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">

                        <div class="product-imitation">
                            [ INFO ]
                        </div>
                        <div class="product-desc">
                                <span class="product-price">
                                    $10
                                </span>
                            <small class="text-muted">Category</small>
                            <a href="product-detail.php" class="product-name"> Product</a>


                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">

                                <a href="product-detail.php" class="btn btn-xs btn-outline btn-primary">Info <i
                                            class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">

                        <div class="product-imitation">
                            [ INFO ]
                        </div>
                        <div class="product-desc">
                                <span class="product-price">
                                    $10
                                </span>
                            <small class="text-muted">Category</small>
                            <a href="product-detail.php" class="product-name"> Product</a>


                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">

                                <a href="product-detail.php" class="btn btn-xs btn-outline btn-primary">Info <i
                                            class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">

                        <div class="product-imitation">
                            [ INFO ]
                        </div>
                        <div class="product-desc">
                                <span class="product-price">
                                    $10
                                </span>
                            <small class="text-muted">Category</small>
                            <a href="product-detail.php" class="product-name"> Product</a>


                            <div class="small m-t-xs">
                                Many desktop publishing packages and web page editors now.
                            </div>
                            <div class="m-t text-righ">

                                <a href="product-detail.php" class="btn btn-xs btn-outline btn-primary">Info <i
                                            class="fa fa-long-arrow-right"></i> </a>
                            </div>
                        </div>
                    </div>
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
</body>
</html>

