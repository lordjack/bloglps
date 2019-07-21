<?php

/**
 * SlideShow Active Record
 * @author  <your-name-here>
 */
class SlideShow extends TRecord
{
    const TABLENAME = 'slideshow';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'serial'; // {max, serial}

    static public function getFirst()
    {
        $conn = TTransaction::get(); // get PDO connection

        // run query
        $result = $conn->query('SELECT min(id) as min from slideshow');

        // show results 
        foreach ($result as $row) {
            return $row['min'];
        }
    }

    static public function listAll()
    {
        $repos = new TRepository('SlideShow');

        $criteria = new \Adianti\Database\TCriteria();

        $criteria->add(new \Adianti\Database\TFilter('published', '=', 'S'));

        return $repos->load($criteria);
    }
}