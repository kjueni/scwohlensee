<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171218215505 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employees_employeeTypes DROP FOREIGN KEY FK_4EA8D34CC54C8C93');
        $this->addSql('CREATE TABLE navigation_entries (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, url VARCHAR(100) NOT NULL, sort_index INT DEFAULT NULL, INDEX IDX_6B7ABDB6727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE navigation_entries ADD CONSTRAINT FK_6B7ABDB6727ACA70 FOREIGN KEY (parent_id) REFERENCES navigation_entries (id)');
        $this->addSql('DROP TABLE employeeTypes');
        $this->addSql('DROP TABLE employees_employeeTypes');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE navigation_entries DROP FOREIGN KEY FK_6B7ABDB6727ACA70');
        $this->addSql('CREATE TABLE employeeTypes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, executive TINYINT(1) DEFAULT NULL, sort_index INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employees_employeeTypes (employee_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_4EA8D34C8C03F15C (employee_id), INDEX IDX_4EA8D34CC54C8C93 (type_id), PRIMARY KEY(employee_id, type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employees_employeeTypes ADD CONSTRAINT FK_4EA8D34CC54C8C93 FOREIGN KEY (type_id) REFERENCES employeeTypes (id)');
        $this->addSql('DROP TABLE navigation_entries');
    }
}
