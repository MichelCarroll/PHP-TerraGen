<?php

namespace terrain\generation\strategies;

use \terrain\Terrain;

/**
 * interface for Terrain generation strategies
 *
 * @author michel
 */
abstract class GenerationStrategy
{
  
  public function __construct($options = array())
  {
    foreach($options as $key => $val)
    {
      if(isset($options[$key]) && property_exists(get_class($this), $key))
      {
        $this->$key = $val;
      }
    }
  }

  abstract public function generateTerrain(Terrain $startTerrain);

}
