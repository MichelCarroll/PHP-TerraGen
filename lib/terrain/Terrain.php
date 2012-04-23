<?php

namespace terrain;

/**
 * Class implementation for Terrain
 *
 * @author michel
 */
class Terrain
{
  private $tileMatrix = array();
  
  private $width;
  private $height;
  
  public function __construct($width, $height)
  {
    $this->width = $width;
    $this->height = $height;
    
    $this->initializeTileMatrix();
  }

  private function initializeTileMatrix()
  {
    unset($this->tileMatrix);
    $this->tileMatrix = array();
    
    for($y = 0; $y < $this->height; $y++)
    {
      $this->tileMatrix[$y] = array();
      for($x = 0; $x < $this->width; $x++)
      {
        $this->tileMatrix[$y][$x] = null;
      }
    }
  }
  
  public function getWidth()
  {
    return $this->width;
  }
  
  public function getHeight()
  {
    return $this->height;
  }
  
  /**
   *
   * @param integer $x
   * @param integer $y
   * @return Tile 
   */
  public function getTileAt($x, $y)
  {
    return $this->tileMatrix[$y][$x];
  }
  
  
  /**
   *
   * @param integer $x
   * @param integer $y
   * @param Tile $newTile
   */
  public function setTileAt($x, $y, Tile $newTile)
  {
    $this->tileMatrix[$y][$x] = $newTile;
  }
  
  public function toJson()
  {
    return json_encode($this->tileMatrix);
  }
}
