<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250312094209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD COLUMN upvote INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD COLUMN downvote INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE thread ADD COLUMN upvotes INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE thread ADD COLUMN downvotes INTEGER DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, user_id, thread_id, parent_id, comment_body, dt_creation FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, thread_id INTEGER NOT NULL, parent_id INTEGER DEFAULT NULL, comment_body CLOB NOT NULL, dt_creation DATETIME NOT NULL, CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526CE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526C727ACA70 FOREIGN KEY (parent_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, user_id, thread_id, parent_id, comment_body, dt_creation) SELECT id, user_id, thread_id, parent_id, comment_body, dt_creation FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526CE2904019 ON comment (thread_id)');
        $this->addSql('CREATE INDEX IDX_9474526C727ACA70 ON comment (parent_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__thread AS SELECT id, subreddit_id, original_poster_id, title, url, dt_creation, body FROM thread');
        $this->addSql('DROP TABLE thread');
        $this->addSql('CREATE TABLE thread (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subreddit_id INTEGER DEFAULT NULL, original_poster_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, dt_creation DATETIME NOT NULL, body CLOB NOT NULL, CONSTRAINT FK_31204C8331DBE174 FOREIGN KEY (subreddit_id) REFERENCES subreddit (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_31204C8331251310 FOREIGN KEY (original_poster_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO thread (id, subreddit_id, original_poster_id, title, url, dt_creation, body) SELECT id, subreddit_id, original_poster_id, title, url, dt_creation, body FROM __temp__thread');
        $this->addSql('DROP TABLE __temp__thread');
        $this->addSql('CREATE INDEX IDX_31204C8331DBE174 ON thread (subreddit_id)');
        $this->addSql('CREATE INDEX IDX_31204C8331251310 ON thread (original_poster_id)');
    }
}
