<?php
switch (true) {
	case 1:
		echo 'indented';
		break;
	case 2:
	echo 'not indented';
	break;
	case 3: case 4:
		echo 'multiple cases';
		break;
    case 5;
	default:
	echo 'default case';
	break;
}

switch(TRUE) {
	case TRUE:
		return TRUE;
	case FALSE:
		return FALSE;
	default:
		return 'pie';
}

switch(TRUE) 
{

	case 'something':
		echo 'hahaha';

		break;
}
