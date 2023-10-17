<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="/public/css/main.css?v=<?php echo time() ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="/public/bootstrap/js/bootstrap.js"></script>
    <script src="/public/ckeditor5/ckeditor.js"></script>
    <title>Voluntary Art Programs</title>
</head>

<body>


    <?php if (!isset($_COOKIE["lang"])) : ?>
        <?php include 'app/views/components/LanguageModal.php' ?>
    <?php else : ?>
        <?php include 'app/views/components/Alert.php' ?>
        <?php include 'includes/Navbar.php' ?>
        <div class="mt-5">
            <?= $params["content"] ?>
        </div>
    <?php endif ?>


    <script src="/public/js/CkEditor.js"></script>
    <script src="/public/js/Navbar.js"></script>
    <script src="/public/js/User.Documents.js"></script>
    <script src="/public/js/User.Languages.js"></script>
    <script src="/public/js/Event.Links.js"></script>
    <script src="/public/js/Event.Dates.js"></script>
    <script src="/public/js/AOS.js"></script>
    <script src="/public/js/MMParallax.js"></script>
</body>

</html>