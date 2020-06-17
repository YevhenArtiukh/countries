<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 11:34
 */

namespace App\Core;


interface Transaction
{
    public function begin();
    public function commit();
    public function rollback();
}