<?php

namespace App\Helper;

use App\Entity\Medico;
use App\Repository\EspecialidadeRepository;

class MedicoFactory
{
    /**
     * @var EspecialidadeRepository
     */
    private $especialidadeRepository;

    public function __construct(EspecialidadeRepository $especialidadeRepository)
    {

        $this->especialidadeRepository = $especialidadeRepository;
    }

    public function criarMedico(string $json): Medico
    {
        $dadosJson = json_decode($json);

        $especialidade = $this->especialidadeRepository->find($dadosJson->especialidade);

        $medico = new Medico();
        $medico->setNome($dadosJson->nome);
        $medico->setCrm($dadosJson->crm);
        $medico->setEspecialidade($especialidade);

        return $medico;
    }
}