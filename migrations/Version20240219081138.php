<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219081138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscrire ADD id INT AUTO_INCREMENT NOT NULL, CHANGE idOffre idOffre INT DEFAULT NULL, CHANGE idUser idUser INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscrire MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON inscrire');
        $this->addSql('ALTER TABLE inscrire DROP id, CHANGE idOffre idOffre INT NOT NULL, CHANGE idUser idUser INT NOT NULL');
        $this->addSql('ALTER TABLE inscrire ADD PRIMARY KEY (idOffre, idUser)');
    }
}
