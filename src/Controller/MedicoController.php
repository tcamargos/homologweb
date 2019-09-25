<?php


namespace App\Controller;


use App\Entity\Medico;
use App\Helper\MedicoFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MedicoRepository;


class MedicoController extends BaseController
{

    public function __construct(EntityManagerInterface $entityManager, MedicoFactory $medicoFactory, MedicoRepository $repository)
    {
        parent::__construct($repository, $entityManager, $medicoFactory);
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

    /**
     * @param Medico $entidadeEnviada
     * @param Medico $entidadeExistente
     */
    public function atualizaEntidade($entidadeEnviada, $entidadeExistente)
    {
        $entidadeExistente->setNome($entidadeEnviada->getNome());
        $entidadeExistente->setEspecialidade(($entidadeEnviada->getEspecialidade()));
        $entidadeExistente->setCrm($entidadeEnviada->getCrm());
    }
}