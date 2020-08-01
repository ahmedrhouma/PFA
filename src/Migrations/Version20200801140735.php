<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200801140735 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE elector DROP FOREIGN KEY FK_4C037439A76ED395');
        $this->addSql('DROP INDEX UNIQ_4C037439A76ED395 ON elector');
        $this->addSql('ALTER TABLE elector DROP user_id');
        $this->addSql('ALTER TABLE fos_user ADD elector_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A64799FA1F62B FOREIGN KEY (elector_id) REFERENCES elector (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A64799FA1F62B ON fos_user (elector_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE elector ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE elector ADD CONSTRAINT FK_4C037439A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C037439A76ED395 ON elector (user_id)');
        $this->addSql('ALTER TABLE fos_user DROP FOREIGN KEY FK_957A64799FA1F62B');
        $this->addSql('DROP INDEX UNIQ_957A64799FA1F62B ON fos_user');
        $this->addSql('ALTER TABLE fos_user DROP elector_id');
    }
}
