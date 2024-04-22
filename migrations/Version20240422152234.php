<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422152234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail ADD module_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F93AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_2E067F93AFC2B591 ON detail (module_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail DROP FOREIGN KEY FK_2E067F93AFC2B591');
        $this->addSql('DROP INDEX IDX_2E067F93AFC2B591 ON detail');
        $this->addSql('ALTER TABLE detail DROP module_id');
    }
}
