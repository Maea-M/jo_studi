<?php

namespace App\Controller;

use App\Entity\Payement;
use App\Entity\Qrcode as EntityQrcode;
use App\Repository\PayementRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QRFpdf;
use chillerlan\QRCode\Output\QRGdImagePNG;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

require_once('./../vendor/autoload.php');

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

        //Créer le qrcode
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
        header('Content-Type: image/png');
        return $this->render('qrcode/index.html.twig', [
            'qrCodeImage' => $qrCodeImage,
        ]);       
    }
}