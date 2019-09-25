<?php

namespace App\Controller;


use App\Helper\EntidadeFactory;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


abstract class BaseController extends AbstractController
{
    /**
     * @var ObjectRepository
     */
    protected $repository;
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var EntidadeFactory
     */
    private $factory;

    public function __construct(ObjectRepository $repository, EntityManagerInterface $entityManager, EntidadeFactory $factory)
    {

        $this->repository = $repository;
        $this->entityManager = $entityManager;

        $this->factory = $factory;
    }
    public function novo(Request $request): Response
    {
        $dados =  $request->getContent();

        $entidade = $this->factory->criarEntidade($dados);

        $this->entityManager->persist($entidade);
        $this->entityManager->flush();

        return new JsonResponse($entidade);
    }
    public function buscarTodos():Response
    {

        $lista = $this->repository->findAll();

        return new JsonResponse($lista);
    }
    public function buscarUM(Request $request): Response
    {
        $id = $request->get('id');
        $entidade = $this->repository->find($id);
        $codigoRetorno = is_null($entidade) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($entidade, $codigoRetorno);
    }
    public function deletar(int $id): Response
    {
        $entidade = $this->repository->find($id);
        $this->entityManager->remove($entidade);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
    public function update(Request $request, int $id): Response
    {
        $dados = $request->getContent();
        $entidadeEnviada = $this->factory->criarEntidade($dados);
        $entidadeExistente = $this->repository->find($id);
        $this->atualizaEntidade($entidadeEnviada, $entidadeExistente);
        $this->entityManager->flush();

        return new JsonResponse($entidadeExistente);
    }
    public abstract function atualizaEntidade($entidadeEnviada, $entidadeExistente);
}
