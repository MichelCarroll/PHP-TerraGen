<?php

namespace terrain\generation\strategies;

use terrain\Terrain;
use terrain\Tile;

/**
 * Class implementation for RandomSingleGenerationStrategy
 *
 * @author michel
 */
class RandomSingleGenerationStrategy extends GenerationStrategy
{
  const RANDOMNESS = 10000;
  
  protected $min = 0;
  protected $max = 1;
  protected $property = 'single';
  
  /**
   * @return \terrain\Terrain 
   */
  public function generateTerrain(Terrain $terrain)
  {
    srand(time());
    
    $w = $terrain->getWidth();
    $h = $terrain->getHeight();
    
    $diffDelta = $this->max - $this->min;
    
    for($x = 0; $x < $w; $x++)
    for($y = 0; $y < $h; $y++)
    {
      $tile = new Tile();
      $randVal = $this->min + ((double) (rand(0, self::RANDOMNESS) / self::RANDOMNESS) * $diffDelta);
      $tile->properties[$this->property] =  $randVal;
      $terrain->setTileAt($x, $y, $tile);
    }
    
    return $terrain;
  }

}
