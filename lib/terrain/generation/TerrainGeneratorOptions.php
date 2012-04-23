<?php

namespace terrain\generation;

/**
 * Class implementation for TerrainGeneratorOptions
 *
 * @author michel
 */
class TerrainGeneratorOptions
{
  public $options = array();
  
  
  public function getWidth()
  {
    return (isset($this->options['width'])?$this->options['width']:null);
  }
  
  public function setWidth($val)
  {
    $this->options['width'] = $val;
  }
  
  public function getHeight()
  {
    return (isset($this->options['height'])?$this->options['height']:null);
  }
  
  public function setHeight($val)
  {
    $this->options['height'] = $val;
  }
  
  public function getStrategy()
  {
    return (isset($this->options['strategy'])?$this->options['strategy']:null);
  }
  
  public function setStrategy($val)
  {
    $this->options['strategy'] = $val;
  }
  
  public function getStrategyOptions()
  {
    return isset($this->options['strategyOptions'])?$this->options['strategyOptions']:array();
  }
  
  public function setStrategyOptions(array $val)
  {
    $this->options['strategyOptions'] = $val;
  }
  
  public function import(array $optionArray)
  {
    foreach($optionArray as $key => $val)
    {
      $methodName = 'set'.ucfirst($key);
      if(method_exists($this, $methodName))
      {
        $this->$methodName($val);
      }
      else
      {
        throw new \InvalidArgumentException('Invalid terrain generator option: ' . $key);
      }
    }
  }
}
