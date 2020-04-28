<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200428174331 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BCACEACDA');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BCACEACDA FOREIGN KEY (id_equipo_visitante_id) REFERENCES equipo (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BCACEACDA');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BCACEACDA FOREIGN KEY (id_equipo_visitante_id) REFERENCES partido (id)');
    }
}
