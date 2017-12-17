<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171217140043 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE employees (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, telephone_number VARCHAR(40) DEFAULT NULL, email VARCHAR(400) DEFAULT NULL, address VARCHAR(100) DEFAULT NULL, zip_code INT DEFAULT NULL, place VARCHAR(100) DEFAULT NULL, picture_url VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employees_employeeTypes (employee_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_4EA8D34C8C03F15C (employee_id), UNIQUE INDEX UNIQ_4EA8D34CC54C8C93 (type_id), PRIMARY KEY(employee_id, type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employeeTypes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, executive TINYINT(1) DEFAULT NULL, sort_index INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teams (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(1000) DEFAULT NULL, league VARCHAR(100) DEFAULT NULL, picture_url VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employees_employeeTypes ADD CONSTRAINT FK_4EA8D34C8C03F15C FOREIGN KEY (employee_id) REFERENCES employees (id)');
        $this->addSql('ALTER TABLE employees_employeeTypes ADD CONSTRAINT FK_4EA8D34CC54C8C93 FOREIGN KEY (type_id) REFERENCES employeeTypes (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employees_employeeTypes DROP FOREIGN KEY FK_4EA8D34C8C03F15C');
        $this->addSql('ALTER TABLE employees_employeeTypes DROP FOREIGN KEY FK_4EA8D34CC54C8C93');
        $this->addSql('DROP TABLE employees');
        $this->addSql('DROP TABLE employees_employeeTypes');
        $this->addSql('DROP TABLE employeeTypes');
        $this->addSql('DROP TABLE teams');
    }
}
