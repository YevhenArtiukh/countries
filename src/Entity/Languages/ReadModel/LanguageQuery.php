<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 20:46
 */

namespace App\Entity\Languages\ReadModel;


interface LanguageQuery
{
    /**
     * @return mixed
     */
    public function findAll();
}