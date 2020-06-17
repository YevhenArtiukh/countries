<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 13:13
 */

namespace App\Adapter\Users\ReadModel;

use App\Entity\Users\ReadModel\User;
use App\Entity\Users\ReadModel\UserQuery as UserQueryInterface;
use Doctrine\DBAL\Connection;

class UserQuery implements UserQueryInterface
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
                    u.id,
                    u.name,
                    u.surname,
                    u.email,
                    u.age,
                    COUNT(user_country.country_id) AS countries
                    FROM user AS u
                    LEFT JOIN user_country ON u.id = user_country.user_id
                    GROUP BY u.id",
            [],
            function (array $result) {
                return new User(
                    (int)$result['id'],
                    (string)$result['name'],
                    (string)$result['surname'],
                    (string)$result['email'],
                    (int)$result['age'],
                    (int)$result['countries']
                );
            }
        );
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findOneById(int $id)
    {
        $user = $this->connection->project(
            "SELECT
                    u.id,
                    u.name,
                    u.surname,
                    u.email,
                    u.age,
                    COUNT(user_country.country_id) AS countries
                    FROM user AS u
                    LEFT JOIN user_country ON u.id = user_country.user_id
                    WHERE u.id = :id
                    GROUP BY u.id",
            [
                'id' => $id
            ],
            function (array $result) {
                return new User(
                    (int)$result['id'],
                    (string)$result['name'],
                    (string)$result['surname'],
                    (string)$result['email'],
                    (int)$result['age'],
                    (int)$result['countries']
                );
            }
        );

        if(!$user)
            return null;

        return reset($user);
    }
}