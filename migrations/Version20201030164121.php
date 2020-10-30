<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201030164121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'user migration';
    }

    public function up(Schema $schema): void
    {
        $user = $schema->createTable('user');
        $user->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $user->addColumn('username', 'string', ['length' => 100]);
        $user->addColumn('password', 'string', ['length' => 100]);
        $user->addUniqueIndex(['username']);
        $user->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('user');
    }
}