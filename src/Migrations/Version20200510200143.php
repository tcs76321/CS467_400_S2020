<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200510200143 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE locale (id INT AUTO_INCREMENT NOT NULL, north_id INT DEFAULT NULL, east_id INT DEFAULT NULL, south_id INT DEFAULT NULL, west_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, fertility SMALLINT NOT NULL, danger SMALLINT NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4180C698F09778E7 (north_id), UNIQUE INDEX UNIQ_4180C6984465D135 (east_id), UNIQUE INDEX UNIQ_4180C698A2C6CA5 (south_id), UNIQUE INDEX UNIQ_4180C6982FB51EC4 (west_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE locale ADD CONSTRAINT FK_4180C698F09778E7 FOREIGN KEY (north_id) REFERENCES locale (id)');
        $this->addSql('ALTER TABLE locale ADD CONSTRAINT FK_4180C6984465D135 FOREIGN KEY (east_id) REFERENCES locale (id)');
        $this->addSql('ALTER TABLE locale ADD CONSTRAINT FK_4180C698A2C6CA5 FOREIGN KEY (south_id) REFERENCES locale (id)');
        $this->addSql('ALTER TABLE locale ADD CONSTRAINT FK_4180C6982FB51EC4 FOREIGN KEY (west_id) REFERENCES locale (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE locale DROP FOREIGN KEY FK_4180C698F09778E7');
        $this->addSql('ALTER TABLE locale DROP FOREIGN KEY FK_4180C6984465D135');
        $this->addSql('ALTER TABLE locale DROP FOREIGN KEY FK_4180C698A2C6CA5');
        $this->addSql('ALTER TABLE locale DROP FOREIGN KEY FK_4180C6982FB51EC4');
        $this->addSql('DROP TABLE locale');
    }
}
