<?php

require_once('lib/autoload.php');

use terrain\Terrain;
use terrain\generation\TerrainGenerator;
use terrain\generation\TerrainGeneratorOptions;

use visualizing\TerrainToImage;

$options = new TerrainGeneratorOptions();
$options->import($_GET);

$generator = new TerrainGenerator($options);
$terrain = $generator->generate();

//echo ($terrain->toJson());

$imageGen = new TerrainToImage($terrain);
$imageGen->mapPropertyToColValue('single', 'red', 1);
$image = $imageGen->getImage();

header('content-type: image/png');
imagepng($image);