<?php


namespace App\Controller;


use App\Entity\Medico;
use App\Helper\MedicoFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MedicoRepository;


class MedicoController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var MedicoFactory
     */
    private $medicoFactory;
    /**
     * @var MedicoRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, MedicoFactory $medicoFactory, MedicoRepository $repository)
    {
        $this->entityManager = $entityManager;

        $this->medicoFactory = $medicoFactory;
        $this->repository = $repository;
    }

    /**
     * @Route("/medicos", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();

        $medico = $this->medicoFactory->criarMedico($corpoRequisicao);

        $this->entityManager->persist($medico);
        $this->entityManager->flush();

        return new JsonResponse($medico);
    }

    /**
     * @Route("/medicos", methods={"GET"})
     */
    public function buscarTodos():Response
    {

        $medicoList = $this->repository->findAll();

        return new JsonResponse($medicoList);
    }

    /**
     * @Route("/medicos/{id}", methods={"GET"})
     */
    public function buscarUM(Request $request): Response
    {
        $id = $request->get('id');

        $medico = $this->buscarMedico($id);

        $codigoRetorno = is_null($medico) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($medico, $codigoRetorno);
    }

    /**
     * @Route("/medicos/{id}", methods={"PUT"})
     */
    public function atualizar(Request $request): Response
    {
        $id = $request->get('id');

        $medico = $this->medicoFactory->criarMedico($request->getContent());

        $medicoExistente = $this->buscarMedico($id);

        $medicoExistente->crm = $medico->getCrm();
        $medicoExistente->nome = $medico->getNome();

        $this->entityManager->flush();

        if(is_null($medicoExistente)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse( $medicoExistente);
    }

    /**
     * @Route("medicos/{id}", methods={"DELETE"})
     */
    public function deletar(int $id): Response
    {
        $medico = $this->buscarMedico($id);
        $this->entityManager->remove($medico);

        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/especialidade/{especialidadeID}/medicos", methods={"GET"})
     */
    public function buscarPorEspecialdiade(int $especialidadeID): Response
    {
        $medicos = $this->repository->findBy([
           "especialidade" => $especialidadeID
        ]);

        return new JsonResponse($medicos);
    }
    public function buscarMedico($id)
    {

        $medico = $this->repository->find($id);

        return $medico;
    }
}