<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FiliereRepository;
use App\Repository\NiveauRepository;

/**
 * @Route("/etudiant")
 */
class EtudiantController extends AbstractController
{
    /**
     * @Route("/", name="etudiant_index", methods={"GET"})
     */
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="etudiant_new", methods={"GET","POST"})
     */
    public function new(Request $request,FiliereRepository $filiererepo, NiveauRepository $niveaurepo): Response
    {
        $user=$this->getUser();

        $etudiant = new Etudiant();
        if(isset($_POST['ajouter'])){
             if($request->isMethod('POST')){
                extract($_POST);
                $caracteres = '0123456789';
                $longueurMax = strlen($caracteres);
                $chaineAleatoire = '';
                for ($i = 0; $i < 7; $i++) {
                        $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
 }
                $etudiant->setFirtname($firstname);
                $etudiant->setLastname($lastname);
                $etudiant->setDatenaiss($dateofbirth);
                $etudiant->setLieunaiss($lieunaissance);
                $etudiant->setGenre($gender);
                $etudiant->setMobile($portable);
                $etudiant->setAddress($adresseli);
                $etudiant->setDescription($description);
                $etudiant->setFiliere($filiererepo->findOneBy(['id'=>$filiereid]));
                $etudiant->setNiveau($niveaurepo->findOneBy(['id'=>$niveauid]));
                $etudiant->setNumerocarte($chaineAleatoire);
                $etudiant->setImage(file_get_contents($_FILES['image']['tmp_name']));
                $em = $this->getDoctrine()->getManager();
                $em->persist($etudiant);
                $em->flush();
                $this->addFlash('success', 'Etudiant enregistré avec success.');
            }
        }

        return $this->render('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'user'=>$user ,
            'filieres'=>$filiererepo->findAll(),
            'niveaux'=>$niveaurepo->findAll(),
        ]);

    }

    /**
     * @Route("/{id}", name="etudiant_show", methods={"GET"})
     */
    public function show(Etudiant $etudiant, FiliereRepository $filiererepo, NiveauRepository $niveaurepo): Response
    {
        $etudiant->setImage(base64_encode(stream_get_contents($etudiant->getImage())));

        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="etudiant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Etudiant $etudiant,$id, EtudiantRepository $etudiantrepo, FiliereRepository $filiererepo, NiveauRepository $niveaurepo): Response
    {
        $etudiant = $etudiantrepo->findOneBy(['id'=>$id]);

        if(isset($_POST['ajouter'])){
             if($request->isMethod('POST')){
                 extract($_POST);

                $etudiant->setFirtname($firstname);
                $etudiant->setLastname($lastname);
                $etudiant->setDatenaiss($dateofbirth);
                $etudiant->setLieunaiss($lieunaissance);
                $etudiant->setGenre($gender);
                $etudiant->setMobile($portable);
                $etudiant->setAddress($adresseli);
                $etudiant->setDescription($description);
                $etudiant->setFiliere($filiererepo->findOneBy(['id'=>$filiereid]));
                $etudiant->setNiveau($niveaurepo->findOneBy(['id'=>$niveauid]));
                $em = $this->getDoctrine()->getManager();
                $em->persist($etudiant);
                $em->flush();
                $this->addFlash('success', 'Etudiant modifié avec success.');
            }
        }


        return $this->render('etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'filieres'=>$filiererepo->findAll(),
            'niveaux'=>$niveaurepo -> findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="etudiant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Etudiant $etudiant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etudiant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etudiant_index');
    }
}
