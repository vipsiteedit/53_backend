<?php

require_once("lib/lib_images.php");
/**
 * Базовый класс работы с картинками магазина
 * @filesource plugin_shop_images.class.php
 * @copyright EDGESTILE
 */
class plugin_ShopImages40 {
	private $path_imggroup;
	private $path_imgprice;
	private $path_imgall;
	private $_page;
	private $price;

	public function __construct()
  	{
  	    $lang = se_GetLang();
  		$this->path_imggroup = '/images/'.$lang.'/shopgroup/';
  		$this->path_imgprice = '/images/'.$lang.'/shopprice/';
		$this->path_imgall = '/images/'.$lang.'/shopimg/';
		$this->_page = getRequest('page');
		$this->price = new seShopPrice();
		return $this;
  	}

	public function getNoImage()
	{
	    if (file_exists(dirname(__FILE__)."/no_foto.gif"))
        	return "/lib/plugins/plugin_shop/no_foto.gif";
    	    else
        	return "";
	}

	public function createImage($image, $newimage, $width = 0)
	{
            if (file_exists(getcwd(). $this->path_imgprice . $image) && $width > 0){
        	    $ext = getExtFile($image);
                    ThumbCreate(getcwd(). $this->path_imgprice . $image, $newimage, $ext, $width);
                    return true;
            }
            return false;
	}
	
	private function processImage($image, $newimage, $width)
	{
                if (!file_exists(getcwd() . $newimage)){
                    if (!$this->createImage($image, $newimage, $width)){
        		return $this->getNoImage();
                    }
                } elseif($width > 0) {
            	    $size = getimagesize(getcwd().$newimage);
            	    if ($size[0] != $width){
                        $this->createImage($image, $newimage, $width);
            	    }
                }
                return $newimage;
	}

	public function getFullFromImage($image)
	{
	    $img_full_name = $this->path_imgprice.$image;
	    if (!empty($image) && file_exists(getcwd().$img_full_name)){
        	return $img_full_name;
	    } else {
        	return $this->getNoImage();
    	    }
	}

	public function getFullPriceImage($goods_id)
	{
	    $this->price->select('img');
    	    $this->price->find($goods_id);
    	    return $this->getFullFromImage($this->price->img);
	}

	public function getMidFromImage($image, $width = 0)
	{
            if (!empty($image)){
                return $this->processImage($image, $this->path_imgall . setPrefFile($image, '_mid'), $width);
            } else
        	return $this->getNoImage();
        }


	public function getMidPriceImage($goods_id, $width = 0)
	{
	    $this->price->select('img');
    	    $this->price->find($goods_id);
            $img_name = $this->price->img;
            return $this->getMidFromImage($this->price->img, $width);
        }

	public function getPrevFromImage($image, $width = 0)
	{
		if (!empty($image)){
            	    return $this->processImage($image, $this->path_imgprice . setPrefFile($image, '_prev'), $width);
		} else
	    	    return $this->getNoImage();
	}

	public function getPrevPriceImage($goods_id, $width = 0)
	{
		$this->price->select('img');
    		$this->price->find($goods_id);
    		return $this->getPrevFromImage($this->price->img, $width);
	}

	public function getPictFromImage($image, $size = 0, $res='s', $watermark = '')
	{
			$img_name = $this->path_imgprice.$image;
	    if (!file_exists(getcwd().$img_name)){
			$img_name = $this->path_imgall.$image;
	    }
	    if ($size == 0)
				return $img_name;
	    if (!empty($image) && file_exists(getcwd() . $img_name)){
    	        return se_getDImage($img_name, $size, $res, $watermark);
        } 
		else
        	return $this->getNoImage();
    }
	
	public function getMorePhotoOnClick($viewgoods, $width=700, $height=780)
	{
		return "window.open('/lib/plugins/plugin_shop/sshop_fotos.php?shop=$this->_page&goods=$viewgoods&subg=0','Window','scrollbars=yes,toolbar=no,width=$width,height=$height,resizable=yes');";
	}

}
?>