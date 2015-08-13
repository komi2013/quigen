<?php

class Model_Follow extends \Orm\Model
{

	protected static $_properties = array(
    'id',
    'sender',
    'receiver',
    'create_at',
	);
	protected static $_table_name = 'follow';

}