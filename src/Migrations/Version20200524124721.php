<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200524124721 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE solicitud_entrada (id INT AUTO_INCREMENT NOT NULL, socio_id INT NOT NULL, entrada_id INT NOT NULL, INDEX IDX_EDDFD1F5DA04E6A9 (socio_id), INDEX IDX_EDDFD1F5A688222A (entrada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE solicitud_entrada ADD CONSTRAINT FK_EDDFD1F5DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id)');
        $this->addSql('ALTER TABLE solicitud_entrada ADD CONSTRAINT FK_EDDFD1F5A688222A FOREIGN KEY (entrada_id) REFERENCES entrada (id)');
        $this->addSql('ALTER TABLE entrada DROP FOREIGN KEY FK_C949A274DA04E6A9');
        $this->addSql('DROP INDEX IDX_C949A274DA04E6A9 ON entrada');
        $this->addSql('ALTER TABLE entrada DROP socio_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE solicitud_entrada');
        $this->addSql('ALTER TABLE entrada ADD socio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entrada ADD CONSTRAINT FK_C949A274DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id)');
        $this->addSql('CREATE INDEX IDX_C949A274DA04E6A9 ON entrada (socio_id)');
    }
}
