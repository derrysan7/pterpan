<?php
$int = "asdasd";

if (filter_var($int, FILTER_VALIDATE_INT)) {
    echo("Variable is an integer");
} else {
    echo("Variable is not an integer");
}
 ?>
