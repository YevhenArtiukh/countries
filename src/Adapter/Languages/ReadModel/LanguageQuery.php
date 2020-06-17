<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 20:46
 */

namespace App\Adapter\Languages\ReadModel;

use App\Entity\Languages\ReadModel\Language;
use App\Entity\Languages\ReadModel\LanguageQuery as LanguageQueryInterface;
use Doctrine\DBAL\Connection;

class LanguageQuery implements LanguageQueryInterface
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
                    l.id AS id,
                    l.name AS name,
                    COUNT(country_language.country_id) AS countCountry
                    FROM language AS l
                    LEFT JOIN country_language ON l.id = country_language.language_id
                    GROUP BY l.id",
            [],
            function (array $result) {
                return new Language(
                    (int)$result['id'],
                    (string)$result['name'],
                    (int)$result['countCountry']
                );
            }
        );
    }
}