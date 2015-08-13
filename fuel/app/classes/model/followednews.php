<?php

class Model_Followednews extends \Orm\Model
{

	protected static $_properties = array(
    'id',
    'sender',
    'receiver',
    'sender_img',
    'create_at',
	);
	protected static $_table_name = 'followed_news';



}