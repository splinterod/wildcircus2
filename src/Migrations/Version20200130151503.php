<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200130151503 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE chat ADD artiste_id INT DEFAULT NULL, ADD organisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA21D25844 FOREIGN KEY (artiste_id) REFERENCES artistes (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAD936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisation (id)');
        $this->addSql('CREATE INDEX IDX_659DF2AA21D25844 ON chat (artiste_id)');
        $this->addSql('CREATE INDEX IDX_659DF2AAD936B2FA ON chat (organisateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA21D25844');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AAD936B2FA');
        $this->addSql('DROP INDEX IDX_659DF2AA21D25844 ON chat');
        $this->addSql('DROP INDEX IDX_659DF2AAD936B2FA ON chat');
        $this->addSql('ALTER TABLE chat DROP artiste_id, DROP organisateur_id');
    }
}
