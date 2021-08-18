<?php $user = current_user(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>
    <?php if (!empty($page_title))
      echo remove_junk($page_title);
    elseif (!empty($user))
      echo ucfirst($user['name']);
    else echo "Gestión de Insumos"; ?>
  </title>

  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="libs/css/main.css" /> -->

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

  <link rel="stylesheet" href="libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" />

  <link rel="stylesheet" href="libs/css/main.css" />

</head>

<body>

  <?php if ($session->isUserLoggedIn(true)) : ?>
    <nav class="navbar navbar-inverse barraNav">
      <?php if ($user['user_level'] === '1') : ?>
        <!-- admin menu -->
        <?php include_once('admin_menu.php'); ?>

      <?php elseif ($user['user_level'] === '2') : ?>
        <!-- Special user -->
        <?php include_once('special_menu.php'); ?>

      <?php elseif ($user['user_level'] === '3') : ?>
        <!-- User menu -->
        <?php include_once('user_menu.php'); ?>

      <?php endif; ?>

    </nav>
  <?php endif; ?>

  <div class="page">
    <div class="container-fluid">