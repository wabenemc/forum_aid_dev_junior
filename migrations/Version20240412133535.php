<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412133535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE thread_category (thread_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_9FD5A1DE2904019 (thread_id), INDEX IDX_9FD5A1D12469DE2 (category_id), PRIMARY KEY(thread_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE thread_category ADD CONSTRAINT FK_9FD5A1DE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE thread_category ADD CONSTRAINT FK_9FD5A1D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE response ADD threads_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB83F885A5 FOREIGN KEY (threads_id) REFERENCES thread (id)');
        $this->addSql('CREATE INDEX IDX_3E7B0BFB83F885A5 ON response (threads_id)');
        $this->addSql('ALTER TABLE thread ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C83A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_31204C83A76ED395 ON thread (user_id)');
        $this->addSql('ALTER TABLE vote ADD response_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564FBF32840 FOREIGN KEY (response_id) REFERENCES response (id)');
        $this->addSql('CREATE INDEX IDX_5A108564FBF32840 ON vote (response_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE thread_category DROP FOREIGN KEY FK_9FD5A1DE2904019');
        $this->addSql('ALTER TABLE thread_category DROP FOREIGN KEY FK_9FD5A1D12469DE2');
        $this->addSql('DROP TABLE thread_category');
        $this->addSql('ALTER TABLE thread DROP FOREIGN KEY FK_31204C83A76ED395');
        $this->addSql('DROP INDEX IDX_31204C83A76ED395 ON thread');
        $this->addSql('ALTER TABLE thread DROP user_id');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564FBF32840');
        $this->addSql('DROP INDEX IDX_5A108564FBF32840 ON vote');
        $this->addSql('ALTER TABLE vote DROP response_id');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB83F885A5');
        $this->addSql('DROP INDEX IDX_3E7B0BFB83F885A5 ON response');
        $this->addSql('ALTER TABLE response DROP threads_id');
    }
}
