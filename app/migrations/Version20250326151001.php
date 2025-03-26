<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250326151001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE enemy (id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)', name VARCHAR(50) NOT NULL, type VARCHAR(255) NOT NULL, energy INT NOT NULL, damage INT NOT NULL, fire_rate DOUBLE PRECISION NOT NULL, speed DOUBLE PRECISION NOT NULL, visual VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE tower (id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)', name VARCHAR(50) NOT NULL, type VARCHAR(255) NOT NULL, energy INT NOT NULL, damage INT NOT NULL, fire_rate DOUBLE PRECISION NOT NULL, max_enemies INT NOT NULL, visual VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE enemy
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE tower
        SQL);
    }
}
