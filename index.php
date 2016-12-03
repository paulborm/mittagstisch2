<?php 
    require_once("logic.php");

    // Get Data from Data File
    $str    = file_get_contents('data/mittagstische.json');
    $json   = json_decode($str, true); // decode the JSON into an associative array

    $restaurants = $json["restaurants"];


    // Get the first day of the current week
    $firstDayOfWeek = firstDayOf('week');

    // Get the last day of the current week
    $lastDayOfWeek = lastDayOf('week');

?>

<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <title>Mittagstisch</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.7.1.min.js"></script>
    </head>
    <body>

        <div class="top-bar">
            <?php echo date("l n. M"); ?>
        </div>

        <p>Verfügbare Restaurants: </p>
        <ul>
            <?php foreach($restaurants as $restaurant) : ?>
                <?php echo "<li>" . $restaurant["name"] . "</li>"; ?>
            <?php endforeach; ?>
        </ul>

        <div class="card-container">


            <?php foreach($restaurants as $restaurant) : ?>
            <!-- Card -->
            <div class="card">
                <div class="card__inner">

                    <div class="card__header">

                        <?php if (!$restaurant["logo"]) : ?>
                        <h3 class="card__title card__title--1 inline">
                            <?php echo $restaurant["name"]; ?>    
                        </h3>
                        <?php else : ?>
                        <img class="card__logo" src="<?php echo $restaurant['logo']; ?>" />
                        <?php endif; ?>

                        <?php if ($restaurant["standort"]) : ?>
                        <div class="card__address inline icon icon--location">
                            <?php echo $restaurant["standort"]; ?>
                        </div>
                        <?php endif; ?>

                    </div>



                    <?php 
                    // Alert nur einblednden wenn es auch Gerichte gibt

                    if($restaurant["tage"]) : ?>

                        <?php foreach($restaurant["datum"] as $datum) : ?>

                            <?php if($datum["von"] == $firstDayOfWeek && $datum["bis"] == $lastDayOfWeek) : ?>
                                <div class="alert alert--correct">
                                    <span class="alert__title">Alles aktuell</span>
                                    <span class="icon icon--correct">
                            <?php else : ?>
                                <div class="alert alert--wrong">
                                    <span class="alert__title">Nicht aktuell</span>
                            <?php endif; ?>
                                    <?php echo $datum["von"]; ?> - <?php echo $datum["bis"]; ?>
                                </span>
                            </div>

                        <?php endforeach; ?>

                    <?php else : ?>
                        <div class="alert alert--notice">Nichts los...</div>
                    <?php endif; ?>



                    <?php 
                    // Wenn es Gerichte gibt, werden diese hier angezeigt

                    if($restaurant["tage"]) : ?>

                        <!-- Meals -->
                        <div class="meals">


                            <?php foreach($restaurant["tage"] as $tag) : ?>
                            <!-- Meals Item -->
                            <div class="meals__item <?php if($tag['marked']) : ?>is-marked<?php endif; ?>">
                                <div class="meals__day">
                                    <?php echo $tag["name"] /*. ", " . $tag["datum"]*/; ?>
                                </div>


                                <?php foreach($tag["gerichte"] as $gericht) : ?>
                                <!-- Meals Item-Row -->
                                <div class="meals__item-row">
                                    <div class="meals__col">
                                        <div class="meals__title"><?php echo $gericht["name"]; ?></div>

                                        <?php if ($gericht["beschreibung"]) : ?>
                                        <div class="meals__text"><?php echo $gericht["beschreibung"]; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="meals__col">
                                        <div class="meals__cost"><?php echo $gericht["preis"] . " €"; ?></div>
                                    </div>
                                </div>
                                <!-- Meals Item-Row End -->
                                <?php endforeach; ?>


                            </div>
                            <!-- Meals Item End -->
                            <?php endforeach; ?>


                        </div>
                        <!-- Meals End -->

                    <?php endif; ?>



                </div>
            </div>
            <!-- Card End -->
            <?php endforeach; ?>


        </div>


    </body>
</html>
