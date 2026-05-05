<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
$pdo->exec('CREATE DATABASE IF NOT EXISTS fan_company CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
echo "Database 'fan_company' created successfully.\n";
