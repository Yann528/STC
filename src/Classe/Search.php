<?php

namespace App\Classe;

use App\Entity\Category;

class Search

{
/**
* @var string
*/
 public $string = '';

 /**
* @var string
*/
public $typeOffre = '';

/**
 * @var int|null
 */
public $prixMin = null;

/**
 * @var int|null
 */
public $prixMax = null;

/**
 * @var int|null
 */
public $surfaceMin = null;

/**
 * @var int|null
 */
public $surfaceMax = null;


/**
* @var category[]
*/
 public $categories = [];

}

