<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171217105824 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employee CHANGE telephone_number telephone_number VARCHAR(40) DEFAULT NULL, CHANGE email email VARCHAR(400) DEFAULT NULL, CHANGE address address VARCHAR(100) DEFAULT NULL, CHANGE zip_code zip_code INT DEFAULT NULL, CHANGE place place VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employee CHANGE telephone_number telephone_number VARCHAR(40) NOT NULL COLLATE utf8_unicode_ci, CHANGE email email VARCHAR(400) NOT NULL COLLATE utf8_unicode_ci, CHANGE address address VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE zip_code zip_code INT NOT NULL, CHANGE place place VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci');
    }
}
