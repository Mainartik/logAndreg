<?php

require_once "../../functions/helpers.php";
require_once "../../functions/pdo_connection.php";
require_once('../../functions/auth.php');


        if(isset($_GET['post_id']) && $_GET['post_id'] !== '')
        {
                $sql = "SELECT * FROM posts WHERE id = ? ";
                $statement = $pdo->prepare($sql);
                $statement->execute([$_GET['post_id']]);
                $post = $statement->fetch();
                // if($post !== false){
                //         if($post->status == 10){
                //                 $status = 0;
                //         }
                //         else{
                //                 $status = 10;
                //         }
                // }
                $status = ($post->status == 10) ? 0 : 10;
                $sql = 'UPDATE posts SET status = ? WHERE id = ?';
                $statement = $pdo->prepare($sql);
                $statement->execute([$status, $_GET['post_id']]);
               
        }
        redirect('panel/post');


?>