<?php
if (!isset($_COOKIE["lang"])) {
    header('Location: /');
};

// Include SEO configuration
require_once 'config/seo.php';

$title = $params['title'] ?? '';
$nav = $params['nav'] ?? null;
$lang = isset($_COOKIE["lang"]) ? $_COOKIE["lang"] : "En";

// SEO Meta Data
$page_title = $title !== '' ? $title . ' - ' . SEO["meta"]["title"][$lang] : SEO["meta"]["title"][$lang];
$meta_description = SEO["meta"]["description"][$lang];
$meta_keywords = SEO["meta"]["keywords"][$lang];
$og_title = SEO["meta"]["og_title"][$lang];
$og_description = SEO["meta"]["og_description"][$lang];
$canonical_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<!DOCTYPE html>
<html lang="<?= $lang === 'Hu' ? 'hu' : ($lang === 'En' ? 'en' : 'es') ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($meta_keywords) ?>">
    <meta name="author" content="Volunteer Art Programs">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= htmlspecialchars($canonical_url) ?>">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= htmlspecialchars($og_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($og_description) ?>">
    <meta property="og:image" content="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" ?>/public/assets/icons/logo.png">
    <meta property="og:url" content="<?= htmlspecialchars($canonical_url) ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="<?= $lang === 'Hu' ? 'hu_HU' : ($lang === 'En' ? 'en_US' : 'es_ES') ?>">
    <meta property="og:site_name" content="Volunteer Art Programs">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($og_title) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($og_description) ?>">
    <meta name="twitter:image" content="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" ?>/public/assets/icons/logo.png">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/public/assets/icons/logo.png">
    <link rel="apple-touch-icon" href="/public/assets/icons/logo.png">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/public/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="/public/css/main.css?v=<?php echo time() ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- SimpleLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplelightbox@2.14.2/dist/simple-lightbox.min.css">
    
    <!-- Scripts -->
    <script src="/public/bootstrap/js/bootstrap.js"></script>
    <script src="/public/ckeditor5/ckeditor.js"></script>
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "<?= SEO["structured_data"]["organization"]["name"] ?>",
      "url": "<?= SEO["structured_data"]["organization"]["url"] ?>",
      "logo": "<?= SEO["structured_data"]["organization"]["logo"] ?>",
      "description": "<?= SEO["structured_data"]["organization"]["description"][$lang] ?>",
      "sameAs": <?= json_encode(SEO["structured_data"]["organization"]["sameAs"]) ?>
    }
    </script>

</head>

<body>
    <?php include 'app/views/components/Alert.php' ?>
    <?php include 'includes/Navbar.php' ?>
    <?php if (isset($nav)) : ?>
        <div style="margin-top: 150px" class="mx-3 mx-lg-5">
            <a class="link text-dark" href="<?= $nav['link'] ?>"><?= $nav['slug'] ?></a>
        </div>
    <?php endif ?>
    <div class="mt-5 w-100" id="root">
        <?= $params["content"] ?>
    </div>

    <?php include 'app/views/components/Cookie.php' ?>
    <?php include './app/views/includes/Footer.php' ?>

    <script src="/public/js/UUID.js"></script>
    <script src="/public/js/CkEditor.js"></script>
    <script src="/public/js/Navbar.js"></script>
    <script src="/public/js/AOS.js"></script>
    <script src="/public/js/MMParallax.js"></script>
    <script src="/public/js/Cookie.js"></script>
    <!-- SimpleLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/simplelightbox@2.14.2/dist/simple-lightbox.min.js"></script>
    <script src="/public/js/Lightbox.js"></script>
</body>

</html>