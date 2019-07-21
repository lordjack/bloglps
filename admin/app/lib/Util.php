<?php
/**
 * Created by PhpStorm.
 * User: Tutor
 * Date: 02/10/2018
 * Time: 19:32
 */

namespace Functions\Util;

use Adianti\Database\TCriteria;
use Adianti\Database\TFilter;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;

class Util
{

    static function onCheckFeaturePage($feature)
    {

        try {

            TTransaction::open('blog');

            $repositoryCP = new TRepository('Feature');

            $criteriaCP = new TCriteria();

            $criteriaCP->add(new TFilter('name', '=', strtolower($feature)));

            $count = $repositoryCP->count($criteriaCP);

            $check = false;
            if ($count > 0) {
                $check = true;
            }

            return $check;
            TTransaction::close(); // fecha a transação.
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }

    }

    public function getPaginas()
    {
        try {
            TTransaction::open('blog');

            $repositoryCP = new TRepository('FeaturePage');

            $criteriaCP = new TCriteria();
            $criteriaCP->setProperty('order', 'name');

            $objects = $repositoryCP->load($criteriaCP);
            TTransaction::close();
            if ($objects) {

                $arrayPage = [];
                TTransaction::open('blog');
                $conn = TTransaction::get();
                foreach ($objects as $object) {

                    $sth = $conn->prepare("SELECT p.nome, p.arquivo FROM pagina p WHERE p.arquivo = ?");

                    $sth->execute([$object->controller]);

                    while ($row = $sth->fetchObject()) {
                        $arrayPage[$row->arquivo] = $row->nome;
                    }
                }

                $sthGU = $conn->prepare("SELECT p.arquivo, p.nome FROM pagina p where p.modulo_id IN (select m.id from modulo m where m.nome = 'GU')");

                $sthGU->execute();

                while ($rowGU = $sthGU->fetchObject()) {
                    $arrayPage[$rowGU->arquivo] = $rowGU->nome;
                }

                TTransaction::close();

                return $arrayPage;
            }
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }

    }

    static function tagCloud($tags, $max)
    {
        $total = 0;
        $maior = 0;
        $retorno = "";
        for ($i = 0; $tags[$i]; $i++) {
            $exp = explode(":", $tags[$i]);
            $tag[$i] = $exp[0];
            $qnt[$i] = $exp[1];
            $total = $total + $qnt[$i];

            if ($qnt[$i] > $maior) $maior = $qnt[$i];
        }
        for ($i = 0; $tag[$i]; $i++) {
            $size = round($max * $qnt[$i] / $maior);
            $menor = $max / 3;
            if ($size < $menor) $size = $menor;
            $retorno .= "<span style='font-size:$size" . "px'>$tag[$i]</span>&nbsp; ";
        }
        return $retorno;
    }
}