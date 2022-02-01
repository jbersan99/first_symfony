<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TaskType;
use App\Entity\Task;
use Doctrine\Persistence\ManagerRegistry;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="tasks")
     */
    public function showTasks(ManagerRegistry $doctrine): Response
    {
        $tasks = $doctrine->getRepository(Task::class)->findAll();

        return $this->render('task/index.html.twig', array(
            'tasks' => $tasks,
        ));
    }

    /**
     * @Route("/new_task", name="new_task")
     */
    public function new(ManagerRegistry $doctrine, Request $request): Response
    {

        $task = new Task();
        /* $task->setName('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));
        $task->setType('PDF'); */

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('tasks');
        }

        return $this->renderForm('task/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/edit_task/{id}", name="edit_task")
     */
    public function edit(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $task = $doctrine->getRepository(Task::class)->find($id);

        $task->setName($task->getName());
        $task->setDueDate($task->getDueDate());
        $task->setType($task->getType());

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('tasks');
        }

        return $this->renderForm('task/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/remove_task/{id}", name="remove_task")
     */
    public function removeTask(ManagerRegistry $doctrine, int $id): Response
    {
        $task = $doctrine->getRepository(Task::class)->find($id);

        $entityManager = $doctrine->getManager();
        $entityManager->remove($task);
        $entityManager->flush();

        return $this->redirectToRoute('tasks');
    }
}
