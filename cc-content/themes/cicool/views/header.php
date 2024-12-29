<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= get_option('site_description'); ?>">
    <meta name="keywords" content="<?= get_option('keywords'); ?>">
    <meta name="author" content="<?= get_option('author'); ?>">

    <title> <?= isset($title) ? $title : site_name() ?></title>

    <!-- <link href="<?= theme_asset() ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= theme_asset() ?>vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?= theme_asset() ?>vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link href="<?= theme_asset() ?>css/creative.css" rel="stylesheet">
    <link href="<?= theme_asset() ?>css/style.css" rel="stylesheet"> -->

       <!-- Google Web Fonts -->
       <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?= theme_asset() ?>vendor/animate/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= theme_asset(); ?>vendor/sweet-alert/sweetalert2.css">
    <link href="<?= theme_asset() ?>vendor/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= theme_asset() ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?= theme_asset() ?>css/style.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="<?= BASE_ASSET ?>admin-lte/plugins/morris/morris.css">
    <link rel="stylesheet" href="<?= BASE_ASSET ?>flag-icon/css/flag-icon.css" rel="stylesheet" media="all" /> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="<?= theme_asset() ?>vendor/jquery/jquery.min.js"></script>

</head>