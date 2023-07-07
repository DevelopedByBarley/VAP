<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="/public/css/main.css?v=<?php echo time() ?>" />
    <script src="/public/bootstrap/js/bootstrap.js"></script>
    <title>VAP</title>
</head>

<body>
    <div id="VAP-app" style="max-width: 3500px; margin: 0 auto;" >
        <?php include 'includes/Navbar.php' ?>

        <div class="container-fluid">
            <div class="row mb-5">
                <div class="col-xs-12 p-0 d-flex align-items-center justify-content-center flex-column" style="min-height: 79vh">
                    <?= $params["content"] ?? "" ?>
                </div>
            </div>
        </div>
        <?php //include 'includes/Footer.php' 
        ?>

    </div>
    <script src="/public/js/Navbar.js"></script>
</body>

</html>