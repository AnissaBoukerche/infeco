<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330161532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apartment (id INT AUTO_INCREMENT NOT NULL, user_agency_id INT DEFAULT NULL, address VARCHAR(255) NOT NULL, additional_address_details VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(255) NOT NULL, INDEX IDX_4D7E6854CD0A56CE (user_agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory_of_fixtures (id INT AUTO_INCREMENT NOT NULL, rental_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status TINYINT(1) NOT NULL, comments LONGTEXT DEFAULT NULL, INDEX IDX_94D02F10A7CF2329 (rental_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rental (id INT AUTO_INCREMENT NOT NULL, apartment_id INT NOT NULL, entry_at DATE NOT NULL, exit_at DATE DEFAULT NULL, charges DOUBLE PRECISION NOT NULL, rent DOUBLE PRECISION NOT NULL, balance DOUBLE PRECISION NOT NULL, INDEX IDX_1619C27D176DFE85 (apartment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_agency (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, agency_fees INT NOT NULL, zip_code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1592DDDBE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apartment ADD CONSTRAINT FK_4D7E6854CD0A56CE FOREIGN KEY (user_agency_id) REFERENCES user_agency (id)');
        $this->addSql('ALTER TABLE inventory_of_fixtures ADD CONSTRAINT FK_94D02F10A7CF2329 FOREIGN KEY (rental_id) REFERENCES rental (id)');
        $this->addSql('ALTER TABLE rental ADD CONSTRAINT FK_1619C27D176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apartment DROP FOREIGN KEY FK_4D7E6854CD0A56CE');
        $this->addSql('ALTER TABLE inventory_of_fixtures DROP FOREIGN KEY FK_94D02F10A7CF2329');
        $this->addSql('ALTER TABLE rental DROP FOREIGN KEY FK_1619C27D176DFE85');
        $this->addSql('DROP TABLE apartment');
        $this->addSql('DROP TABLE inventory_of_fixtures');
        $this->addSql('DROP TABLE rental');
        $this->addSql('DROP TABLE user_agency');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
