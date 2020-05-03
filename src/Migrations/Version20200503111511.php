<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200503111511 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cuota (id INT AUTO_INCREMENT NOT NULL, id_socio_id INT DEFAULT NULL, año INT NOT NULL, importe INT NOT NULL, INDEX IDX_763CCB0F8ADF0A3C (id_socio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cuota ADD CONSTRAINT FK_763CCB0F8ADF0A3C FOREIGN KEY (id_socio_id) REFERENCES socio (id)');
        $this->addSql('ALTER TABLE socio ADD id_socio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE socio ADD CONSTRAINT FK_38B653098ADF0A3C FOREIGN KEY (id_socio_id) REFERENCES socio (id)');
        $this->addSql('CREATE INDEX IDX_38B653098ADF0A3C ON socio (id_socio_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cuota');
        $this->addSql('ALTER TABLE socio DROP FOREIGN KEY FK_38B653098ADF0A3C');
        $this->addSql('DROP INDEX IDX_38B653098ADF0A3C ON socio');
        $this->addSql('ALTER TABLE socio DROP id_socio_id');
    }
}
