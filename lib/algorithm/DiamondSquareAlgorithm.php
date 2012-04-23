<?php

namespace algorithm;

/**
 * Class implementation for DiamondSquareAlgorithm
 *
 * @author michel
 */
class DiamondSquareAlgorithm
{
  const RANDOMNESS = 100000;
  
  private $size;
  private $min;
  private $max;
  private $variation;
  
  private $result;
  
  public function __construct($size, $min = 0, $max = 1, $variation = 0.1)
  {
    $this->size = $size;
    $this->min = $min;
    $this->max = $max;
    $this->variation = $variation;
  }
  
  private function initializeArray()
  {
    $this->result = array();
    for($y = 0; $y < $this->size; $y++)
    {
      $this->result[$y] = array();
      for($x = 0; $x < $this->size; $x++)
      {
        $this->result[$y][$x] = $this->min;
      }
    }
  }
  
  public function compute()
  {
    srand(time());
    
    $this->initializeArray();
    
    $beginMax = $this->size - 1;
    
    $this->initializeCornerValues($beginMax);
    $this->doRecurse();
    
    return $this->result;
  }
  
  private function getInitialValue()
  {
    return ($this->max - $this->min) / 2;
  }
  
  private function getRandomVariation($initialVal)
  {
    $randomDec = (rand(0, self::RANDOMNESS) / self::RANDOMNESS);
    $variationDelta = ($randomDec * $this->variation * 2) - ($this->variation);
    $variedValue = $initialVal + $variationDelta;
    
    $variedValue = min(array($variedValue, $this->max));
    $variedValue = max(array($variedValue, $this->min));
    
    return $variedValue;
  }
  
  private function initializeCornerValues($maxCoord)
  {
    $this->result[0][0] = $this->getInitialValue();
    $this->result[0][$maxCoord] = $this->getInitialValue();
    $this->result[$maxCoord][0] = $this->getInitialValue();
    $this->result[$maxCoord][$maxCoord] = $this->getInitialValue();
  }
  
  private function doRecurse()
  {
    for($sideLength = $this->size-1; $sideLength >= 2; $sideLength /=2, $this->variation /= 2) 
    {
      $halfSide = $sideLength / 2;

      for($x = 0; $x<$this->size-1; $x += $sideLength)
      {
        for($y = 0; $y<$this->size-1; $y += $sideLength)
        {
          
          $avg = $this->result[$x][$y] +
          $this->result[$x+$sideLength][$y] +
          $this->result[$x][$y+$sideLength] +
          $this->result[$x+$sideLength][$y+$sideLength];
          
          $avg /= 4.0;

          $this->result[$x+$halfSide][$y+$halfSide] = $this->getRandomVariation($avg);
        }
      }

      for($x = 0; $x < $this->size-1; $x += $halfSide)
      {
        for($y=($x + $halfSide) % $sideLength; $y < $this->size - 1; $y += $sideLength)
        {
          
          $avg = 
            $this->result[($x-$halfSide+$this->size)%$this->size][$y] +
            $this->result[($x+$halfSide)%$this->size][$y] +
            $this->result[$x][($y+$halfSide)%$this->size] +
            $this->result[$x][($y-$halfSide+$this->size)%$this->size];
          $avg /= 4.0;

          $this->result[$x][$y] = $this->getRandomVariation($avg);

          if($x == 0)  $this->result[$this->size-1][$y] = $avg;
          if($y == 0)  $this->result[$x][$this->size-1] = $avg;
        }
      }
    }
    
  }
  
  
//  
//  private function doRecurse($x1, $y1, $x2, $y2)
//  {
//    $halfX = $x1 + ($x2 - $x1) / 2;
//    $halfY = $y1 + ($y2 - $y1) / 2;
//    
//    $sum = 0;
//    $sum += $this->result[$x1][$y1];
//    $sum += $this->result[$x1][$y2];
//    $sum += $this->result[$x2][$y1];
//    $sum += $this->result[$x2][$y2];
//    
//    $centerAvg = $this->getRandomVariation($sum / 4);
//    
//    $this->result[$halfX][$halfY] = $centerAvg;
//    
//    $this->result[$halfX][$y1] = $this->getRandomVariation(($this->result[$x1][$y1] + $this->result[$x2][$y1]) / 2);
//    $this->result[$halfX][$y2] = $this->getRandomVariation(($this->result[$x1][$y2] + $this->result[$x2][$y2]) / 2);
//    $this->result[$x1][$halfY] = $this->getRandomVariation(($this->result[$x1][$y1] + $this->result[$x1][$y2]) / 2);
//    $this->result[$x2][$halfY] = $this->getRandomVariation(($this->result[$x2][$y1] + $this->result[$x2][$y2]) / 2);
//    
//    if($halfX == $x1 + 1 || $halfY == $y1 + 1)
//    {
//      return;
//    }
//    
//    $this->doRecurse($x1, $y1, $halfX, $halfY);
//    $this->doRecurse($halfX, $y1, $x2, $halfY);
//    $this->doRecurse($x1, $halfY, $halfX, $y2);
//    $this->doRecurse($halfX, $halfY, $x2, $y2);
//  }
}
