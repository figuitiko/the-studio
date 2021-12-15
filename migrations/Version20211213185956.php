<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211213185956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logger_order ADD state_id INT NOT NULL');
        $this->addSql('ALTER TABLE logger_order ADD CONSTRAINT FK_B3B7C7065D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('CREATE INDEX IDX_B3B7C7065D83CC1 ON logger_order (state_id)');
        $this->addSql('ALTER TABLE `order` ADD state_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993985D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('CREATE INDEX IDX_F52993985D83CC1 ON `order` (state_id)');
        $this->addSql('ALTER TABLE state DROP FOREIGN KEY FK_A393D2FB2B1C2395');
        $this->addSql('ALTER TABLE state DROP FOREIGN KEY FK_A393D2FB99C22F38');
        $this->addSql('DROP INDEX UNIQ_A393D2FB2B1C2395 ON state');
        $this->addSql('DROP INDEX UNIQ_A393D2FB99C22F38 ON state');
        $this->addSql('ALTER TABLE state DROP related_order_id, DROP logged_order_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logger_order DROP FOREIGN KEY FK_B3B7C7065D83CC1');
        $this->addSql('DROP INDEX IDX_B3B7C7065D83CC1 ON logger_order');
        $this->addSql('ALTER TABLE logger_order DROP state_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993985D83CC1');
        $this->addSql('DROP INDEX IDX_F52993985D83CC1 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP state_id');
        $this->addSql('ALTER TABLE state ADD related_order_id INT NOT NULL, ADD logged_order_id INT NOT NULL');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FB2B1C2395 FOREIGN KEY (related_order_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FB99C22F38 FOREIGN KEY (logged_order_id) REFERENCES logger_order (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A393D2FB2B1C2395 ON state (related_order_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A393D2FB99C22F38 ON state (logged_order_id)');
    }
}
