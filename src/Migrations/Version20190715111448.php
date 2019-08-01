<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190715111448 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_77E0ED584F34D596 ON ad');
        $this->addSql('DROP INDEX UNIQ_77E0ED585E237E06 ON ad');
        $this->addSql('ALTER TABLE ad DROP ad_id, CHANGE options options LONGTEXT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ad ADD ad_id INT NOT NULL, CHANGE options options LONGTEXT DEFAULT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_77E0ED584F34D596 ON ad (ad_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_77E0ED585E237E06 ON ad (name)');
    }
}
