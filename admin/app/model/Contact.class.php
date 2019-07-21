<?php
/**
 * Contact Active Record
 * @author  <your-name-here>
 */
class Contact extends TRecord
{
    const TABLENAME = 'contact';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    static public function getFirst()
    {
        $conn = TTransaction::get(); // get PDO connection
            
        // run query
        $result = $conn->query('SELECT min(id) as min from contact');
        
        // show results 
        foreach ($result as $row) 
        { 
            return $row['min']; 
        } 
    }
    
    static public function listAll()
    {
        $repos = new TRepository('Contact');
        return $repos->load(new TCriteria);
    }
}