<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230401135040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tenant (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(100) NOT NULL, first_name VARCHAR(100) NOT NULL, civil_status VARCHAR(100) NOT NULL, date_of_birth DATE NOT NULL, birth_place VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(100) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, guarantor VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tenant_rental (tenant_id INT NOT NULL, rental_id INT NOT NULL, INDEX IDX_37B2A6249033212A (tenant_id), INDEX IDX_37B2A624A7CF2329 (rental_id), PRIMARY KEY(tenant_id, rental_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tenant_rental ADD CONSTRAINT FK_37B2A6249033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tenant_rental ADD CONSTRAINT FK_37B2A624A7CF2329 FOREIGN KEY (rental_id) REFERENCES rental (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tenant_rental DROP FOREIGN KEY FK_37B2A6249033212A');
        $this->addSql('ALTER TABLE tenant_rental DROP FOREIGN KEY FK_37B2A624A7CF2329');
        $this->addSql('DROP TABLE tenant');
        $this->addSql('DROP TABLE tenant_rental');
    }
}
