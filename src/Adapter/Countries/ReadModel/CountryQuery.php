<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 15:15
 */

namespace App\Adapter\Countries\ReadModel;

use App\Entity\Countries\ReadModel\Country;
use App\Entity\Countries\ReadModel\CountryQuery as CountryQueryInterface;
use Doctrine\DBAL\Connection;

class CountryQuery implements CountryQueryInterface
{
    private $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->connection->project(
            "SELECT
                    country.id AS id,
                    country.name AS name,
                    country.flag AS flag,
                    country.active AS active,
                    (
                      SELECT 
                      GROUP_CONCAT(l.name SEPARATOR ', ')
                      FROM language AS l
                      LEFT JOIN country_language ON l.id = country_language.language_id
                      WHERE country_language.country_id = country.id
                    ) as languages,
                    (
                      SELECT COUNT(u.id)
                      FROM user AS u
                      LEFT JOIN user_country ON u.id = user_country.user_id
                      WHERE user_country.country_id = country.id
                    ) AS countUsers,
                    (
                      SELECT 
                      GROUP_CONCAT(CONCAT(u.name, ' ',u.surname) SEPARATOR ', ')
                      FROM user AS u
                      LEFT JOIN user_country ON u.id = user_country.user_id
                      WHERE user_country.country_id = country.id
                    ) as users
                    FROM country
                    GROUP BY country.id
                    ORDER BY country.name ASC",
            [],
            function (array $result) {
                return new Country(
                    (int)$result['id'],
                    (string)$result['name'],
                    (string)$result['flag'],
                    (bool)$result['active'],
                    (string)$result['languages'],
                    (int)$result['countUsers'],
                    (string)$result['users']
                );
            }
        );
    }
}