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
