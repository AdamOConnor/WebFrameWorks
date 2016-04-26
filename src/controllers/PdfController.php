<?php
/**
 * Created by PhpStorm.
 * User: Adam O'Connor
 * Date: 19/04/2016
 * Time: 00:41
 */

namespace Adamoconnorframeworks\Controller;

use Adamoconnorframeworks\Model\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use FPDF;
use Adamoconnorframeworks\Model\JobApplications;
use ZipArchive;

class PdfController extends FPDF
{

    /**
     * @param Request $request
     * @param Application $app
     * @param $id
     * @return mixed
     */
    public function indexAction(Request $request, Application $app, $id)
    {

        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);
        $jobs = JobApplications::getAllByJobId($id);

        if($jobs == null)
        {
            $app['session']->set('user', array('username' => $username));
            return $app->redirect('/redirectJob');
        }

        //$id = $request->get('JobId');

        foreach ($jobs as $job) {
            /**
             * @var $job JobApplications;
             */
               $pdf = new FPDF();
               $pdf->AddPage();
               $pdf->SetFont('Arial', 'B', 16);
               $pdf->Cell(80);
               $pdf->Cell(20, 10, 'Resume', 0, 1, 'C');

               $pdf->Cell(50);
               $pdf->SetFont('Arial', 'I', 10);
               $pdf->Cell(80, 10, 'Name : ' . $job->getName() . ' ' . $job->getSurname() . '  Email : ' . $job->getEmail() . ' Number : ' . $job->getNumber(), 0, 1, "C");

               //$pdf->Image($job->getImage(), 125, 40, 30, 0, '');

               $pdf->SetFont('Arial', 'B', 16);
               $pdf->Cell(20, 10, 'Address : ', 0, 1, 'L');

               $pdf->SetFont('Arial', 'I', 10);
               $pdf->Cell(80, 10, 'Address Line 01 : ' . $job->getAddress(), 0, 1, "L");
               $pdf->Cell(80, 10, 'Town : ' . $job->getTown(), 0, 1, "L");
               $pdf->Cell(80, 10, 'City : ' . $job->getCity(), 0, 1, "L");
               $pdf->Cell(80, 10, 'Eircode : ' . $job->getEircode(), 0, 1, "L");
               $pdf->Cell(80, 10, 'Country : ' . $job->getCountry(), 0, 1, "L");

                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(20, 10, 'Previous Employment : ', 0, 1, 'L');
                $pdf->SetFont('Arial', 'I', 10);
                $pdf->Cell(80, 10, $job->getEmployment(), 0, 1, "L");

                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(20, 10, 'Skills : ', 0, 1, 'L');
                $pdf->SetFont('Arial', 'I', 10);
                $pdf->Cell(80, 10, $job->getSkills(), 0, 1, "L");

                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(20, 10, 'Qualifications : ', 0, 1, 'L');
                $pdf->SetFont('Arial', 'I', 10);
                $pdf->Cell(80, 10, $job->getQualifications(), 0, 1, "L");

                $pdf->Output('resume/' . $job->getEmail() . '.pdf', 'F');

        }


        function create_zip($files = array(),$destination = '',$overwrite = false) {
            //if the zip file already exists and overwrite is false, return false
            if(file_exists($destination) && !$overwrite) { return false; }
            //vars
            $valid_files = array();
            //if files were passed in...
            if(is_array($files)) {
                //cycle through each file
                foreach($files as $file) {
                    //make sure the file exists
                    if(file_exists($file)) {
                        $valid_files[] = $file;
                    }
                }
            }
            //if we have good files...
            if(count($valid_files)) {
                //create the archive
                $zip = new ZipArchive();
                if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
                    return false;
                }
                //add the files
                foreach($valid_files as $file) {
                    $zip->addFile($file,$file);
                }
                //debug
                //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

                //close the zip -- done!
                $zip->close();

                //check to make sure the file exists
                return file_exists($destination);
            }
            else
            {
                return false;
            }
        }

        ob_clean();
        ob_end_flush();


        $archiveName = 'Job-resumes.zip';
        $dir    = 'resume/';
        $files1 = scandir($dir);

        $changed = array_merge(array_diff($files1, array('.', '..')));

        foreach ($changed as &$value) {
            $value = 'resume/'.$value;
        }
        unset($value);

        create_zip($changed, $archiveName);

        $yourfile = $archiveName;
        $file_name = basename($yourfile);

        header("Content-Type: application/zip");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Content-Length: " . filesize($yourfile));
        readfile($yourfile);
        $files = glob('resume/*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
        unlink($archiveName);

        $argsArray = [
            'title' => 'Registration succeeded'
        ];

        // template for register
        $templateName = 'redirect';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * redirect the user if the form has
     * succeeded to process and is saved
     * in the database.
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function redirectAction(Request $request, Application $app)
    {

        $username = getAuthenticatedUserName($app);
        $currentUser = User::getOneByUsername($username);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if (!$isAuthenticated) {
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        // args array title
        $argsArray = [
            'title' => 'failed Cv Download',
            'username' => $username,
            'roleName' => $currentUser->getRole(),
            'headingMessage' => 'Cv Download Failed',
            'otherMessage' => 'No Resumes Have been found.'
        ];

        // template for register
        $templateName = 'redirect';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }
}

