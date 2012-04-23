<?php

namespace terrain\generation\strategies;

use terrain\Terrain;
use terrain\Tile;

/**
 * Class implementation for BlankGenerationStrategy
 *
 * @author michel
 */
class BlankGenerationStrategy extends GenerationStrategy
{

  /**
   * @return \terrain\Terrain 
   */
  public function generateTerrain(Terrain $terrain)
  {
    $w = $terrain->getWidth();
    $h = $terrain->getHeight();
    
    for($x = 0; $x < $w; $x++)
    for($y = 0; $y < $h; $y++)
    {
      $terrain->setTileAt($x, $y, new Tile());
    }
    
    return $terrain;
  }

}
