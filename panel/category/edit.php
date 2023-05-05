<?php
require_once "../../functions/helpers.php";
require_once "../../functions/pdo_connection.php";
require_once('../../functions/auth.php');


if(!isset($_GET['cat_id']))
{
        redirect('panel/category');
}

$sql = "SELECT * FROM categories WHERE id = ?";
$statement = $pdo->prepare($sql);
$statement->execute([$_GET["cat_id"]]);
$category = $statement->fetch();
if($category === false){
        redirect('panel/category');
}

if(isset($_POST['name']) && $_POST['name'] !== '')
{

        $sql = "UPDATE categories SET `name` = ?, updated_at = now() WHERE id = ? ;";
        $statement = $pdo->prepare($sql);
        $statement->execute([$_POST['name'], $_GET['cat_id']]);
        redirect('panel/category');
}







?>
<!DOCTYPE html>
<html lang="en">
<?php require_once "../layouts/head-tag.php"; ?>

<body>
        <section id="app">

                <?php require_once "../layouts/top-nav.php"; ?>


                <section class="container-fluid">
                        <section class="row">
                                <section class="col-md-2 p-0">
                                        <?php require_once "../layouts/sidebar.php"; ?>
                                </section>
                                <section class="col-md-10 pt-3">

                 <form action="<?= url('panel/category/edit.php?cat_id=' . $_GET['cat_id']) ?>" method="post">
                                                <section class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" value="<?= $category->name ?>" class="form-control" name="name" id="name" placeholder="name ...">
                                                </section>
                                                <section class="form-group">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                </section>
                                        </form>

                                </section>
                        </section>
                </section>

        </section>

        <?php require_once "../layouts/script.php"; ?>
</body>

</html>
