<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407103732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rental_receipts (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', rent_amount DOUBLE PRECISION NOT NULL, charges_amount DOUBLE PRECISION NOT NULL, agency_fees_amount DOUBLE PRECISION NOT NULL, total_amount DOUBLE PRECISION NOT NULL, start_at DATE NOT NULL, end_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', balance DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD rental_receipts_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DE7CAE170 FOREIGN KEY (rental_receipts_id) REFERENCES rental_receipts (id)');
        $this->addSql('CREATE INDEX IDX_6D28840DE7CAE170 ON payment (rental_receipts_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DE7CAE170');
        $this->addSql('DROP TABLE rental_receipts');
        $this->addSql('DROP INDEX IDX_6D28840DE7CAE170 ON payment');
        $this->addSql('ALTER TABLE payment DROP rental_receipts_id');
    }
}
