<?php

namespace App\Form;

use App\Entity\User;
use Presta\ImageBundle\Form\Type\ImageType;
use Presta\ImageBundle\Model\AspectRatio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Cropperjs\Factory\CropperInterface;
use Symfony\UX\Cropperjs\Form\CropperType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add('name')
            ->add('username')
            ->add('profileFile', ImageType::class, [
                'required' => false,
                'allow_delete' => true,
//                'delete_label' => 'esborrar imatge',
                //              'download_label' => 'descarregar imatge',
//                'download_uri' => true,
//                'image_uri' => true,
//                'imagine_pattern' => '...',
//                'asset_helper' => true,

                'aspect_ratios' => [
                    new AspectRatio(1, "1"),
                    new AspectRatio(16/9, '16:9')
                ],
                'cropper_options' => [
                    'autoCropArea' => 1,
                    'dragMode' => 'move',
                    'minCroppedWidth' => 400,
                    'minCroppedHeight' => 400,
                    'min_width' => 400,
                    'min_height' => 400,
                    'minCanvasWidth' => 400,
                    'minCanvasHeight' => 400,
                    'minContainerWidth' => 400,
                    'minContainerHeight' => 400,

                ],
                'max_width' => 1024,
                'max_height' => 1024,
                'preview_width' => '400px',
                'preview_height' => '400px',
                //'upload_button_class' => 'btn btn-sm btn-primary',
                'upload_button_icon' => 'bi bi-upload',
                //'cancel_button_class' => 'btn btn-default',
                //'save_button_class' => 'btn btn-primary',
                //'download_uri' => null,
                //'download_link' => true,
                //'enable_locale' => true,
                'enable_remote' => false,
                'upload_mimetype' => 'image/jpeg',
                //'upload_quality' => 0.92,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
