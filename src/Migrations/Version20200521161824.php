<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200521161824 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE notificacion DROP FOREIGN KEY FK_729A19EC8ADF0A3C');
        $this->addSql('DROP INDEX IDX_729A19EC8ADF0A3C ON notificacion');
        $this->addSql('ALTER TABLE notificacion DROP id_socio_id');
        $this->addSql('ALTER TABLE socio CHANGE telefono telefono VARCHAR(9) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE notificacion ADD id_socio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notificacion ADD CONSTRAINT FK_729A19EC8ADF0A3C FOREIGN KEY (id_socio_id) REFERENCES socio (id)');
        $this->addSql('CREATE INDEX IDX_729A19EC8ADF0A3C ON notificacion (id_socio_id)');
        $this->addSql('ALTER TABLE socio CHANGE telefono telefono VARCHAR(9) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
