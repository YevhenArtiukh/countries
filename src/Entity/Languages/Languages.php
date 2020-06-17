<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 16:49
 */

namespace App\Entity\Languages;


interface Languages
{
    public function add(Language $language);

    /**
     * @param string $name
     * @return Language|null
     */
    public function findOneByName(string $name);
}