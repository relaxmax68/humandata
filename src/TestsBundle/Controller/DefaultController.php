<?php

namespace TestsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use TestsBundle\Form\TestType;
use TestsBundle\Entity\Test;

use ADesigns\CalendarBundle\Entity\EventEntity;
use ADesigns\CalendarBundle\Event\CalendarEvent;

use BigButtonBundle\Repository;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TestsBundle:Default:index.html.twig');
    }
    public function transitionAction()
    {
        return $this->render('TestsBundle:Tests:transition.html.twig');
    }
    public function structureAction()
    {
        return $this->render('TestsBundle:Tests:structure.html.twig');
    }
    // affiche tous les cookies enregistrés par le site
    public function cookiesAction()
    {
        $request = Request::createFromGlobals();

        $cookies = var_dump($request->cookies);

        return $this->render('TestsBundle:Tests:cookies.html.twig',array('cookies'=>$cookies));
    }
    // affiche le header envoyé par le site
    public function headerAction()
    {
        $request = Request::createFromGlobals();

        // the URI being requested (e.g. /about) minus any query parameters
        $content=$request->getPathInfo();

        return $this->render('TestsBundle:Tests:header.html.twig',array('request'=>$request,'content'=>$content));
    }
    public function menuAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tests = new Test();

        $form = $this->createForm(TestType::class,$tests);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tests);
            $em->flush();
        }

        var_dump($tests);
        return $this->render('TestsBundle:Tests:menu.html.twig',array('tests'=>$tests,'form' => $form->createView()));
    }
    public function tabAction()
    {
        return $this->render('TestsBundle:Tests:tab.html.twig');
    }
    public function calendarAction()
    {
       return $this->redirectToRoute('calendar_event_list_by_day',array('day'=>'26','month'=>'03','year'=>'2016'));
    }
    public function sqlAction()
    {
        $user=$this->getdoctrine()->getRepository('BigButtonBundle:User')->findOneByipAddress($this->container->get('accueil.ip.listener')->getVisite()->getIpAddress());

        $results=$this->getdoctrine()->getRepository('BigButtonBundle:Tap')->lastUserIdTap($user);

        return $this->render('TestsBundle:Tests:sql.html.twig',array('results'=>$results));
    }
    public function jsAction()
    {
        return $this->render('TestsBundle:Tests:js.html.twig');
    }
}
