<?php

namespace terrain\generation\strategies;

use terrain\Terrain;
use terrain\Tile;

use algorithm\DiamondSquareAlgorithm;

/**
 * Class implementation for DiamondSquareGenerationStrategy
 *
 * @author michel
 */
class DiamondSquareGenerationStrategy extends GenerationStrategy
{
  protected $min = 0;
  protected $max = 1;
  protected $variation = 0.1;
  protected $property = 'single';
  
  /**
   * @return \terrain\Terrain 
   */
  public function generateTerrain(Terrain $terrain)
  {
    srand(time());
    
    $w = $terrain->getWidth();
    $h = $terrain->getHeight();
    
    $size = $this->getClosestComputableSize($w, $h);
    
    $xOffset = ($size / 2) - ($w / 2);
    $yOffset = ($size / 2) - ($h / 2);
    
    $algorithm = new DiamondSquareAlgorithm($size, $this->min, $this->max, $this->variation);
    $matrix = $algorithm->compute();
    
    for($x = 0; $x < $w; $x++)
    for($y = 0; $y < $h; $y++)
    {
      $tile = $terrain->getTileAt($x, $y);
      $tile->properties[$this->property] = $matrix[$x+$xOffset][$y+$yOffset];
      $terrain->setTileAt($x, $y, $tile);
    }
    
    return $terrain;
  }
  
  private function getClosestComputableSize($w, $h)
  {
    $biggestSide = max(array($w, $h));
    $size = 1;
    $power = 1;
    
    while($size < $biggestSide)
    {
      $size = pow(2, $power++) + 1;
    }
    
    return $size;
  }

}
