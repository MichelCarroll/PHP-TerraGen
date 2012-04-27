<?php

require_once('lib/autoload.php');

use terrain\Terrain;
use terrain\generation\TerrainGenerator;

use visualizing\TerrainToImage;

$generator = new TerrainGenerator($_REQUEST);
$terrain = $generator->generate();

$format = (isset($_REQUEST['format'])?$_REQUEST['format']:'');

switch($format)
{
  case 'preview':
    
    $imageGen = new TerrainToImage($terrain);
    $imageGen->mapPropertyToColValue('single', 'red', 1);
    $imageGen->mapPropertyToColValue('object', 'blue', 1);
    $image = $imageGen->getImage();

    header('content-type: image/png');
    imagepng($image);
    
    break;
  
  case 'json':
  default:
    echo ($terrain->toJson());
    break;
}