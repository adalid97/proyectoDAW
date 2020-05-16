<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200516110052 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cuota (id INT AUTO_INCREMENT NOT NULL, id_socio_id INT DEFAULT NULL, ano INT NOT NULL, enero TINYINT(1) DEFAULT \'0\', febrero TINYINT(1) DEFAULT \'0\', marzo TINYINT(1) DEFAULT \'0\', abril TINYINT(1) DEFAULT \'0\', mayo TINYINT(1) DEFAULT \'0\', junio TINYINT(1) DEFAULT \'0\', julio TINYINT(1) DEFAULT \'0\', agosto TINYINT(1) DEFAULT \'0\', septiembre TINYINT(1) DEFAULT \'0\', octubre TINYINT(1) DEFAULT \'0\', noviembre TINYINT(1) DEFAULT \'0\', diciembre TINYINT(1) DEFAULT \'0\', INDEX IDX_763CCB0F8ADF0A3C (id_socio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cuota ADD CONSTRAINT FK_763CCB0F8ADF0A3C FOREIGN KEY (id_socio_id) REFERENCES socio (id)');
        $this->addSql('ALTER TABLE socio DROP FOREIGN KEY FK_38B653098ADF0A3C');
        $this->addSql('DROP INDEX IDX_38B653098ADF0A3C ON socio');
        $this->addSql('ALTER TABLE socio DROP id_socio_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_38B653097F35E27F ON socio (num_socio)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_38B653097F8F253B ON socio (dni)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cuota');
        $this->addSql('DROP INDEX UNIQ_38B653097F35E27F ON socio');
        $this->addSql('DROP INDEX UNIQ_38B653097F8F253B ON socio');
        $this->addSql('ALTER TABLE socio ADD id_socio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE socio ADD CONSTRAINT FK_38B653098ADF0A3C FOREIGN KEY (id_socio_id) REFERENCES socio (id)');
        $this->addSql('CREATE INDEX IDX_38B653098ADF0A3C ON socio (id_socio_id)');
    }
}
