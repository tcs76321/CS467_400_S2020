<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200510211007 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tribe ADD location_id INT NOT NULL');
        $this->addSql('ALTER TABLE tribe ADD CONSTRAINT FK_2653B55864D218E FOREIGN KEY (location_id) REFERENCES locale (id)');
        $this->addSql('CREATE INDEX IDX_2653B55864D218E ON tribe (location_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tribe DROP FOREIGN KEY FK_2653B55864D218E');
        $this->addSql('DROP INDEX IDX_2653B55864D218E ON tribe');
        $this->addSql('ALTER TABLE tribe DROP location_id');
    }
}
