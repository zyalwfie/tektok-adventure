<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Tektok Adventure adalah website penjualan alat-alat camping dan perlengkapan outdoor berkualitas. Temukan berbagai gear terbaik untuk petualangan alammu di sini!" />
    <meta name="author" content="Tektok Adventure" />
    <meta name="keywords" content="alat camping, perlengkapan camping, gear outdoor, peralatan hiking, tenda camping, kompor portable, sleeping bag, matras camping, petualangan alam, tektok adventure" />

    <title><?= $this->renderSection('page_title'); ?></title>

    <?= $this->include('layouts/landing/partials/links') ?>

    <?= $this->renderSection('head_css'); ?>

</head>

<body id="index-page">
    <?= $this->include('layouts/landing/partials/header') ?>

    <main class="main">
        <?= $this->renderSection('content'); ?>
    </main>

    <?= $this->include('layouts/landing/partials/footer') ?>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <?= $this->include('layouts/landing/partials/scripts'); ?>

</body>

</html>