<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 12:54
 */

namespace App\Controller\Countries;


use App\Adapter\Countries\ReadModel\CountryQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @param CountryQuery $countryQuery
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="countries", methods={"GET"})
     */
    public function index(CountryQuery $countryQuery)
    {
        return $this->render('countries/list.html.twig', [
            'countries' => $countryQuery->findAll()
        ]);
    }
}