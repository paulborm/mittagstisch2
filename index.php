<?php 

    $str    = file_get_contents('data/mittagstische.json');
    $json   = json_decode($str, true); // decode the JSON into an associative array


    $restaurants = $json["restaurants"];
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

        <?php foreach($restaurants as $restaurant) : ?>
            Verfügbare Restaurants: <?php echo $restaurant["name"]; ?>
        <?php endforeach; ?>


        <div class="card-container">


            <?php foreach($restaurants as $restaurant) : ?>
            <!-- Card -->
            <div class="card">
                <div class="card__inner">

                    <div class="card__header">
                        <h3 class="card__title card__title--1 inline">
                            <?php echo $restaurant["name"]; ?>    
                        </h3>

                        <?php if ($restaurant["standort"]) : ?>
                        <div class="card__address inline icon icon--location">
                            <?php echo $restaurant["standort"]; ?>
                        </div>
                        <?php endif; ?>

                    </div>

                    <?php foreach($restaurant["datum"] as $datum) : ?>
                        <p>Angebote von: <span class="is-correct icon icon--correct"><?php echo $datum["von"]; ?> - <?php echo $datum["bis"]; ?></span></p>
                    <?php endforeach; ?>


                    <!-- Meals -->
                    <div class="meals">

                        <?php foreach($restaurant["tage"] as $tag) : ?>
                        <!-- Meals Item -->
                        <div class="meals__item <?php if($tag['marked']) : ?>is-marked<?php endif; ?>">
                            <div class="meals__date">
                                <?php echo $tag["name"] . ", " . $tag["datum"]; ?>
                            </div>


                            <?php foreach($tag["gerichte"] as $gericht) : ?>
                            <!-- Meals Item-Row -->
                            <div class="meals__item-row">
                                <div class="meals__col">
                                    <div class="meals__title"><?php echo $gericht["name"]; ?></div>
                                    <div class="meals__text"><?php echo $gericht["beschreibung"]; ?></div>
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


                </div>
            </div>
            <!-- Card End -->
            <?php endforeach; ?>


        </div>


    </body>
</html>
