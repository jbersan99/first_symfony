<?php

namespace App\Controller;

use App\Entity\Subject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class SubjectController extends AbstractController
{
    /**
     * @Route("/new_subject/{name_subject}", name="create_subject")
     */
    public function index(ManagerRegistry $doctrine, string $name_subject): Response
    {
        $subject = new Subject();
        $subject->setName($name_subject);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($subject);
        $entityManager->flush();

        return new Response(
            'Subject saved named: '.$subject->getName()
        );
    }

    /**
     * @Route("/show_subject/{id}", name="show_subject")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $subject = $doctrine->getRepository(Subject::class)->find($id);

        return new Response('Subject with id '. $subject->getId(). ' named '. $subject->getName());
    }

    /**
     * @Route("/subject_student/{id}", name="student_has_subject")
     */
    public function showStudentSubject(ManagerRegistry $doctrine, int $id): Response
    {
        $subject = $doctrine->getRepository(Subject::class)->find($id);

        $students = $subject->getStudents();

        return $this->render('student/subjects.html.twig', array(
            'students' => $students,
            'subject' => $subject
        ));
    }

    /**
     * @Route("/subjects", name="all_subjects")
     */
    public function showStudents(ManagerRegistry $doctrine): Response
    {
        $subjects = $doctrine->getRepository(Subject::class)->findAll();

        return $this->render('subject/index.html.twig', array(
            'subjects' => $subjects,
        ));
    }
}
