<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Helper\EspecialidadeFactory;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspecialidadeController extends BaseController
{

    public function __construct(EntityManagerInterface $entityManager, EspecialidadeRepository $repository, EspecialidadeFactory $factory)
    {
        parent::__construct($repository, $entityManager, $factory);
    }

    /**
     * @param Especialidade $entidadeEnviada
     * @param Especialidade $entidadeExistente
     */
    public function atualizaEntidade($entidadeEnviada, $entidadeExistente)
    {
        $entidadeExistente->setDescricao($entidadeEnviada->getDescricao());
    }
}
