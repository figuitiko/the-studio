<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215015520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logger_order DROP FOREIGN KEY FK_B3B7C706A76ED395');
        $this->addSql('ALTER TABLE logger_order ADD CONSTRAINT FK_B3B7C706A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logger_order DROP FOREIGN KEY FK_B3B7C706A76ED395');
        $this->addSql('ALTER TABLE logger_order ADD CONSTRAINT FK_B3B7C706A76ED395 FOREIGN KEY (user_id) REFERENCES logger_order (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
