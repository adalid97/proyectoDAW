<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200428174056 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE partido (id INT AUTO_INCREMENT NOT NULL, id_equipo_local_id INT DEFAULT NULL, id_equipo_visitante_id INT DEFAULT NULL, tipo VARCHAR(255) NOT NULL, estadio VARCHAR(255) NOT NULL, fecha DATE NOT NULL, hora TIME NOT NULL, hora_apertura_sede TIME NOT NULL, INDEX IDX_4E79750B61298DFB (id_equipo_local_id), INDEX IDX_4E79750BCACEACDA (id_equipo_visitante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750B61298DFB FOREIGN KEY (id_equipo_local_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BCACEACDA FOREIGN KEY (id_equipo_visitante_id) REFERENCES partido (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BCACEACDA');
        $this->addSql('DROP TABLE partido');
    }
}
