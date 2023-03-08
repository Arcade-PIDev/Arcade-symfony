<?php

namespace App\Controller;

use App\Entity\Jeux;
use Twig\Environment;
use App\Form\JeuxFormType;
use App\Form\UpdatejeuxType;
use App\Repository\JeuxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JeuxController extends AbstractController
{
    #[Route('/afficherjeux', name: 'app_afficherjeux')]
    public function afficherjeux(jeuxRepository $repo)
    {
        return $this->render('jeux/afficherjeux.html.twig', [
            'Jeux' => $repo->findAll(),
        ]);
    }

    #[Route('/ajouterjeux', name: 'app_ajouterjeux')]
    public function ajouterjeux(Environment $twig,Request $request,EntityManagerInterface $manager)
    {
        $Jeux=new Jeux();

        $form=$this->createForm(JeuxFormType::class, $Jeux);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('jeux_form')['image'];
            $filename = md5(uniqid()) . '.png';
            $file->move($this->getParameter('Jeux_directory'), $filename);
            $Jeux->setImage($filename);
            $manager->persist($Jeux);
            $manager->flush();
            return $this->redirectToRoute('app_afficherjeux');
           }

        return new Response($twig->render('jeux/ajouterjeux.html.twig',[
            'formJeux' => $form->createView()
        ]));
    }

    #[Route('/deletejeux/{id}', name: 'app_deletejeux')]
    public function deletejeux(ManagerRegistry $doctrine,JeuxRepository $repo,$id)
    {
        $manager = $doctrine->getManager();
        $Jeu=$repo->find($id);
        $manager->remove($Jeu);
        $manager->flush();
        return $this->redirectToRoute('app_afficherjeux');
    }

    #[Route('/updatejeux/{id}', name: 'app_updatejeux')]
    public function updatejeux($id,Jeux $Jeux,Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UpdatejeuxType::class, $Jeux);
        $form->handleRequest($request);
        $img=$Jeux->getImage();
        $entityManager->getRepository(Jeux::class)->find($id);
        $Jeux->setImage($img);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $request->files->get('updatejeux')['image'];
            if ($file)
            {
            $filename = md5(uniqid()) . '.png';
            $file->move($this->getParameter('Jeux_directory'), $filename);
            $Jeux->setImage($filename);
            $entityManager->persist($Jeux);
            $entityManager->flush();
            return $this->redirectToRoute('app_afficherjeux');
            }
            else
            {
                $Jeux->setImage($img);
                $entityManager->persist($Jeux);
                $entityManager->flush();
                return $this->redirectToRoute('app_afficherjeux'); 
            }
        }

        return $this->render('jeux/modifierjeux.html.twig', [
            'formJeux' => $form->createView(),
        ]);
    }
     ///front///
     #[Route('/afficherJeuxFront', name: 'app_afficherJeuxFront')]
     public function afficherJeuxFront(JeuxRepository $repo, Request $request)
     {
         $genres = $repo->findAllGenres();
         $genre = $request->query->get('genre');
         $jeux = $genre ? $repo->findBy(['genre' => $genre]) : $repo->findAll();
         return $this->render('jeux/afficherJeuxFront.html.twig', [
             'Jeux' => $jeux,
             'genres' => $genres,
         ]);
     }

     #[Route('/stats', name: 'app_stats')]
    public function statistiques(JeuxRepository $JeuRepo){
        // On va chercher toutes les catégories
        $Jeu = $JeuRepo->findAll();

        $JeuNom = [];
        $JeuColor = [];
        $jetCount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($Jeu as $jeux){
            $JeuNom[] = $jeux->getNom();
            $JeuColor[] = $jeux->getColor();
            $jetCount[] = count($jeux->getTournois());
        }

        // On va chercher le nombre d'annonces publiées par date

        return $this->render('stat/stats.html.twig', [
            'JeuNom' => json_encode($JeuNom),
            'JeuColor' => json_encode($JeuColor),
            'jetCount' => json_encode($jetCount),
        ]);
    }

    #[Route('/app_afficherjeux_excel', name: 'app_afficherjeux_excel')]
    public function afficherjeuxexcel(jeuxRepository $repo)
    {
        // Get the jeux data from the repository
        $jeux = $repo->findAll();

        // Create a new spreadsheet and set the header row
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nom');
        $sheet->setCellValue('C1', 'Description');
        $sheet->setCellValue('D1', 'image');
        $sheet->setCellValue('E1', 'Genre');
        $sheet->setCellValue('F1', 'Color');

        // Add the jeux data to the spreadsheet
        $row = 2;
        foreach ($jeux as $jeu) {
            $sheet->setCellValue('A' . $row, $jeu->getId());
            $sheet->setCellValue('B' . $row, $jeu->getNom());
            $sheet->setCellValue('C' . $row, $jeu->getDescription());
            $sheet->setCellValue('D' . $row, $jeu->getImage());
            $sheet->setCellValue('E' . $row, $jeu->getGenre());
            $sheet->setCellValue('F' . $row, $jeu->getColor());
            $row++;
        }

        // Create a new Excel file and write the spreadsheet data to it
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'jeux.xlsx';
        $writer->save($fileName);

        // Return the file as a downloadable attachment
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->setContent(file_get_contents($fileName));

        // Delete the file from the server
        unlink($fileName);

        return $response;
    }
}
