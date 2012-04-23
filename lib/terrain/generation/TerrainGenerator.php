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
   * @var TerrainGeneratorOptions 
   */
  private $options;

  public function __construct(TerrainGeneratorOptions $options)
  {
    $this->options = $options;
  }
  
  /**
   *
   * @return \terrain\Terrain 
   */
  public function generate()
  {
    $terrain = new Terrain(
      $this->options->getWidth(),
      $this->options->getHeight()
    );
    
    $strategy = $this->options->getStrategy();
    if(!$strategy)
    {
      throw new GeneratorException('Strategy not specified');
    }
    
    $strategyClassname = 
      'terrain\\generation\\strategies\\'.
      ucfirst($strategy).
      'GenerationStrategy';
    
    if(!class_exists($strategyClassname))
    {
      throw new GeneratorException('Strategy ' . $strategy . ' does not exist');
    }
    
    $options = $this->options->getStrategyOptions();
    $strategyImpl = new $strategyClassname($options);
    /* @var $strategyImpl GenerationStrategy  */
    
    
    $newTerrain = $strategyImpl->generateTerrain($terrain);
    
    return $newTerrain;
  }

}
