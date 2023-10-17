<?php
use BlazePHP\Blaze\Database\Table;

class m001_create_users_table
{
    public function up(\PDO $pdo)
    {
        $table = new Table("users");
        $table->varchar("name");
        $table->varchar("email");
        $table->varchar("password");
        $table->created_at();
    }

    public function down(\PDO $pdo)
    {
        $pdo->exec('DROP TABLE IF EXISTS users');
    }
}