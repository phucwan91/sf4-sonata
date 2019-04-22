<?php
/**
 * Created by PhpStorm.
 * User: phucvo
 * Date: 3/5/19
 * Time: 4:48 PM.
 */

namespace App\Admin;

use App\Entity\Project;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\UserBundle\Admin\Entity\UserAdmin as BaseUserAdmin;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AuthorAdmin extends BaseUserAdmin
{
    protected $translationDomain = 'admin';

    /**
     * {@inheritdoc}
     */
    public function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);

        $collection->remove('export');
    }

    /**
     * {@inheritdoc}
     */
    public function configureBatchActions($actions)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function configureListFields(ListMapper $list): void
    {
        $list
           ->addIdentifier('email', EmailType::class, [
               'label' => 'admin.author.email',
           ])
           ->add('fullName', TextType::class, [
                'label' => 'admin.author.name',
            ])
           ->add('projects', TextType::class, [
               'label' => 'admin.author.projects',
           ])
       ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('email', EmailType::class, [
                'label' => 'admin.author.email',
            ])
            ->add('fullName', TextType::class, [
                'label' => 'admin.author.name',
            ])
            ->add('projects', EntityType::class, [
                'label'    => 'admin.author.projects',
                'class'    => Project::class,
                'multiple' => true,
            ])
        ;
    }
}
