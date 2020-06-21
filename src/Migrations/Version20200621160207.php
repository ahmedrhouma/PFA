<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200621160207 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE candidats (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, fist_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, gender SMALLINT NOT NULL, birthday DATE NOT NULL, INDEX IDX_3C663B1571F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE elector (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone INT NOT NULL, gender SMALLINT NOT NULL, language VARCHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE elector_event (elector_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_F5842D1B9FA1F62B (elector_id), INDEX IDX_F5842D1B71F7E88B (event_id), PRIMARY KEY(elector_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE encrypted_vote (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, vote VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_8D4BC52671F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, status SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_result (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, result INT NOT NULL, UNIQUE INDEX UNIQ_21F3B64171F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste (id INT AUTO_INCREMENT NOT NULL, list_name VARCHAR(255) NOT NULL, type SMALLINT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', id_profile INT NOT NULL, UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidats ADD CONSTRAINT FK_3C663B1571F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE elector_event ADD CONSTRAINT FK_F5842D1B9FA1F62B FOREIGN KEY (elector_id) REFERENCES elector (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE elector_event ADD CONSTRAINT FK_F5842D1B71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE encrypted_vote ADD CONSTRAINT FK_8D4BC52671F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event_result ADD CONSTRAINT FK_21F3B64171F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE elector_event DROP FOREIGN KEY FK_F5842D1B9FA1F62B');
        $this->addSql('ALTER TABLE candidats DROP FOREIGN KEY FK_3C663B1571F7E88B');
        $this->addSql('ALTER TABLE elector_event DROP FOREIGN KEY FK_F5842D1B71F7E88B');
        $this->addSql('ALTER TABLE encrypted_vote DROP FOREIGN KEY FK_8D4BC52671F7E88B');
        $this->addSql('ALTER TABLE event_result DROP FOREIGN KEY FK_21F3B64171F7E88B');
        $this->addSql('DROP TABLE candidats');
        $this->addSql('DROP TABLE elector');
        $this->addSql('DROP TABLE elector_event');
        $this->addSql('DROP TABLE encrypted_vote');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_result');
        $this->addSql('DROP TABLE liste');
        $this->addSql('DROP TABLE fos_user');
    }
}
