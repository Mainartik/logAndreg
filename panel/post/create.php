<?php
require_once('../../functions/helpers.php');
require_once('../../functions/pdo_connection.php');
require_once('../../functions/auth.php');


if(isset($_POST['title']) && $_POST['title'] !== '' 
&& isset($_POST['cat_id']) && $_POST['cat_id'] !== ''
&& isset($_POST['body']) && $_POST['body'] !== ''
&& isset($_FILES['image']) && $_FILES['image']['name'] !== '')
{
        $sql = "SELECT * FROM categories WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$_POST["cat_id"]]);
        $category = $statement->fetch();

        $allowedMimes = ['png', 'jpg', 'gif', 'jpeg'];
        $imageMime = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if(!in_array($imageMime, $allowedMimes))
        {
                redirect('panel/post');
        }

        $basePath = dirname(dirname(__DIR__));
        $image = '/assets/images/posts/' . date('Y_m_d_H_i_s') . '.' . $imageMime;
        $image_upload = move_uploaded_file($_FILES['image']['tmp_name'], $basePath . $image);
        if($category !== false && $image_upload !== false)
        {

                $sql = "INSERT INTO posts SET title = ?, cat_id = ?, body = ?, image = ?, created_at = now()";
                $statement = $pdo->prepare($sql);
                $statement->execute([$_POST['title'], $_POST['cat_id'], $_POST['body'], $image]);
                redirect('panel/post');

        }
}


?>
<!DOCTYPE html>
<html lang="en">
<?php
require_once('../layouts/head-tag.php');
?>
<body>
<section id="app">

<?php require_once('../layouts/top-nav.php') ?>


    <section class="container-fluid">
        <section class="row">
            <section class="col-md-2 p-0">
            <?php require_once('../layouts/sidebar.php') ?>

            </section>
            <section class="col-md-10 pt-3">

                <form action="<?= url('panel/post/create.php') ?>" method="post" enctype="multipart/form-data">
                    <section class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="title ...">
                    </section>
                    <section class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </section>
                    <section class="form-group">
                        <label for="cat_id">Category</label>
                        <select class="form-control" name="cat_id" id="cat_id">
                        <?php
                        $sql = "SELECT * FROM categories";
                        $statement = $pdo->prepare($sql);
                        $statement->execute();
                        $categories = $statement->fetchAll();
                        foreach($categories as $category){  ?>

                                <option value="<?= $category->id ?>">
                                        <?= $category->name ?>
                                </option>

                                <?php } ?>
                        </select>
                    </section>
                    <section class="form-group">
                        <label for="body">Body</label>
                        <textarea class="form-control" name="body" id="body" rows="5" placeholder="body ..."></textarea>
                    </section>
                    <section class="form-group">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </section>
                </form>

            </section>
        </section>
    </section>

</section>
<?php
require_once('../layouts/script.php');
?>
</body>
</html>