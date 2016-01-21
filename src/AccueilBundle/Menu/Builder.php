<?php
// src/AccueilBundle/Menu/Builder.php
namespace AccueilBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        
        $menu = $factory->createItem('root');

        $menu->addChild('Accueil', array('route' => 'homepage'));

        // access services from the container!
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $listItem = $em->getRepository('AccueilBundle:Project')->findAll();
        
        foreach($listItem as $item){
            $menu->addChild(
                $item->getName(),
                array(
                 'route' => 'accueil_projets',
                 'routeParameters' => array('id' => $item->getId())
                )
            );
        }

        return $menu;
    }
}