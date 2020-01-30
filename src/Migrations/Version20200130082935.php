<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200130082935 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shows ADD artistes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shows ADD CONSTRAINT FK_6C3BF14496E1EAF4 FOREIGN KEY (artistes_id) REFERENCES artistes (id)');
        $this->addSql('CREATE INDEX IDX_6C3BF14496E1EAF4 ON shows (artistes_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shows DROP FOREIGN KEY FK_6C3BF14496E1EAF4');
        $this->addSql('DROP INDEX IDX_6C3BF14496E1EAF4 ON shows');
        $this->addSql('ALTER TABLE shows DROP artistes_id');
    }
}
