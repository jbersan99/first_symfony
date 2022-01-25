<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Student;
use App\Entity\Subject;

class StudentController extends AbstractController
{
    /**
     * @Route("/student_subject", name="product")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $subject = new Subject();
        $subject->setName('Maths');

        $student = new Student();
        $student->setName('Manolo');

        // relates this product to the category
        //$student->setStudentSubject($subject->getName());

        $entityManager = $doctrine->getManager();
        $entityManager->persist($student);
        $entityManager->persist($subject);
        $entityManager->flush();

        return new Response(
            'Saved new student with name: '.$student->getName()
            .' and new subject with name: '.$subject->getName()
        );
    }
}
