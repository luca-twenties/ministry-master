<?php

use ChurchCRM\dto\SystemURLs;

?>
<title>ChurchCRM: <?= $sPageTitle ?></title>

<link rel="icon" href="<?= SystemURLs::getRootPath() ?>/favicon-ministrymaster.ico" type="image/x-icon">

<style>
@import url('https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&display=swap');
.unifrakturmaguntia-regular {
  font-family: "UnifrakturMaguntia", cursive;
  font-weight: 400;
  font-style: normal;
}
</style>

<link rel="stylesheet" href="<?= SystemURLs::assetVersioned('/skin/external/bootstrap-datepicker/bootstrap-datepicker.standalone.min.css') ?>">
<link rel="stylesheet" href="<?= SystemURLs::assetVersioned('/skin/external/bootstrap-daterangepicker/daterangepicker.css') ?>">
<link rel="stylesheet" href="<?= SystemURLs::assetVersioned('/skin/external/datatables/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= SystemURLs::assetVersioned('/skin/external/datatables/buttons.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= SystemURLs::assetVersioned('/skin/external/datatables/responsive.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= SystemURLs::assetVersioned('/skin/external/datatables/select.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= SystemURLs::assetVersioned('/skin/external/select2/select2.min.css') ?>">
<link rel="stylesheet" href="<?= SystemURLs::assetVersioned('/skin/external/adminlte/adminlte.min.css') ?>">
<link rel="stylesheet" href="<?= SystemURLs::assetVersioned('/skin/external/bs-stepper/bs-stepper.min.css') ?>">

<!-- Font Awesome + Bootstrap bundle from v2 (icons + base components) -->
<link rel="stylesheet" href="<?= SystemURLs::assetVersioned('/skin/v2/setup.min.css') ?>">

<!-- Custom ChurchCRM styles -->
<link rel="stylesheet" href="<?= SystemURLs::assetVersioned('/skin/v2/churchcrm.min.css') ?>">

<!-- Core ChurchCRM bundle (includes jQuery) -->
<script src="<?= SystemURLs::assetVersioned('/skin/v2/churchcrm.min.js') ?>"></script>

<script src="<?= SystemURLs::assetVersioned('/skin/external/moment/moment.min.js') ?>"></script>
