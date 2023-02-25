<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221125035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE voter (id INT AUTO_INCREMENT NOT NULL, vote_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_268C4A592E2DFC9C (vote_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voter_answers (id INT AUTO_INCREMENT NOT NULL, decision SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voter ADD CONSTRAINT FK_268C4A592E2DFC9C FOREIGN KEY (vote_id_id) REFERENCES vote (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voter DROP FOREIGN KEY FK_268C4A592E2DFC9C');
        $this->addSql('DROP TABLE voter');
        $this->addSql('DROP TABLE voter_answers');
    }
}
