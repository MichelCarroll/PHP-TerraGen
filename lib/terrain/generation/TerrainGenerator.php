<?php

namespace terrain\generation;

use terrain\Terrain;

/**
 * Class implementation for TerrainGenerator
 *
 * @author michel
 */
class TerrainGenerator
{
  /**
   * @var array 
   */
  private $options;
  
  /**
   * @var Terrain $terrain 
   */
  private $terrain;
  

  public function __construct(array $options)
  {
    $this->options = $options;
  }
  
  /**
   *
   * @return \terrain\Terrain 
   */
  public function generate()
  {
    $this->terrain = new Terrain(
      $this->options['width'],
      $this->options['height']
    );
    
    $this->iterateStrategyStack($this->options['stack']);
    
    return $this->terrain;
  }
  
  
  private function iterateStrategyStack(array $strategyStack)
  {
    foreach($strategyStack as $strategy)
    {
      $strategyClassname = 
        'terrain\\generation\\strategies\\'.
        ucfirst($strategy['name']).
        'GenerationStrategy';

      if(!class_exists($strategyClassname))
      {
        throw new GeneratorException('Strategy ' . $strategyClassname . ' does not exist');
      }

      $params = (isset($strategy['params'])?$strategy['params']:array());
      $strategyImpl = new $strategyClassname($params);
      /* @var $strategyImpl GenerationStrategy  */


      $this->terrain = $strategyImpl->generateTerrain($this->terrain);
    }
    
  }

}
