<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin | Profile</title>

    <link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('font-awesome/css/font-awesome.css') ?>" rel="stylesheet">

    <link href="<?= base_url('css/animate.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">

</head>

<body>
<div id="wrapper">

    <!-- Sidebar menu -->
    <?php include app_path('includes/admin-sidebar.php'); ?>

    <div id="page-wrapper" class="gray-bg">

        <!-- Top bar -->
        <?php include app_path('includes/admin-topbar.php'); ?>

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Profile</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="../index.html">Home</a>
                    </li>
                    <li class="active">
                        <strong>Profile</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <div class="wrapper wrapper-content">
            <div class="row animated fadeInRight">
                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Your photo</h5>
                        </div>
                        <div>
                            <div class="ibox-content no-padding border-left-right">
                                <img alt="image" class="img-responsive" src="../../img/profile_big.jpg">
                                <input type="file">
                            </div>
                            <div class="ibox-content profile-content">
                                <h4><strong>Emri Mbiemri</strong></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Profile Data</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-sm-12 b-r"><h3 class="m-t-none m-b">Update your profile data here</h3>
                                    <form role="form">
                                        <div class="form-group"><label>Name</label>
                                            <input type="text"
                                                   placeholder="Enter name"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group"><label>Surname</label>
                                            <input type="text"
                                                   placeholder="Enter surname"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group"><label>Email</label>
                                            <input type="email"
                                                   placeholder="Enter email"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group"><label>Email</label>
                                            <input type="email"
                                                   placeholder="Enter email"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group"><label>Password</label>
                                            <input type="password"
                                                   placeholder="Password"
                                                   class="form-control">
                                        </div>
                                        <div>
                                            <button class="btn btn-xl btn-primary pull-left m-t-n-s" type="submit">
                                                <strong>Save</strong></button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!--                            <button class="btn btn-primary btn-block m"><i class="fa fa-arrow-down"></i> Update-->
                            <!--                            </button>-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="pull-right">
                10GB of <strong>250GB</strong> Free.
            </div>
            <div>
                <strong>Copyright</strong> Example Company &copy; 2014-2017
            </div>
        </div>

    </div>
</div>


<!-- Mainly scripts -->
<script src="../../js/jquery-3.1.1.min.js"></script>
<script src="../../js/bootstrap.js"></script>
<script src="../../js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="../../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="../../js/inspinia.js"></script>
<script src="../../js/plugins/pace/pace.min.js"></script>

<!-- Peity -->
<script src="../../js/plugins/peity/jquery.peity.min.js"></script>

<!-- Peity -->
<script src="../../js/demo/peity-demo.js"></script>

</body>

</html>