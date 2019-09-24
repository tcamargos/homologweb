<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspecialidadeController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var EspecialidadeRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, EspecialidadeRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Route("/especialidade", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        $especilidadeEnviada =  json_decode($request->getContent());

        $especialidade = new Especialidade();

        $especialidade->setDescricao($especilidadeEnviada->descricao);

        $this->entityManager->persist($especialidade);
        $this->entityManager->flush();

        return new JsonResponse($especialidade);
    }
    /**
     * @Route("/especialidade", methods={"GET"})
     */
    public function buscarTodas(): Response
    {
        $listaEspecialidade = $this->repository->findAll();

        return new JsonResponse($listaEspecialidade);
    }
    /**
     * @Route("/especialidade/{id}", methods={"GET"})
     */
    public function buscarUm(int $id): Response
    {
        $especialidade = $this->repository->find($id);

        return new JsonResponse($especialidade);
    }
    /**
     * @Route("/especialidade/{id}", methods={"PUT"})
     */
    public function update(Request $request, int $id): Response
    {
        $dados = json_decode($request->getContent());

        $especialidade = $this->repository->find($id);

        $especialidade->setDescricao($dados->descricao);

        $this->entityManager->flush();

        return new JsonResponse($especialidade);
    }
    /**
     * @Route("/especialidade/{id}", methods={"DELETE"})
     */
    public function deletar(int $id):Response
    {
        $especialidade = $this->repository->find($id);

        $this->entityManager->remove($especialidade);

        $this->entityManager->flush();

        return new JsonResponse('', Response::HTTP_NO_CONTENT);
    }
}
