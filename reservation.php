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

if (!isset($_POST['DateTime'])) {
    header('Location: /');
    exit;
}

$reservation = array_filter($_POST);
$reservation["RestaurantSpecificFields"] = array_map(function($id, $value) {
                                                        return array("Id"=>$id, "Value"=>$value);
                                                    }
                                                    , array_keys( array_filter($_POST["RestaurantSpecificFields"]) )
                                                    , array_values( array_filter($_POST["RestaurantSpecificFields"]) )
                                            );

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

<div class="row">

    <?php
    try {
        list($reservation, $response) = $service->MakeReservation($reservation);
        ?>
            <div class="col-md-3 col-md-offset-2">
                <p><?= $response->ConfirmationText->$language ?></p>
            </div>

            <!--
                ================================
                BEGIN EXTRA INFO FOR DEVELOPMENT
                ================================
            -->
            <blockquote class="col-md-7">
                POST <code><?= CouvertsConstants::API_BASE_URL ?>/Reservation</code><br>
                <?php print_r( json_encode($reservation) ); ?><br>

                response
                <?php
                    var_dump($response);
                ?>
            </blockquote>
            <!--
                ==============================
                END EXTRA INFO FOR DEVELOPMENT
                ==============================
            -->

        <?php
    }
    catch (Exception $e) {
        ?>
            <div class="col-md-3 col-md-offset-2">
                <div class="alert alert-danger" role="alert">
                        <?= $e->getMessage() ?>
                </div>
            </div>

            <!--
                ================================
                BEGIN EXTRA INFO FOR DEVELOPMENT
                ================================
            -->
            <blockquote class="col-md-7">
                POST <code><?= CouvertsConstants::API_BASE_URL ?>/Reservation</code><br>
                <?php
                    var_dump( json_encode($reservation) );
                ?>
            </blockquote>
            <!--
                ==============================
                END EXTRA INFO FOR DEVELOPMENT
                ==============================
            -->

        <?php
    }
    ?>
</div>
<?php include 'footer.php' ?>
