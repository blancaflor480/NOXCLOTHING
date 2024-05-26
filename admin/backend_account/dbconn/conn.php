<?php

$conn = mysqli_connect("localhost", "root", "", "noxclothing");

if (!$conn) {
    echo "Connection Failed";
}