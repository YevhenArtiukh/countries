<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 15:31
 */

namespace App\Controller\Countries;


use App\Adapter\Countries\ReadModel\CountryQuery;
use App\Entity\Countries\ReadModel\Country;
use App\Entity\Users\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class GenerateExcelController extends AbstractController
{
    /**
     * @param CountryQuery $countryQuery
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * @Route("/countries/generate-xls", name="countries_generate_xls", methods={"GET"})
     */
    public function index(CountryQuery $countryQuery)
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Eksport krajów");

        $countries = $countryQuery->findAll();

        $sheet->setCellValue('A1', 'Nazwa');
        $sheet->setCellValue('B1', 'Język urzędowy');
        $sheet->setCellValue('C1', 'Ilość osób');
        if($this->isGranted(User::ROLE_USER) || $this->isGranted(User::ROLE_ADMIN))
            $sheet->setCellValue('D1', 'Lista osób');

        $row = 2;
        /**
         * @var int $key
         * @var Country $country
         */
        foreach ($countries as $key => $country) {
            if ($country->isActive() || $this->isGranted(User::ROLE_ADMIN)) {
                $sheet->setCellValue('A'.$row, $country->getName());
                $sheet->setCellValue('B'.$row, $country->getLanguages());
                $sheet->setCellValue('C'.$row, $country->getCountUsers());
                if($this->isGranted(User::ROLE_USER) || $this->isGranted(User::ROLE_ADMIN))
                    $sheet->setCellValue('D'.$row, $country->getUsers());

                $row++;
            }
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);

        $fileName = 'Eksport krajów.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        $writer->save($temp_file);

        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}