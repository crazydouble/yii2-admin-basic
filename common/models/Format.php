<?php

namespace common\models;

use Yii;
use yii\base\Model;

class Format extends Model
{
	static public function explodeValue($value)
	{
		return explode(',', $value);
	}

	static public function implodeValue($value)
	{
		return rtrim(implode(',', $value), ',');
	}

	static public function mb_substr($value, $reveal_all = false, $start = 0, $len = 50)
	{
		return (strlen($value) < $len || $reveal_all == true) ? $value : mb_substr($value, $start, $len, 'UTF-8') . '...';
	}
	
	static public function getModelName($className)
	{
		$arr = explode('\\', $className);
		return end($arr);
	} 
}
