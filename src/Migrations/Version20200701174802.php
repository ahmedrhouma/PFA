<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200701174802 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE candidats DROP FOREIGN KEY FK_3C663B15E85441D8');
        $this->addSql('DROP TABLE liste');
        $this->addSql('DROP INDEX IDX_3C663B15E85441D8 ON candidats');
        $this->addSql('ALTER TABLE candidats DROP liste_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE liste (id INT AUTO_INCREMENT NOT NULL, list_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type SMALLINT DEFAULT NULL, photo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE candidats ADD liste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidats ADD CONSTRAINT FK_3C663B15E85441D8 FOREIGN KEY (liste_id) REFERENCES liste (id)');
        $this->addSql('CREATE INDEX IDX_3C663B15E85441D8 ON candidats (liste_id)');
    }
}
