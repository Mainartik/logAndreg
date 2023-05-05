<?php
require_once('../../functions/helpers.php');
require_once('../../functions/pdo_connection.php');
require_once('../../functions/auth.php');


        if(!isset($_GET['post_id']))
        {
                redirect('panel/post');
        }

        $sql = "SELECT * FROM posts WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$_GET['post_id']]);
        $post = $statement->fetch();
        if($post === false)
        {
                redirect('panel/post');
        }

if(isset($_POST['title']) && $_POST['title'] !== '' 
&& isset($_POST['cat_id']) && $_POST['cat_id'] !== ''
&& isset($_POST['body']) && $_POST['body'] !== '')
{
        $sql = "SELECT * FROM categories WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$_POST["cat_id"]]);
        $category = $statement->fetch();

        if (isset($_FILES['image']) && $_FILES['image']['name'] !== '') {
            $allowedMimes = ['png', 'jpg', 'gif', 'jpeg'];
            $imageMime = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            if (!in_array($imageMime, $allowedMimes)) {
                redirect('panel/post');
            }
            $basePath = dirname(dirname(__DIR__));
            if (file_exists($basePath . $post->image)) {
                unlink($basePath . $post->image);
            }
            $image = '/assets/images/posts/' . date('Y_m_d_H_i_s') . '.' . $imageMime;
            $image_upload = move_uploaded_file($_FILES['image']['tmp_name'], $basePath . $image);

     
            if ($category !== false && $image_upload !== false) {
                $sql = "UPDATE  posts SET title = ?, cat_id = ?, body = ?, image = ?, updated_at = now() WHERE id = ?";
                $statement = $pdo->prepare($sql);
                $statement->execute([$_POST['title'], $_POST['cat_id'], $_POST['body'], $image, $_GET['post_id']]);
                redirect('panel/post');
            }
        }
        else{
                if ($category !== false) {
                        $sql = "UPDATE  posts SET title = ?, cat_id = ?, body = ?, updated_at = now() WHERE id = ?";
                        $statement = $pdo->prepare($sql);
                        $statement->execute([$_POST['title'], $_POST['cat_id'], $_POST['body'], $_GET['post_id']]);
                        redirect('panel/post');
                    }
        }
        redirect('panel/post');
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

                <form action="<?= url('panel/post/edit.php?post_id=' . $_GET['post_id']) ?>" method="post" enctype="multipart/form-data">
                    <section class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="<?= $post->title ?>">
                    </section>
                    <section class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        <img src="<?= asset($post->image) ?>" alt="" width="150" height="150">
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

                                <option value="<?= $category->id ?>" <?php if($category->id == $post->cat_id) echo 'selected' ?> >
                                        <?= $category->name ?>
                                </option>

                                <?php } ?>
                        </select>
                    </section>
                    <section class="form-group">
                        <label for="body">Body</label>
                        <textarea class="form-control" name="body" id="body" rows="5" ><?= $post->body ?></textarea>
                    </section>
                    <section class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
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