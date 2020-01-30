<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200129135758 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE shows_spectacles (shows_id INT NOT NULL, spectacles_id INT NOT NULL, INDEX IDX_704F3F31AD7ED998 (shows_id), INDEX IDX_704F3F31F26D12FD (spectacles_id), PRIMARY KEY(shows_id, spectacles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shows_spectacles ADD CONSTRAINT FK_704F3F31AD7ED998 FOREIGN KEY (shows_id) REFERENCES shows (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shows_spectacles ADD CONSTRAINT FK_704F3F31F26D12FD FOREIGN KEY (spectacles_id) REFERENCES spectacles (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE shows_spectacles');
    }
}
