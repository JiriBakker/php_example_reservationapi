<?php
include_once "config.php";
require_once "Services/CouvertsReservationService.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /');
    exit;
}

if (!isset($_POST['NumPersons']) || !is_numeric($_POST['NumPersons'])) {
    header('Location: /');
    exit;
}

$numPersons = intval($_POST['NumPersons']);
if (!isset($_POST['date'])) {
    header('Location: /');
    exit;
}


$date = DateTime::createFromFormat('Y-m-d', $_POST['date']);
if ($date === FALSE || $date<new DateTime()) {
    header('Location: /');
    exit;
}

$service = new CouvertsReservationService(CouvertsConstants::RESTAURANT_ID, $language);
$basicInfo = $service->GetBasicInfo();
?>

<?php include 'header.php' ?>

    <div class="row">
        <div class="col-md-3 col-md-offset-2">
            <h1><?= $basicInfo->RestaurantName ?> <small><?= $basicInfo->RestaurantCity ?></small></h1>
        </div>

        <!--
            ================================
            BEGIN EXTRA INFO FOR DEVELOPMENT
            ================================
            in a live environment you would not call /BasicInfo on every page
        -->
        <blockquote class="col-md-7">
            GET <code><?= CouvertsConstants::API_BASE_URL ?>/BasicInfo</code>
        </blockquote>
        <!--
            ==============================
            END EXTRA INFO FOR DEVELOPMENT
            ==============================
        -->

    </div>

<?php

try {
    $times = $service->GetAvailableTimes($date, $numPersons);
?>
    <form action="fields.php" method="post" class="form-horizontal" role="form">

        <div class="form-group">
            <label for="time" class="control-label col-md-2">Select a Time</label>
            <div class="col-md-3">
                <select id="time" name="time" class="form-control">
                    <?php
                    foreach ($times->Times as $time) {
                        ?>
                        <option><?=sprintf("%02d", $time->Hours);?>:<?=sprintf("%02d", $time->Minutes);?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <!--
                ================================
                BEGIN EXTRA INFO FOR DEVELOPMENT
                ================================
            -->
            <blockquote class="col-md-7">
                GET <code><?= CouvertsConstants::API_BASE_URL ?>/AvailableTimes</code>
            </blockquote>
            <!--
                ==============================
                END EXTRA INFO FOR DEVELOPMENT
                ==============================
            -->

        </div>

        <div class="form-group">
            <div class="col-md-3 col-md-offset-2">
                <input type="submit" value="Submit" class="btn btn-default btn-block" />
            </div>
        </div>

        <div class="well">
            <div class="form-group">
                <label for="" class="control-label col-md-2">hidden fields</label>
                <div class="col-md-3">
                    date: <input type="text" class="form-control" id="date" name="date" placeholder="yyyy-mm-dd" value="<?= $date->format('Y-m-d') ?>" readonly >
                    persons: <input type="number" class="form-control" id="NumPersons" name="NumPersons" placeholder="2 Persons" value="<?= $numPersons ?>" readonly >
                </div>
            </div>
        </div>

    </form>

    <!--
        ================================
        BEGIN EXTRA INFO FOR DEVELOPMENT
        ================================
    -->
    <div class="well">
        <div class="row">
            <div class="col-md-2">
                full response GET <code><?= CouvertsConstants::API_BASE_URL ?>/AvailableTimes</code>
            </div>
            <div class="col-md-10"><?= var_dump($times) ?></div>
        </div>
    </div>
    <!--
        ==============================
        END EXTRA INFO FOR DEVELOPMENT
        ==============================
    -->

    <?php
}
catch (Exception $e) {
    $errMsg = $e->getMessage();
?>
    <div class="row">
        <div class="alert alert-danger col-md-3 col-md-offset-2" role="alert">
            <?= $errMsg ?>
        </div>

        <!--
            ================================
            BEGIN EXTRA INFO FOR DEVELOPMENT
            ================================
        -->
        <blockquote class="col-md-7">
            GET <code><?= CouvertsConstants::API_BASE_URL ?>/AvailableTimes</code>
        </blockquote>
        <!--
            ==============================
            END EXTRA INFO FOR DEVELOPMENT
            ==============================
        -->

    </div>
<?php
}
?>

<?php include 'footer.php' ?>