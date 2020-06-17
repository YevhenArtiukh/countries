<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 10:27
 */

namespace App\Entity\Countries;


interface Countries
{
    public function add(Country $country);

    public function delete(Country $country);

    /**
     * @param string $name
     * @return Country|null
     */
    public function findOneByName(string $name);
}