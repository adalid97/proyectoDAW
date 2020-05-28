<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200528101450 extends AbstractMigration
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
        $this->addSql('CREATE TABLE entrada (id INT AUTO_INCREMENT NOT NULL, partido_id INT NOT NULL, precio INT NOT NULL, publico TINYINT(1) DEFAULT \'0\', UNIQUE INDEX UNIQ_C949A27411856EB4 (partido_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE noticia (id INT AUTO_INCREMENT NOT NULL, titular VARCHAR(255) NOT NULL, entrada VARCHAR(255) NOT NULL, cuerpo VARCHAR(9999) NOT NULL, imagen VARCHAR(255) NOT NULL, fecha DATE NOT NULL, localidad VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notificacion (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telefono VARCHAR(9) NOT NULL, mensaje VARCHAR(9999) NOT NULL, leido TINYINT(1) DEFAULT \'0\', date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuota (id INT AUTO_INCREMENT NOT NULL, id_socio_id INT DEFAULT NULL, ano INT NOT NULL, enero TINYINT(1) DEFAULT \'0\', febrero TINYINT(1) DEFAULT \'0\', marzo TINYINT(1) DEFAULT \'0\', abril TINYINT(1) DEFAULT \'0\', mayo TINYINT(1) DEFAULT \'0\', junio TINYINT(1) DEFAULT \'0\', julio TINYINT(1) DEFAULT \'0\', agosto TINYINT(1) DEFAULT \'0\', septiembre TINYINT(1) DEFAULT \'0\', octubre TINYINT(1) DEFAULT \'0\', noviembre TINYINT(1) DEFAULT \'0\', diciembre TINYINT(1) DEFAULT \'0\', INDEX IDX_763CCB0F8ADF0A3C (id_socio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, escudo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documento (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, fecha DATETIME NOT NULL, fichero VARCHAR(255) NOT NULL, privado TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, socio_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2265B05DF85E0677 (username), UNIQUE INDEX UNIQ_2265B05DDA04E6A9 (socio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partido (id INT AUTO_INCREMENT NOT NULL, id_equipo_local_id INT DEFAULT NULL, id_equipo_visitante_id INT DEFAULT NULL, estadio VARCHAR(255) NOT NULL, fecha DATE NOT NULL, hora TIME NOT NULL, hora_apertura_sede TIME NOT NULL, INDEX IDX_4E79750B61298DFB (id_equipo_local_id), INDEX IDX_4E79750BCACEACDA (id_equipo_visitante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE socio (id INT AUTO_INCREMENT NOT NULL, num_socio INT NOT NULL, nombre VARCHAR(255) NOT NULL, dni VARCHAR(9) DEFAULT NULL, fecha_nacimiento DATE NOT NULL, direccion VARCHAR(255) DEFAULT NULL, localidad VARCHAR(255) DEFAULT NULL, telefono VARCHAR(9) DEFAULT NULL, UNIQUE INDEX UNIQ_38B653097F35E27F (num_socio), UNIQUE INDEX UNIQ_38B653097F8F253B (dni), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE solicitud_entrada ADD CONSTRAINT FK_EDDFD1F5DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id)');
        $this->addSql('ALTER TABLE solicitud_entrada ADD CONSTRAINT FK_EDDFD1F5A688222A FOREIGN KEY (entrada_id) REFERENCES entrada (id)');
        $this->addSql('ALTER TABLE entrada ADD CONSTRAINT FK_C949A27411856EB4 FOREIGN KEY (partido_id) REFERENCES partido (id)');
        $this->addSql('ALTER TABLE cuota ADD CONSTRAINT FK_763CCB0F8ADF0A3C FOREIGN KEY (id_socio_id) REFERENCES socio (id)');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05DDA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750B61298DFB FOREIGN KEY (id_equipo_local_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BCACEACDA FOREIGN KEY (id_equipo_visitante_id) REFERENCES equipo (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE solicitud_entrada DROP FOREIGN KEY FK_EDDFD1F5A688222A');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750B61298DFB');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BCACEACDA');
        $this->addSql('ALTER TABLE entrada DROP FOREIGN KEY FK_C949A27411856EB4');
        $this->addSql('ALTER TABLE solicitud_entrada DROP FOREIGN KEY FK_EDDFD1F5DA04E6A9');
        $this->addSql('ALTER TABLE cuota DROP FOREIGN KEY FK_763CCB0F8ADF0A3C');
        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05DDA04E6A9');
        $this->addSql('DROP TABLE solicitud_entrada');
        $this->addSql('DROP TABLE entrada');
        $this->addSql('DROP TABLE noticia');
        $this->addSql('DROP TABLE notificacion');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE cuota');
        $this->addSql('DROP TABLE equipo');
        $this->addSql('DROP TABLE documento');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE partido');
        $this->addSql('DROP TABLE socio');
    }
}
