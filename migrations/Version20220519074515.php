<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220519074515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // TODO: Canviar usuari a NOT NULL
        $this->addSql('ALTER TABLE tweet ADD user_id INT');
        $this->addSql('ALTER TABLE tweet ADD CONSTRAINT FK_TWEET_USER FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3D660A3BA76ED395 ON tweet (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tweet DROP FOREIGN KEY FK_TWEET_USER');
        $this->addSql('DROP INDEX IDX_3D660A3BA76ED395 ON tweet');
        $this->addSql('ALTER TABLE tweet DROP user_id');
    }
}
