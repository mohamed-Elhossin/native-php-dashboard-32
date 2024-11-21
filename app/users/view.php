<?php
include_once '../../shared/head.php';
include_once '../../shared/header.php';
include_once '../../shared/aside.php';
include_once '../../core/config.php';
include_once '../../core/functions.php';

auth();
if (isset($_GET['view'])) {

    $id = $_GET['view'];
    $select = "SELECT * FROM users_all_data  where id=$id  ";
    $users = mysqli_query($connect, $select);
    $row =  mysqli_fetch_assoc($users);
}

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
            <div class="col-lg-6">

                <div class="card">
                    <img width="400" src="<?= URL("app/users/upload/") . $row['image'] ?>" alt="">
                    <div class="card-body">
                        <h5 class="card-title">name : <?= $row['name'] ?></h5>
                        <hr>
                        <h5 class="card-title">email : <?= $row['email'] ?></h5>
                        <hr>
                        <h5 class="card-title">rule_number : <?= $row['rule_number'] ?></h5>
                        <hr>
                        <h5 class="card-title">description : <?= $row['description'] ?></h5>
                        <hr>
                        <h5 class="card-title">created_by : <?php if ($row['created_by'] == null): ?>
                                <span class="text-success"> Super Admin</span>
                            <?php else:   echo $row['created_by']; ?>
                        </h5>
                    <?php endif;
                    ?>
                    <hr>

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