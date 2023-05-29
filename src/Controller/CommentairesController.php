<?php

namespace App\Controller;

// use App\Entity\Commentaires;

use App\Entity\Photos;
use App\Entity\Commentaires;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CommentairesController extends AbstractController
{

    /**
     * @Route("/{order?null}/{note?null}", name="home")
     */

    public function create(Request $request, CommentairesRepository $repo, EntityManagerInterface $manager, SluggerInterface $slugger, $order, $note)
    {
        unset($form);

        // if ($order) {
        //     dump($order);
        // }

        // $comments = $repo->findBy([], ['creation_date' => 'DESC']);
        // if ($order == 'date') {
        //     $comments = $repo->findBy([], ['creation_date' => 'ASC']);
        // } elseif ($order == 'note') {
        //     $comments = $repo->findBy([], ['note' => 'DESC']);
        // } elseif ($order == 'noteinverse') {
        //     $comments = $repo->findBy([], ['note' => 'ASC']);
        // }

        $ordre = ['creation_date' => 'ASC'];
        if ($order == 'null') {
            $ordre = ['creation_date' => 'DESC'];
        } elseif ($order == 'note') {
            $ordre = ['note' => 'DESC'];
        } elseif ($order == 'noteinverse') {
            $ordre = ['note' => 'ASC'];
        }



        if (intval($note) >= 1 && intval($note) <= 5) {
            $comments = $repo->findBy(['note' => intval($note)], $ordre);
        } else {
            $comments = $repo->findBy([], $ordre);
        }

        // if ($order) {
        //     dump($comments);
        // }



        $comment = new Commentaires();
        $photo1 = new Photos();
        $photo2 = new Photos();
        $photo3 = new Photos();
        $photo4 = new Photos();
        $photo5 = new Photos();
        $comment->setVisible(true);
        $comment->setCreationDate(new \dateTime);


        $form = $this->createFormBuilder($comment)
            ->add('titre', TextType::class, [
                'attr' => [
                    'placeholder' => 'Titre du commentaire',
                ]
            ])
            ->add('texte', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'contenu du commentaire',
                ]
            ])
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'placeholder' => 'Pseudo',
                ]
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'placeholder' => 'email',
                ]
            ])
            ->add('note', HiddenType::class, [
                'attr' => [
                    'placeholder' => 'note',
                ]
            ])
            ->add('photos1', FileType::class, [
                'label' => 'Photos (en JPG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('photos2', FileType::class, [
                'label' => 'Photos (en JPG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('photos3', FileType::class, [
                'label' => 'Photos (en JPG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('photos4', FileType::class, [
                'label' => 'Photos (en JPG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('photos5', FileType::class, [
                'label' => 'Photos (en JPG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setCreationDate(new \dateTime);
            $comment->setVisible(true);

            for ($i = 1; $i <= 5; $i++) {
                ${"Picture" . $i} = $form->get('photos' . $i)->getData();
            }

            for ($i = 1; $i <= 5; $i++) {
                $picture = ${"Picture" . $i};
                if ($picture) {
                    $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                    // changement du nom de la photo
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();

                    // copie de la photo dans le bon répertoire (public/image/)
                    try {
                        $picture->move(
                            $this->getParameter('photoDirectory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                    }
                    //set Link pour retrouver le chemin des images dans la base de donnée
                    ${"photo" . $i}->setLink($newFilename);
                }
            }

            for ($i = 1; $i <= 5; $i++) {

                if (${"Picture" . $i}) {

                    $photo = (${"photo" . $i});
                    dump(${"Picture" . $i});
                    ($photo)->setCommentaireId($comment);
                    $manager->persist($photo);
                }
            }
            $manager->persist($comment);
            $manager->flush();
            return $this->redirect($request->getUri());
        }

        return $this->render('commentaires/index.html.twig', [
            'controller_name' => 'CommentairesController',
            'commentaires' => $comments,
            'order' => $order,
            'note' => $note,
            'formCommentaire' => $form->createview()
        ]);
    }
}
