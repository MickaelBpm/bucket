<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\AddWishType;
use App\Repository\WishRepository;
use App\Tools\Censurator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class MainController extends AbstractController
{
    #[Route('/', name: 'main_home')]
    public function home(): Response
    {
        $pseudo = "Aladdin";

        return $this->render("main/home.html.twig", [
            "pseudo" => $pseudo
        ]);
    }

    #[IsGranted ('ROLE_USER')]
    #[Route('/lampe', name: 'main_lampe')]
    public function lampe(Request $request, WishRepository $wishRepository, Censurator $censurator): Response
    {
        $author = $this->getUser()->getUserIdentifier();
        $wish = new Wish();
        $wish->setAuthor($author);

        $wishform = $this -> createForm(AddWishType::class, $wish);

        $wishform->handleRequest($request);

        if($wishform->isSubmitted() && $wishform->isValid()){

//            $wish->setDateCreated(new \DateTime());
//            $wish->setIsPublished(true);
            //Une façon de mettre des valeurs par défauts

            //Deux manières pour changer la description
            //Premiere qui est smart
            $wish->setDescription($censurator->purify($wish->getDescription()));
            $wish->setTitle($censurator->purify($wish->getTitle()));

            //Deuxième
//            $description = $wish->getDescription();
//            // Utilisation de la fonction purify
//            $newDescription = $censurator->purify($description);
//
//            $wish->setDescription($newDescription);

            $wishRepository->save($wish, true);

            $this->addFlash('success', 'Souhait ajouté !');
            return $this->redirectToRoute('wish_show', ['id' => $wish->getId()]);
            //return new RedirectResponse($this->generateUrl('wish_list'));
            //permet de renvoyer vers la page wish_list
        }

        return $this->render("main/lampe.html.twig",[
            'wishForm' => $wishform->createView()
        ]);
    }

    #[Route('/aboutUs', name: 'main_aboutUs')]
    public function aboutUs(): Response
    {
        return $this->render("main/aboutUs.html.twig");
    }
}
