<?php
class Piloto
{
    public function __construct(
        public string $nome,
        public string $sigla,
        public string $nacionalidade,
        public string $equipe,
        public string $licenca,
        public string $bio,
        public string $nascimento,
        public int $numeroCarro,
        public int $titulos,
    ) {}

    public function getEquipeFormatada(): string
    {
        return ucwords(str_replace('_', ' ', $this->equipe));
    }

    public function getIdade(): int
    {
        try {
            $dataNasc = new DateTime($this->nascimento);
            $hoje = new DateTime();
            return $hoje->diff($dataNasc)->y;
        } catch (Exception $e) {
            return 0;
        }
    }
}
