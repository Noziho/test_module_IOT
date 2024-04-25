<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425121618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detail (id INT AUTO_INCREMENT NOT NULL, module_id INT DEFAULT NULL, manufacturer VARCHAR(50) DEFAULT NULL, serial_number VARCHAR(255) DEFAULT NULL, INDEX IDX_2E067F93AFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operating_history (id INT AUTO_INCREMENT NOT NULL, module_id INT DEFAULT NULL, date DATETIME NOT NULL, duration VARCHAR(50) DEFAULT NULL, status VARCHAR(20) NOT NULL, consumed_data INT DEFAULT NULL, data_sent INT DEFAULT NULL, INDEX IDX_C71A2DE3AFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F93AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE operating_history ADD CONSTRAINT FK_C71A2DE3AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail DROP FOREIGN KEY FK_2E067F93AFC2B591');
        $this->addSql('ALTER TABLE operating_history DROP FOREIGN KEY FK_C71A2DE3AFC2B591');
        $this->addSql('DROP TABLE detail');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE operating_history');
    }
}
