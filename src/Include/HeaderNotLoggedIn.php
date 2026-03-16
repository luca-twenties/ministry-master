<?php

use ChurchCRM\dto\SystemConfig;
use ChurchCRM\dto\SystemURLs;

require_once __DIR__ . '/Header-Security.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

    <!-- Core ChurchCRM bundle (includes jQuery) -->
    <script src="<?= SystemURLs::assetVersioned('/skin/v2/churchcrm.min.js') ?>"></script>
    <link rel="stylesheet" href="<?= SystemURLs::assetVersioned('/skin/v2/churchcrm.min.css') ?>">

    <script src="<?= SystemURLs::assetVersioned('/skin/external/moment/moment.min.js') ?>"></script>

    <title>ChurchCRM: <?= $sPageTitle ?></title>

</head>
<body class="hold-transition login-page">

  <script nonce="<?= SystemURLs::getCSPNonce() ?>"  >
    // Initialize window.CRM if not already created by webpack bundles
    if (!window.CRM) {
        window.CRM = {};
    }
    
    // Extend window.CRM with server-side configuration (preserving existing properties like notify)
    Object.assign(window.CRM, {
      root: "<?= SystemURLs::getRootPath() ?>",
      churchWebSite:"<?= SystemConfig::getValue('sChurchWebSite') ?>"
    });
  </script>
