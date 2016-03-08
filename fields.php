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

if (!isset($_POST['date']) || !isset($_POST['time'])) {
    header('Location: /');
    exit;
}

$date = DateTime::createFromFormat('Y-m-d H:i', $_POST['date'] ." ". $_POST['time']);
if ($date === FALSE) {
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

    <!--
        ================================
        BEGIN EXTRA INFO FOR DEVELOPMENT
        ================================
    -->
    <div class="row">
        <blockquote class="col-md-7 col-md-offset-5">
            GET <code><?= CouvertsConstants::API_BASE_URL ?>/InputFields</code>
        </blockquote>
    </div>
    <!--
        ==============================
        END EXTRA INFO FOR DEVELOPMENT
        ==============================
    -->

<?php
try {
    $inputFields = $service->GetInputFields($date);
    ?>
    <form action="reservation.php" method="post" class="form-horizontal" role="form">

        <div class="form-group">
            <?php if ($inputFields->Gender->Show): ?>
                <label for="" class="col-md-2 control-label">Gender<?= $inputFields->Gender->Required ? " *" : "" ?></label>
                <div class="col-md-3">
                    <label class="radio-inline">
                        <input type="radio" name="Gender" id="Gender-Male" value="Male" <?= $inputFields->Gender->Required ? " required" : "" ?>> Male
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="Gender" id="Gender-Female" value="Female"> Female
                    </label>
                </div>
            <?php else: ?>

                <!--
                    ================================
                    BEGIN EXTRA INFO FOR DEVELOPMENT
                    ================================
                -->
                <div class="col-md-3 col-md-offset-2">
                    Formfield Gender->Show is <code>false</code>, so not needed
                </div>
                <!--
                    ==============================
                    END EXTRA INFO FOR DEVELOPMENT
                    ==============================
                -->


            <?php endif; ?>

            <!--
                ================================
                BEGIN EXTRA INFO FOR DEVELOPMENT
                ================================
            -->
            <div class="col-md-7">
                partial response GET <code>/InputFields</code>:
                <?php var_dump($inputFields->Gender); ?>
            </div>
            <!--
                ==============================
                END EXTRA INFO FOR DEVELOPMENT
                ==============================
            -->

        </div>

        <div class="form-group">
            <?php if ($inputFields->FirstName->Show): ?>
                <label for="FirstName" class="col-md-2 control-label">First Name<?= $inputFields->FirstName->Required ? " *" : "" ?></label>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="first name" value=""<?= $inputFields->FirstName->Required ? " required" : "" ?>>
                </div>
            <?php else: ?>

                <!--
                    ================================
                    BEGIN EXTRA INFO FOR DEVELOPMENT
                    ================================
                -->
                <div class="col-md-3 col-md-offset-2">
                    Formfield FirstName->Show is <code>false</code>, so not needed
                </div>
                <!--
                    ==============================
                    END EXTRA INFO FOR DEVELOPMENT
                    ==============================
                -->

            <?php endif; ?>

            <!--
                ================================
                BEGIN EXTRA INFO FOR DEVELOPMENT
                ================================
            -->
            <div class="col-md-7">
                partial response GET <code>/InputFields</code>:
                <?php var_dump($inputFields->FirstName); ?>
            </div>
            <!--
                ==============================
                END EXTRA INFO FOR DEVELOPMENT
                ==============================
            -->

        </div>

        <div class="form-group">
            <?php if ($inputFields->LastName->Show): ?>
                <label for="LastName" class="col-md-2 control-label">Last Name<?= $inputFields->LastName->Required ? " *" : "" ?></label>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="LastName" name="LastName" placeholder="last name" value="" <?= $inputFields->LastName->Required ? " required" : "" ?>>
                </div>
            <?php else: ?>

                <!--
                    ================================
                    BEGIN EXTRA INFO FOR DEVELOPMENT
                    ================================
                -->
                <div class="col-md-3 col-md-offset-2">
                    Formfield LastName->Show is <code>false</code>, so not needed
                </div>
                <!--
                    ==============================
                    END EXTRA INFO FOR DEVELOPMENT
                    ==============================
                -->

            <?php endif; ?>

            <!--
                ================================
                BEGIN EXTRA INFO FOR DEVELOPMENT
                ================================
            -->
            <div class="col-md-7">
                partial response GET <code>/InputFields</code>:
                <?php var_dump($inputFields->LastName); ?>
            </div>
            <!--
                ==============================
                END EXTRA INFO FOR DEVELOPMENT
                ==============================
            -->

        </div>

        <div class="form-group">
            <?php if ($inputFields->Email->Show): ?>
                <label for="Email" class="col-md-2 control-label">Email<?= $inputFields->Email->Required ? " *" : "" ?></label>
                <div class="col-md-3">
                    <input type="email" class="form-control" id="Email" name="Email" placeholder="email address" value="" <?= $inputFields->Email->Required ? " required" : "" ?>>
                </div>
            <?php else: ?>

                <!--
                    ================================
                    BEGIN EXTRA INFO FOR DEVELOPMENT
                    ================================
                -->
                <div class="col-md-3 col-md-offset-2">
                    Formfield Email->Show is <code>false</code>, so not needed
                </div>
                <!--
                    ==============================
                    END EXTRA INFO FOR DEVELOPMENT
                    ==============================
                -->

            <?php endif; ?>

            <!--
                ================================
                BEGIN EXTRA INFO FOR DEVELOPMENT
                ================================
            -->
            <div class="col-md-7">
                partial response GET <code>/InputFields</code>:
                <?php var_dump($inputFields->Email); ?>
            </div>
            <!--
                ==============================
                END EXTRA INFO FOR DEVELOPMENT
                ==============================
            -->

        </div>

        <div class="form-group">
            <?php if ($inputFields->PhoneNumber->Show): ?>
                <label for="PhoneNumber" class="col-md-2 control-label">Phone Number<?= $inputFields->PhoneNumber->Required ? " *" : "" ?></label>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="PhoneNumber" name="PhoneNumber" placeholder="phone number" value="" <?= $inputFields->PhoneNumber->Required ? " required" : "" ?>>
                </div>
            <?php else: ?>

                <!--
                    ================================
                    BEGIN EXTRA INFO FOR DEVELOPMENT
                    ================================
                -->
                <div class="col-md-3 col-md-offset-2">
                    Formfield PhoneNumber->Show is <code>false</code>, so not needed
                </div>
                <!--
                    ==============================
                    END EXTRA INFO FOR DEVELOPMENT
                    ==============================
                -->

            <?php endif; ?>

            <!--
                ================================
                BEGIN EXTRA INFO FOR DEVELOPMENT
                ================================
            -->
            <div class="col-md-7">
                partial response GET <code>/InputFields</code>:
                <?php var_dump($inputFields->PhoneNumber); ?>
            </div>
            <!--
                ==============================
                END EXTRA INFO FOR DEVELOPMENT
                ==============================
            -->

        </div>

        <div class="form-group">
            <?php if ($inputFields->PostalCode->Show): ?>
                <label for="PostalCode" class="col-md-2 control-label">Postal Code<?= $inputFields->PostalCode->Required ? " *" : "" ?></label>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="PostalCode" name="PostalCode" placeholder="postal code" value="" <?= $inputFields->PostalCode->Required ? " required" : "" ?>>
                </div>
            <?php else: ?>

                <!--
                    ================================
                    BEGIN EXTRA INFO FOR DEVELOPMENT
                    ================================
                -->
                <div class="col-md-3 col-md-offset-2">
                    Formfield PostalCode->Show is <code>false</code>, so not needed
                </div>
                <!--
                    ==============================
                    END EXTRA INFO FOR DEVELOPMENT
                    ==============================
                -->

            <?php endif; ?>

            <!--
                ================================
                BEGIN EXTRA INFO FOR DEVELOPMENT
                ================================
            -->
            <div class="col-md-7">
                partial response GET <code>/InputFields</code>:
                <?php var_dump($inputFields->PostalCode); ?>
            </div>
            <!--
                ==============================
                END EXTRA INFO FOR DEVELOPMENT
                ==============================
            -->

        </div>

        <div class="form-group">
            <?php if ($inputFields->BirthDate->Show): ?>
                <label for="BirthDate" class="col-md-2 control-label">Birth Date<?= $inputFields->BirthDate->Required ? " *" : "" ?></label>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="BirthDate" name="BirthDate" placeholder="birth date yyyy-mm-dd" value="" <?= $inputFields->BirthDate->Required ? " required" : "" ?>>
                </div>
            <?php else: ?>

                <!--
                    ================================
                    BEGIN EXTRA INFO FOR DEVELOPMENT
                    ================================
                -->
                <div class="col-md-3 col-md-offset-2">
                    Formfield BirthDate->Show is <code>false</code>, so not needed
                </div>
                <!--
                    ==============================
                    END EXTRA INFO FOR DEVELOPMENT
                    ==============================
                -->

            <?php endif; ?>

            <!--
                ================================
                BEGIN EXTRA INFO FOR DEVELOPMENT
                ================================
            -->
            <div class="col-md-7">
                partial response GET <code>/InputFields</code>:
                <?php var_dump($inputFields->BirthDate); ?>
            </div>
            <!--
                ==============================
                END EXTRA INFO FOR DEVELOPMENT
                ==============================
            -->

        </div>

        <div class="form-group">
            <?php if ($inputFields->Comments->Show): ?>
                <label for="Comments" class="col-md-2 control-label">Comments<?= $inputFields->Comments->Required ? " *" : "" ?></label>
                <div class="col-md-3">
                    <textarea class="form-control" rows="5" id="Comments" name="Comments" placeholder="comments"<?= $inputFields->Comments->Required ? " required" : "" ?>></textarea>
                </div>
            <?php else: ?>

                <!--
                    ================================
                    BEGIN EXTRA INFO FOR DEVELOPMENT
                    ================================
                -->
                <div class="col-md-3 col-md-offset-2">
                    Formfield Comments->Show is <code>false</code>, so not needed
                </div>
                <!--
                    ==============================
                    END EXTRA INFO FOR DEVELOPMENT
                    ==============================
                -->

            <?php endif; ?>

            <!--
                ================================
                BEGIN EXTRA INFO FOR DEVELOPMENT
                ================================
            -->
            <div class="col-md-7">
                partial response GET <code>/InputFields</code>:
                <?php var_dump($inputFields->Comments); ?>
            </div>
            <!--
                ==============================
                END EXTRA INFO FOR DEVELOPMENT
                ==============================
            -->

        </div>

        <h2>Restaurant Specific Fields</h2>

        <?php foreach ($inputFields->RestaurantSpecificFields AS $field) : ?>
        <div class="form-group">
            <?php if ($field->Type=="Text"): ?>
                <label for="<?= $field->Id ?>" class="col-md-2 control-label"><?= $field->Title->$language ?><?= $field->Required ? " *" : "" ?></label>
                <div class="col-md-3">
                    <textarea class="form-control" rows="5" id="<?= $field->Id ?>" name="RestaurantSpecificFields[<?= $field->Id ?>]"
                              placeholder="<?= $field->Description->$language ?>"<?= $field->Required ? " required" : "" ?>></textarea>
                </div>
            <?php elseif ($field->Type=="Number"): ?>
                <label for="<?= $field->Id ?>" class="col-md-2 control-label"><?= $field->Title->$language ?><?= $field->Required ? " *" : "" ?></label>
                <div class="col-md-3">
                    <input type="number" class="form-control" id="<?= $field->Id ?>" name="<?= $field->Id ?>" placeholder="<?= $field->Description->$language ?>"<?= $field->Required ? " required" : "" ?>>
                </div>
            <?php elseif ($field->Type=="Checkbox"): ?>
                <div class="col-md-3 col-md-offset-2">
                    <div class="checkbox">
                        <label><input type="checkbox" name="RestaurantSpecificFields[<?= $field->Id ?>]"> <?= $field->Title->$language ?><?= $field->Required ? " *" : "" ?></label>
                    </div>
                    <p class="help-block"><?= $field->Description->$language ?></p>
                </div>
            <?php endif; ?>

            <!--
                ================================
                BEGIN EXTRA INFO FOR DEVELOPMENT
                ================================
            -->
            <div class="col-md-7">
                partial response GET <code>/InputFields</code>:
                <?php var_dump($field); ?>
            </div>
            <!--
                ==============================
                END EXTRA INFO FOR DEVELOPMENT
                ==============================
            -->

        </div>
        <?php endforeach; ?>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-3">
                <input type="submit" value="Submit" class="btn btn-default btn-block"/>
            </div>
        </div>

        <div class="well">
            <div class="form-group">
                <div class="col-md-2">hidden fields:</div>
                <div class="col-md-10">
                    dateTime: <input type="text" class="form-control" id="DateTime" name="DateTime" placeholder="" value="<?= $date->format('Y-m-d H:i') ?>" readonly >
                    numPersons: <input type="number" class="form-control" id="NumPersons" name="NumPersons" placeholder="2 Persons" value="<?= $numPersons ?>" readonly >
                    Language: <input type="text" class="form-control" id="Language" name="Language" placeholder="English" value="<?= $language ?>" readonly >
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
            <div class="col-md-2">full response GET <code><?= CouvertsConstants::API_BASE_URL ?>/InputFields</code></div>
            <div class="col-md-10"><?= var_dump($inputFields) ?></div>
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
            GET <code><?= CouvertsConstants::API_BASE_URL ?>/InputFields</code>
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