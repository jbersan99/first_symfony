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
     * @Route("/new_student/{name_student}", name="create_student")
     */
    public function index(ManagerRegistry $doctrine, string $name_student): Response
    {
        $student = new Student();
        $student->setName($name_student);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($student);
        $entityManager->flush();

        return new Response(
            'Student saved named: '.$student->getName()
        );
    }

    /**
     * @Route("/show_student/{id}", name="show_student")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $student = $doctrine->getRepository(Student::class)->find($id);

        return new Response('Student with id '. $student->getId(). ' named '. $student->getName());
    }

    /**
     * @Route("/student_add_subject/{id_student}/{id_subject}", name="add_subject_to_student")
     */
    public function addSubject(ManagerRegistry $doctrine, int $id_student, int $id_subject): Response
    {
        $student = $doctrine->getRepository(Student::class)->find($id_student);

        $subject = $doctrine->getRepository(Subject::class)->find($id_subject);

        $student->addSubject($subject);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($student);
        $entityManager->flush();

        return new Response('Student with name '. $student->getName(). ' has the subject '. $subject->getName());
    }

    /**
     * @Route("/students", name="all_students")
     */
    public function showStudents(ManagerRegistry $doctrine): Response
    {
        $students = $doctrine->getRepository(Student::class)->findAll();

        return $this->render('student/index.html.twig', array(
            'students' => $students,
        ));
    }
}
