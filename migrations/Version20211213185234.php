<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211213185234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, related_order_id INT NOT NULL, logged_order_id INT NOT NULL, content LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_A393D2FB2B1C2395 (related_order_id), UNIQUE INDEX UNIQ_A393D2FB99C22F38 (logged_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FB2B1C2395 FOREIGN KEY (related_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FB99C22F38 FOREIGN KEY (logged_order_id) REFERENCES logger_order (id)');
        $this->addSql('ALTER TABLE logger_order DROP FOREIGN KEY FK_B3B7C706A76ED395');
        $this->addSql('DROP INDEX IDX_B3B7C706A76ED395 ON logger_order');
        $this->addSql('ALTER TABLE logger_order DROP user_id, DROP state');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP user_id, DROP state');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE state');
        $this->addSql('ALTER TABLE logger_order ADD user_id INT NOT NULL, ADD state VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE logger_order ADD CONSTRAINT FK_B3B7C706A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B3B7C706A76ED395 ON logger_order (user_id)');
        $this->addSql('ALTER TABLE `order` ADD user_id INT NOT NULL, ADD state VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
    }
}
