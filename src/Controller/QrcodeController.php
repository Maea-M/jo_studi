<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\OrdersDetailsRepository;
use App\Repository\PayementRepository;
use App\Service\PdfService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QRFpdf;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//require_once('./../vendor/autoload.php');

class QrcodeController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/qrcode', name: 'app_qrcode')]
    //https://github.com/chillerlan/php-qrcode
    //https://phppot.com/php/chillerlan-php-qrcode/

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
    public function generatePdf(EntityManagerInterface $entityManager, qrCodeImage $qrCodeImage=null): Response
    {
        $html = $this->renderView('qrcode/index.html.twig', [
            'qrCodeImage' => $qrCodeImage,
        ]);
    
        // Crée une nouvelle instance de Dompdf
        $dompdf = new Dompdf(); 

        // Charge le HTML à convertir en PDF
        $dompdf->loadHtml($html); 
        
        // Définit le format du papier sur lequel le PDF sera imprimé et son orientation
        $dompdf->setPaper('A4', 'portrait'); 
        
        // Génère le PDF à partir du HTML chargé
        $dompdf->render(); 
        
        // Génère un nom de fichier unique pour le PDF
        $filename = uniqid().'.pdf'; 
        
        // Définit le chemin où le PDF sera enregistré
        $pdfPath = $this->getParameter('kernel.project_dir').'/public/pdf/'.$filename; 
        
        // Enregistre le PDF généré dans le chemin spécifié
        file_put_contents($pdfPath, $dompdf->output()); 
        
        $user = $this->getUser();
        foreach ($user as $userticket) { 
            $userticket->setPathticket($pdfPath); 
            $entityManager->persist($user); 
        }
        $entityManager->flush(); 
        
        // Envoie le PDF généré au navigateur pour être téléchargé
        $dompdf->stream($filename, [ "Attachment" => true ]); 
        
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }

}