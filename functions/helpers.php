<?php


//configuration
define('BASE_URL', 'http://localhost/project-php');

function redirect($url) 
{
        header('Location: ' . trim(BASE_URL, '/ ') . '/' . trim($url, '/ '));
        exit;
}

// redirect('login.php');

function asset($file)
{
        return trim(BASE_URL, '/') . '/' . trim($file, '/ ');
}

// echo asset('assets/style.css');

function url($url)
{
        return trim(BASE_URL, '/') . '/' . trim($url, '/ ');
}

// echo url('create.php');


function dd($var)
{
        var_dump($var);
        exit;
}
// dd('hassan');