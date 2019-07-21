<?php

class Product extends TRecord
{
	const TABLENAME = 'cf_product';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'serial'; // {max, serial}
}