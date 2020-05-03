<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200503143732 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cuota ADD enero TINYINT(1) DEFAULT \'0\', ADD febrero TINYINT(1) DEFAULT \'0\', ADD marzo TINYINT(1) DEFAULT \'0\', ADD abril TINYINT(1) DEFAULT \'0\', ADD mayo TINYINT(1) DEFAULT \'0\', ADD junio TINYINT(1) DEFAULT \'0\', ADD julio TINYINT(1) DEFAULT \'0\', ADD agosto TINYINT(1) DEFAULT \'0\', ADD septiembre TINYINT(1) DEFAULT \'0\', ADD octubre TINYINT(1) DEFAULT \'0\', ADD noviembre TINYINT(1) DEFAULT \'0\', ADD diciembre TINYINT(1) DEFAULT \'0\', DROP importe');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cuota ADD importe INT NOT NULL, DROP enero, DROP febrero, DROP marzo, DROP abril, DROP mayo, DROP junio, DROP julio, DROP agosto, DROP septiembre, DROP octubre, DROP noviembre, DROP diciembre');
    }
}
