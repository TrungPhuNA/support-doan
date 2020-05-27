<?php


namespace App\HelpersClass;


use App\Models\Category;

class DetectCategory
{
	public static function getParentById($categoryID)
	{
		Category::recursiveAllParent( $categoryID,  $listCategoriesSort);
		return $listCategoriesSort;
	}

	public static function getChildById($categories, $parent, $level)
	{
		Category::recursiveAllChild($categories, $parent, $level, $listCategoriesSort);
		return $listCategoriesSort;
	}
}