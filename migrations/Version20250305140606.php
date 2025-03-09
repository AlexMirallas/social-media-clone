<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250305140606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subreddit_user (subreddit_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(subreddit_id, user_id), CONSTRAINT FK_78A09F1831DBE174 FOREIGN KEY (subreddit_id) REFERENCES subreddit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_78A09F18A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_78A09F1831DBE174 ON subreddit_user (subreddit_id)');
        $this->addSql('CREATE INDEX IDX_78A09F18A76ED395 ON subreddit_user (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, user_id, thread_id, comment_body, dt_creation FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, thread_id INTEGER NOT NULL, parent_id INTEGER DEFAULT NULL, comment_body CLOB NOT NULL, dt_creation DATETIME NOT NULL, CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526CE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526C727ACA70 FOREIGN KEY (parent_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, user_id, thread_id, comment_body, dt_creation) SELECT id, user_id, thread_id, comment_body, dt_creation FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CE2904019 ON comment (thread_id)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526C727ACA70 ON comment (parent_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__thread AS SELECT id, subreddit_id, title, url, dt_creation FROM thread');
        $this->addSql('DROP TABLE thread');
        $this->addSql('CREATE TABLE thread (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subreddit_id INTEGER DEFAULT NULL, original_poster_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, dt_creation DATETIME NOT NULL, CONSTRAINT FK_31204C8331DBE174 FOREIGN KEY (subreddit_id) REFERENCES subreddit (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_31204C8331251310 FOREIGN KEY (original_poster_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO thread (id, subreddit_id, title, url, dt_creation) SELECT id, subreddit_id, title, url, dt_creation FROM __temp__thread');
        $this->addSql('DROP TABLE __temp__thread');
        $this->addSql('CREATE INDEX IDX_31204C8331DBE174 ON thread (subreddit_id)');
        $this->addSql('CREATE INDEX IDX_31204C8331251310 ON thread (original_poster_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE subreddit_user');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, user_id, thread_id, comment_body, dt_creation FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, thread_id INTEGER NOT NULL, comment_body CLOB NOT NULL, dt_creation DATETIME NOT NULL, CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526CE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, user_id, thread_id, comment_body, dt_creation) SELECT id, user_id, thread_id, comment_body, dt_creation FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526CE2904019 ON comment (thread_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__thread AS SELECT id, subreddit_id, title, url, dt_creation FROM thread');
        $this->addSql('DROP TABLE thread');
        $this->addSql('CREATE TABLE thread (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, subreddit_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, dt_creation DATETIME NOT NULL, CONSTRAINT FK_31204C8331DBE174 FOREIGN KEY (subreddit_id) REFERENCES subreddit (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO thread (id, subreddit_id, title, url, dt_creation) SELECT id, subreddit_id, title, url, dt_creation FROM __temp__thread');
        $this->addSql('DROP TABLE __temp__thread');
        $this->addSql('CREATE INDEX IDX_31204C8331DBE174 ON thread (subreddit_id)');
    }
}
