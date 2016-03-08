<?php
include_once "config.php";
require_once "Services/CouvertsReservationService.php";


$service = new CouvertsReservationService(CouvertsConstants::RESTAURANT_ID, $language);
$basicInfo = $service->GetBasicInfo();

?>

<?php include 'header.php' ?>

<div class="row">
    <div class="col-md-3 col-md-offset-2">
        <h1><?= $basicInfo->RestaurantName ?> <small><?= $basicInfo->RestaurantCity ?></small></h1>
        <p><?= $basicInfo->IntroText->$language ?></p>
    </div>
    <blockquote class="col-md-7">
        GET <code><?= CouvertsConstants::API_BASE_URL ?>/BasicInfo</code>
        <?php var_dump($basicInfo); ?>
    </blockquote>
</div>

<div class="row">
    <form action="availableTimes.php" method="post" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="control-label col-md-2" for="date">Date:</label>
            <div class="col-md-3">
                <input type="text" class="form-control" id="date" name="date" placeholder="yyyy-mm-dd" value="<?= strftime("%Y-%m-%d") ?>">
            </div>


            <!--
                ================================
                BEGIN EXTRA INFO FOR DEVELOPMENT
                ================================
            -->
            <blockquote class="col-md-7">
                post format: yyyy-mm-dd
            </blockquote>
            <!--
                ==============================
                END EXTRA INFO FOR DEVELOPMENT
                ==============================
            -->

        </div>
        <div class="form-group">
            <label class="control-label col-md-2" for="NumPersons">Number of persons:</label>
            <div class="col-md-3">
                <input type="number" class="form-control" id="NumPersons" name="NumPersons" placeholder="2 Persons" required>
            </div>

            <!--
                ================================
                BEGIN EXTRA INFO FOR DEVELOPMENT
                ================================
            -->
            <blockquote class="col-md-7">
                post: integer
            </blockquote>
            <!--
                ==============================
                END EXTRA INFO FOR DEVELOPMENT
                ==============================
            -->

        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-3">
                <input type="submit" value="Submit" class="btn btn-default btn-block"/>
            </div>
        </div>
    </form>
</div>

<?php include 'footer.php' ?>
