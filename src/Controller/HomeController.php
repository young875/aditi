<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use App\Repository\ProduitsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param ProduitsRepository $repository
     * @return Response
     */
    public function index(Request $request, ProduitsRepository $repository):Response
    {
        $produits = $repository->findBy([
            'statue' => true,

        ], ['id' => 'DESC'], 3 );
        return $this->render('home/index.html.twig', [
            'page' => 'home',
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param ContactNotification $notification
     * @return Response
     */
    public function contact(Request $request, ContactNotification $notification):Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $notification->notify($contact);
            $this->addFlash(
                "success", "Votre message à bien été envoyer"
            );
            $this->redirectToRoute('contact');
        }
        return $this->render('home/contact.html.twig', [
            'page' => 'contact',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/astuces", name="astuces")
     * @param ProduitsRepository $repo
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function astuces(ProduitsRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $a = "astuces";

        $astuces = $paginator->paginate(
          $repo->findProdVisible($a),
          $request->query->getInt('page', 1), 12
        );
        return $this->render('home/astuces.html.twig', [
            'page' => 'astuces',
            'astuces' => $astuces
        ]);
    }

    /**
     * @Route("/show", name="show")
     */
    public function show()
    {
        return $this->render('home/show.html.twig', [
            'page' => 'rien',
        ]);
    }

    /**
     * @Route("/produits", name="produits")
     * @param $paginator
     * @param $request
     * @param $repo
     * @return Response
     */
    public function produits(PaginatorInterface $paginator, Request $request, ProduitsRepository $repo): Response
    {
        $a = "produits";

        $produits = $paginator->paginate(
            $repo->findProdVisible($a),
            $request->query->getInt('page', 1), 30
        );
        return $this->render('home/produits.html.twig', [
            'page' => 'produits',
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/a-propos", name="about")
     * @param Request $request
     * @param ProduitsRepository $repository
     * @return Response
     */
    public function about(Request $request, ProduitsRepository $repository):Response
    {

        $produits = $repository->findBy([
            'statue' => true,

        ], ['id' => 'DESC'], 3 );

        return $this->render('home/about.html.twig', [
            'page' => 'about',
            'produits' => $produits
        ]);
    }
}
