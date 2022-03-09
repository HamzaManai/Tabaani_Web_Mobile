<?php

namespace App\Data;

use App\Entity\Hebergement;
use PhpParser\Node\Scalar\String_;
use App\Entity\TypeHebergement;
use App\Entity\proprietaire;


class SearchData
{

    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $q = '';

    /**
     *@var TypeHebergement
     */
    public $type_hbrg;
    
    /**
     *@var proprietaire
    */
    public $proprietaire;
    
    /**
     *@var String
     */
    public $adresse_hbrg;

    /**
     * @var null|integer
     */
    public $max;

    /**
     * @var null|integer
     */
    public $min;

    /**
     * @var null|integer
     */
    public $nbr_place;

        /**
     * @var DateTimeInterface
     */
    public $date_hbrg;

}
