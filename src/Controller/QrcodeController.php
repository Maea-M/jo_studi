<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\OrdersDetailsRepository;
use App\Repository\PayementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//require_once('./../vendor/autoload.php');

class QrcodeController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/qrcode', name: 'app_qrcode')]
    //https://github.com/chillerlan/php-qrcode
    //https://phppot.com/php/chillerlan-php-qrcode/
    //https://docs.koala-framework.org/kwf-general-features/dom-pdf/

    public function index (PayementRepository $payementRepository): Response
    {
        // Récupérez l'utilisateur connecté
        $user = $this->getUser();

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_login');
        }

        // Générez la clé sécrète
        $firstKey = $user->getKeyfirst();
        $payements = $payementRepository->findAll();
        foreach($payements as $payement){
            $payement->getSecondKey();
        }
        $SecondKey = $payement->getSecondKey();
        //dd($SecondKey);
        $secretKey = $firstKey . $SecondKey;
        //dd($secretKey);

        //Créer le qrcode image
        $options = new QROptions([
            'version' => 5,
            'eccLevel' => QRCode::ECC_H,
            'scale' => 5,
            'imageBase64' => true,
            'imageTransparent' => false,
            'foregroundColor' => '#000000',
            'backgroundColor' => '#ffffff'
        ]);
        
        // Créer le CQ code pdf
        //$options = new QROptions([
        //    'version' => 7,
        //    'outputInterface'  => QRFpdf::class,
        //    'scale'            => 5,
        //    'fpdfMeasureUnit'  => 'mm',
        //    'bgColor'          => [222, 222, 222],
        //    'drawLightModules' => false,
        //    'outputBase64'    => false,
        //]);

        // Instantiating the code QR code class
        $qrCode = new QRCode($options);
        
        // generating the QR code image happens here
        $qrCodeImage = $qrCode->render($secretKey);
        header('Content-Type: image/png');
        
        return $this->render('qrcode/index.html.twig', [
            'qrCodeImage' => $qrCodeImage,
        ]);       
    }

    #[Route('/qrcode/pdf', name: 'app_qrcode_pdf')]
    public function generatePdf(EntityManagerInterface $entityManager, EvenementRepository $evenementRepository, PayementRepository $payementRepository, OrdersDetailsRepository $ordersDetailsRepository):Response
    {        
        // Récupérez l'utilisateur connecté
        $user = $this->getUser();

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_login');
        }

        // Générez la clé sécrète
            $firstKey = $user->getKeyfirst();
            $payements = $payementRepository->findAll();
            foreach($payements as $payement){
                $payement->getSecondKey();
            }
            $SecondKey = $payement->getSecondKey();
               //dd($SecondKey);
            $secretKey = $firstKey . $SecondKey;
               //dd($secretKey);
    
               //Créer le qrcode image
            $options = new QROptions([
                'version' => 5,
                'eccLevel' => QRCode::ECC_H,
                'scale' => 5,
                'imageBase64' => true,
                'imageTransparent' => false,
                'foregroundColor' => '#000000',
                'backgroundColor' => '#ffffff'
            ]);

        // Instantiating the code QR code class
        $qrCode = new QRCode($options);

        // generating the QR code image happens here
        $qrCodeImage = $qrCode->render($secretKey);
        
        $imagesource = 'public/build/images/logostudijo.png';
        //$ordersDetails = $ordersDetailsRepository->findBy['user'];
        //dd($ordersDetails);
        //foreach($ordersDetails as $orderDetail){
        //    $orderDetail->getEvenement();
        //}
        //dd($orderDetail);

        $html = $this->render('qrcode/pdf.html.twig', array(
            'twiglogo' => $imagesource,
            'qrCodeImage' => $qrCodeImage,
            //'orderDetail' => $orderDetail, 
        )
        );


        // Configuration de Dompdf 
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        $dompdf = new Dompdf($pdfOptions); 

        $dompdf->loadHtml($html); 
        
        $dompdf->setPaper('A4', 'portrait'); 
        
        $dompdf->render(); 
        
        // Génère un nom de fichier unique pour le PDF
        $filename = uniqid().'.pdf'; 
        $pdfPath = $this->getParameter('kernel.project_dir').'/public/pdf/'.$filename;
        $pathticket = pathinfo('./public/pdf');
        $user = $this->getUser();
        foreach ($user as $userticket) { 
            $userticket->setPathticket($pathticket); 
            $entityManager->persist($userticket); 
        }
        $entityManager->flush();
        
        // Enregistre le PDF généré dans le chemin spécifié
        file_put_contents($pdfPath, $dompdf->output()); 
        
        // Envoie le PDF généré au navigateur pour être téléchargé
        $dompdf->stream($filename, [ "Attachment" => true ]); 
        
        header('Content-Type: application/pdf');

    }

}