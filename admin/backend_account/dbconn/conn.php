<?php

$conn = mysqli_connect("localhost", "root", "", "game_os");

if (!$conn) {
    echo "Connection Failed";
}