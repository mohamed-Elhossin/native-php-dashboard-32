<?php
include_once '../../shared/head.php';
include_once '../../shared/header.php';
include_once '../../shared/aside.php';
include_once '../../core/config.php';
include_once '../../core/functions.php';

$select = "SELECT * FROM users_all_data ";
$users = mysqli_query($connect, $select);


auth(2);

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>List Users
            <a class="float-end btn btn-info" href="./create.php">Create New</a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Datatables</h5>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>

                                    <th>Create_by</th>
                                    <th>View </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $item): ?>
                                    <tr>
                                        <th><?= $item['id'] ?></th>
                                        <th><?= $item['name'] ?></th>
                                        <th><?= $item['email'] ?></th>

                                        <?php if ($item['created_by'] == null): ?>
                                            <th>Super Admin</th>
                                        <?php else: ?>
                                            <th> <?= $item['created_by'] ?> </th>
                                        <?php endif; ?>
                                        <th> <a href="./view.php?view=<?= $item['id'] ?>"> View</a> </th>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->


<?php
include_once '../../shared/footer.php';
include_once '../../shared/script.php';
?>