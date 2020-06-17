<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 15:15
 */

namespace App\Entity\Countries\ReadModel;


interface CountryQuery
{
    /**
     * @return mixed
     */
    public function findAll();
}