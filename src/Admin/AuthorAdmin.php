<?php
/**
 * Created by PhpStorm.
 * User: phucvo
 * Date: 3/5/19
 * Time: 4:48 PM.
 */

namespace App\Admin;

use App\Entity\Project;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AuthorAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $translationDomain = 'admin';

    /**
     * {@inheritdoc}
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['show', 'edit', 'delete', 'list']);
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
    public function configureListFields(ListMapper $list)
    {
        $list
           ->addIdentifier('email', EmailType::class, [
               'label' => 'admin.author.email',
           ])
           ->add('name', TextType::class, [
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
    public function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name', TextType::class, [
                'label' => 'admin.author.name',
            ])
            ->add('email', EmailType::class, [
                'label' => 'admin.author.email',
            ])
            ->add('projects', EntityType::class, [
                'label'    => 'admin.author.projects',
                'class'    => Project::class,
                'multiple' => true,
            ])
        ;
    }
}
