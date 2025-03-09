<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250309200345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE thread ADD COLUMN body CLOB NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__thread AS SELECT id, subreddit_id, original_poster_id, title, url, dt_creation FROM thread');
        $this->addSql('DROP TABLE thread');
        $this->addSql('CREATE TABLE thread (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subreddit_id INTEGER DEFAULT NULL, original_poster_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, dt_creation DATETIME NOT NULL, CONSTRAINT FK_31204C8331DBE174 FOREIGN KEY (subreddit_id) REFERENCES subreddit (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_31204C8331251310 FOREIGN KEY (original_poster_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO thread (id, subreddit_id, original_poster_id, title, url, dt_creation) SELECT id, subreddit_id, original_poster_id, title, url, dt_creation FROM __temp__thread');
        $this->addSql('DROP TABLE __temp__thread');
        $this->addSql('CREATE INDEX IDX_31204C8331DBE174 ON thread (subreddit_id)');
        $this->addSql('CREATE INDEX IDX_31204C8331251310 ON thread (original_poster_id)');
    }
}
