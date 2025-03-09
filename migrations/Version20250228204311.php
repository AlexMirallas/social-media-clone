<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250228204311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, comment_body, dt_creation FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, thread_id INTEGER NOT NULL, comment_body CLOB NOT NULL, dt_creation DATETIME NOT NULL, CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526CE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, comment_body, dt_creation) SELECT id, comment_body, dt_creation FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526CE2904019 ON comment (thread_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subreddit AS SELECT id, title, description, banner, dt_creation FROM subreddit');
        $this->addSql('DROP TABLE subreddit');
        $this->addSql('CREATE TABLE subreddit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, banner VARCHAR(255) DEFAULT NULL, dt_creation DATETIME NOT NULL, CONSTRAINT FK_D84B1B12A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO subreddit (id, title, description, banner, dt_creation) SELECT id, title, description, banner, dt_creation FROM __temp__subreddit');
        $this->addSql('DROP TABLE __temp__subreddit');
        $this->addSql('CREATE INDEX IDX_D84B1B12A76ED395 ON subreddit (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__thread AS SELECT id, title, url, dt_creation FROM thread');
        $this->addSql('DROP TABLE thread');
        $this->addSql('CREATE TABLE thread (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subreddit_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, dt_creation DATETIME NOT NULL, CONSTRAINT FK_31204C8331DBE174 FOREIGN KEY (subreddit_id) REFERENCES subreddit (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO thread (id, title, url, dt_creation) SELECT id, title, url, dt_creation FROM __temp__thread');
        $this->addSql('DROP TABLE __temp__thread');
        $this->addSql('CREATE INDEX IDX_31204C8331DBE174 ON thread (subreddit_id)');
        $this->addSql('ALTER TABLE user ADD COLUMN username VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN dt_creation DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user ADD COLUMN img_avatar VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, comment_body, dt_creation FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, comment_body CLOB NOT NULL, dt_creation DATETIME NOT NULL)');
        $this->addSql('INSERT INTO comment (id, comment_body, dt_creation) SELECT id, comment_body, dt_creation FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subreddit AS SELECT id, title, description, banner, dt_creation FROM subreddit');
        $this->addSql('DROP TABLE subreddit');
        $this->addSql('CREATE TABLE subreddit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, banner VARCHAR(255) DEFAULT NULL, dt_creation DATETIME NOT NULL)');
        $this->addSql('INSERT INTO subreddit (id, title, description, banner, dt_creation) SELECT id, title, description, banner, dt_creation FROM __temp__subreddit');
        $this->addSql('DROP TABLE __temp__subreddit');
        $this->addSql('CREATE TEMPORARY TABLE __temp__thread AS SELECT id, title, url, dt_creation FROM thread');
        $this->addSql('DROP TABLE thread');
        $this->addSql('CREATE TABLE thread (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, dt_creation DATETIME NOT NULL)');
        $this->addSql('INSERT INTO thread (id, title, url, dt_creation) SELECT id, title, url, dt_creation FROM __temp__thread');
        $this->addSql('DROP TABLE __temp__thread');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, password) SELECT id, email, roles, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }
}
