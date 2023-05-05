<?php
require_once('../functions/helpers.php');
require_once('../functions/auth.php');

?>
<!DOCTYPE html>
<html lang="en">
<?php
require_once('layouts/head-tag.php');
?>
<body>
<section id="app">

<?php require_once('layouts/top-nav.php') ?>



    <section class="container-fluid">
        <section class="row">
            <section class="col-md-2 p-0">
                    <?php require_once('layouts/sidebar.php') ?>
            </section>
            <section class="col-md-10 pb-3">

                <section style="min-height: 80vh;" class="d-flex justify-content-center align-items-center">
                    <section>
                        <h1>PHP Tutorial</h1>
                        <ul class="mt-2 li">
                            <li><h3>PDO Connection</h3></li>
                            <li><h3>File upload</h3></li>
                            <li><h3>Blog (categories and posts)</h3></li>
                        </ul>
                    </section>
                </section>

            </section>
        </section>
    </section>


</section>
<?php
require_once('layouts/script.php');
?>
</body>
</html>