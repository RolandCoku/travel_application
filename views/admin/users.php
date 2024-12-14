<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin | User list</title>

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
            <div class="col-sm-4">
                <h2>Users</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="../../login.php">Admin</a>
                    </li>
                    <li class="active">
                        <strong>Users</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">

                    <div class="ibox">
                        <div class="ibox-content">
                            <!--                            <div class="row m-b-sm m-t-sm">-->
                            <!--                                <div class="col-md-1">-->
                            <!--                                    <button type="button" id="loading-example-btn" class="btn btn-white btn-sm" ><i class="fa fa-refresh"></i> Refresh</button>-->
                            <!--                                </div>-->
                            <!--                                <div class="col-md-11">-->
                            <!--                                    <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">-->
                            <!--                                        <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div>-->
                            <!--                                </div>-->
                            <!--                            </div>-->

                            <div class="float-e-margins">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Nr</th>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Test Emri</td>
                                        <td>Test Mbiemri</td>
                                        <td>test@test.com</td>
                                        <td><input type="button"  class="btn btn-warning" value="Edit"></td>
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>Test Emri</td>
                                        <td>Test Mbiemri</td>
                                        <td>test@test.com</td>
                                        <td><input type="button"  class="btn btn-warning" value="Edit"></td>
                                    </tr>

                                    <tr>
                                        <td>3</td>
                                        <td>Test Emri</td>
                                        <td>Test Mbiemri</td>
                                        <td>test@test.com</td>
                                        <td><input type="button"  class="btn btn-warning" value="Edit"></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
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
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="../../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="../../js/inspinia.js"></script>
<script src="../../js/plugins/pace/pace.min.js"></script>

<script>
    $(document).ready(function () {

        $('#loading-example-btn').click(function () {
            btn = $(this);
            simpleLoad(btn, true)

            // Ajax example
//                $.ajax().always(function () {
//                    simpleLoad($(this), false)
//                });

            simpleLoad(btn, false)
        });

    });

    function simpleLoad(btn, state) {
        if (state) {
            btn.children().addClass('fa-spin');
            btn.contents().last().replaceWith(" Loading");
        } else {
            setTimeout(function () {
                btn.children().removeClass('fa-spin');
                btn.contents().last().replaceWith(" Refresh");
            }, 2000);
        }
    }
</script>
</body>

</html>
