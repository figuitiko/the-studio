<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215031737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO `test_studio`.`state` (`content`) VALUES ('ORDER_RECEIVED')");
        $this->addSql("INSERT INTO `test_studio`.`state` (`content`) VALUES ('ORDER_PROCESSING')");
        $this->addSql("INSERT INTO `test_studio`.`state` (`content`) VALUES ('ORDER_CANCELED')");
        $this->addSql("INSERT INTO `test_studio`.`state` (`content`) VALUES ('ORDER_READY_TO_SHIP')");
        $this->addSql("INSERT INTO `test_studio`.`state` (`content`) VALUES ('ORDER_SHIPPED')");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DELETE FROM `test_studio`.`state` WHERE (`content` = 'ORDER_RECEIVED')");
        $this->addSql("DELETE FROM `test_studio`.`state` WHERE (`content` = 'ORDER_PROCESSING')");
        $this->addSql("DELETE FROM `test_studio`.`state` WHERE (`content` = 'ORDER_CANCELED')");
        $this->addSql("DELETE FROM `test_studio`.`state` WHERE (`content` = 'ORDER_READY_TO_SHIP')");
        $this->addSql("DELETE FROM `test_studio`.`state` WHERE (`content` = 'ORDER_SHIPPED')");
        
    }
}
