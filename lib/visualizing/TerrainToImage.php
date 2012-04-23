<?php

namespace visualizing;

use terrain\Terrain;

/**
 * Class implementation for TerrainToImage
 *
 * @author michel
 */
class TerrainToImage
{
  /** @var Terrain $terrain */
  private $terrain;
  
  private $sizeMult;
  private $colorMap = array();
  
  private $tempImage;
  
  public function __construct(Terrain $terrain, $sizeMult = 4)
  {
    $this->terrain = $terrain;
    $this->sizeMult = $sizeMult;
  }
  
  public function mapPropertyToColValue($propertyName, $colorName, $max = 1)
  {
    $this->colorMap[$colorName] = array(
      'name' => $propertyName, 
      'max' => $max);
  }
  
  private function getColorFromProperties(array $properties)
  {
    $colList = array('red', 'green', 'blue');
    foreach($colList as $colName)
    {
      $$colName = 0;
      if(isset($this->colorMap[$colName]))
      {
        $propertyName = $this->colorMap[$colName]['name'];
        if(!isset($properties[$propertyName]))
        {
          throw new \InvalidArgumentException('Tile property does not exist: ' . $propertyName);
        }
        
        $$colName = $properties[$propertyName];
        $max = $this->colorMap[$colName]['max'];
        $$colName *= ($$colName / $max) * 255;
      }
    }
    
    return imagecolorallocate($this->tempImage, $red, $green, $blue);
  }
  
  public function getImage()
  {
    $this->tempImage = 
      imagecreatetruecolor(
        $this->terrain->getWidth()  * $this->sizeMult, 
        $this->terrain->getHeight() * $this->sizeMult
      );
    
    $w = $this->terrain->getWidth();
    $h = $this->terrain->getHeight();
    
    for($x = 0; $x < $w; $x++)
    for($y = 0; $y < $h; $y++)
    {
      $tile = $this->terrain->getTileAt($x, $y);
      $color = $this->getColorFromProperties($tile->properties);

      $x1 = ($x * $this->sizeMult);
      $y1 = ($y * $this->sizeMult);
      $x2 = $x1 + $this->sizeMult;
      $y2 = $y1 + $this->sizeMult;
      
      imagefilledrectangle($this->tempImage, $x1, $y1, $x2, $y2, $color);
    }
    
    return $this->tempImage;
  }

}


