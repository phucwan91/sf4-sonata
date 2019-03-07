<?php
/**
 * Created by PhpStorm.
 * User: phucvo
 * Date: 3/5/19
 * Time: 4:48 PM.
 */

namespace App\Admin;

use App\Entity\Author;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProjectAdmin extends AbstractAdmin
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
           ->addIdentifier('id', TextType::class)
           ->add('name', TextType::class, [
               'label' => 'admin.project.name',
           ])
           ->add('description', TextType::class, [
               'label'        => 'admin.project.description',
               'header_style' => 'width: 50%',
           ])
           ->add('author', TextType::class, [
               'label' => 'admin.project.author',
           ])
       ;
    }

    public function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name', TextType::class, [
                'label' => 'admin.project.name',
            ])
            ->add('description', TextareaType::class, [
                'label'    => 'admin.project.description',
                'required' => false,
            ])
            ->add('author', EntityType::class, [
                'label'    => 'admin.project.author',
                'class'    => Author::class,
                'multiple' => false,
            ])
        ;
    }
}
