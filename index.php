<?php

require_once('lib/autoload.php');

use terrain\Terrain;
use terrain\generation\TerrainGenerator;

use visualizing\TerrainToImage;

$generator = new TerrainGenerator($_GET);
$terrain = $generator->generate();

//echo ($terrain->toJson());

$imageGen = new TerrainToImage($terrain);
$imageGen->mapPropertyToColValue('single', 'red', 1);
$imageGen->mapPropertyToColValue('object', 'blue', 1);
$image = $imageGen->getImage();

header('content-type: image/png');
imagepng($image);