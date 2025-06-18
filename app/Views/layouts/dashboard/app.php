<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tektok Adventure adalah website penjualan alat-alat camping dan perlengkapan outdoor berkualitas. Temukan berbagai gear terbaik untuk petualangan alammu di sini!" />
    <meta name="author" content="Tektok Adventure" />
    <meta name="keywords" content="alat camping, perlengkapan camping, gear outdoor, peralatan hiking, tenda camping, kompor portable, sleeping bag, matras camping, petualangan alam, tektok adventure" />

    <title><?= $this->renderSection('page_title'); ?></title>

    <?= $this->include('layouts/dashboard/partials/links'); ?>
    <?= $this->renderSection('head_css'); ?>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <?= $this->include('layouts/dashboard/partials/sidebar'); ?>

        <!--  Main wrapper -->
        <div class="body-wrapper">

            <?= $this->include('layouts/dashboard/partials/header'); ?>

            <div class="body-wrapper-inner">
                <div class="container-fluid">
                    <div class="row">
                        <?= $this->renderSection('content'); ?>
                    </div>

                    <?= $this->include('layouts/dashboard/partials/footer'); ?>

                </div>
            </div>
        </div>
    </div>

    <?= $this->include('layouts/dashboard/partials/scripts'); ?>
    <?= $this->renderSection('foot_js'); ?>
</body>

</html>