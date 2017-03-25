<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\GenusFormType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Genus;

class GenusAdminController extends Controller
{

    /**
     * @Route("/genus/list", name="admin_genus_list")
     */
    public function listAction()
    {
        $repo = $this->getDoctrine()->getRepository(Genus::class);
        $genusList = $repo->findAll();
        
        return $this->render('admin/genus/list.html.twig', [
            'genusList' => $genusList
        ]);
    }

    /**
     * @Route("/genus/new", name="admin_genus_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(GenusFormType::class);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            
            $this->addFlash('success', 'Genus ' . $data->getName() . ' created!');
            return $this->redirectToRoute('admin_genus_list');
        }
        
        return $this->render('admin/genus/new.html.twig', [
            'genusForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/genus/{id}/edit", name="admin_genus_edit")
     */
    public function editAction(Request $request, Genus $genus)
    {
        $form = $this->createForm(GenusFormType::class, $genus);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            
            $this->addFlash('success', 'Genus ' . $data->getName() . ' updated!');
            return $this->redirectToRoute('admin_genus_list');
        }
        
        return $this->render('admin/genus/edit.html.twig', [
            'genusForm' => $form->createView()
        ]);
    }
}