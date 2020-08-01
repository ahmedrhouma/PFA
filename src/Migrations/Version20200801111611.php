<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200801111611 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE encrypted_vote_elector');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE encrypted_vote_elector (encrypted_vote_id INT NOT NULL, elector_id INT NOT NULL, INDEX IDX_B59EC0359FA1F62B (elector_id), INDEX IDX_B59EC035D0244FC (encrypted_vote_id), PRIMARY KEY(encrypted_vote_id, elector_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE encrypted_vote_elector ADD CONSTRAINT FK_B59EC0359FA1F62B FOREIGN KEY (elector_id) REFERENCES elector (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE encrypted_vote_elector ADD CONSTRAINT FK_B59EC035D0244FC FOREIGN KEY (encrypted_vote_id) REFERENCES encrypted_vote (id) ON DELETE CASCADE');
    }
}
