<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171217135639 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employees_employeeTypes DROP INDEX UNIQ_4EA8D34C8C03F15C, ADD INDEX IDX_4EA8D34C8C03F15C (employee_id)');
        $this->addSql('ALTER TABLE employees_employeeTypes DROP INDEX IDX_4EA8D34CC54C8C93, ADD UNIQUE INDEX UNIQ_4EA8D34CC54C8C93 (type_id)');
        $this->addSql('ALTER TABLE employees_employeeTypes DROP FOREIGN KEY FK_4EA8D34C8C03F15C');
        $this->addSql('ALTER TABLE employees_employeeTypes DROP FOREIGN KEY FK_4EA8D34CC54C8C93');
        $this->addSql('ALTER TABLE employees_employeeTypes DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE employees_employeeTypes ADD CONSTRAINT FK_4EA8D34C8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE employees_employeeTypes ADD CONSTRAINT FK_4EA8D34CC54C8C93 FOREIGN KEY (type_id) REFERENCES employee_type (id)');
        $this->addSql('ALTER TABLE employees_employeeTypes ADD PRIMARY KEY (employee_id, type_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employees_employeeTypes DROP INDEX IDX_4EA8D34C8C03F15C, ADD UNIQUE INDEX UNIQ_4EA8D34C8C03F15C (employee_id)');
        $this->addSql('ALTER TABLE employees_employeeTypes DROP INDEX UNIQ_4EA8D34CC54C8C93, ADD INDEX IDX_4EA8D34CC54C8C93 (type_id)');
        $this->addSql('ALTER TABLE employees_employeeTypes DROP FOREIGN KEY FK_4EA8D34C8C03F15C');
        $this->addSql('ALTER TABLE employees_employeeTypes DROP FOREIGN KEY FK_4EA8D34CC54C8C93');
        $this->addSql('ALTER TABLE employees_employeeTypes DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE employees_employeeTypes ADD CONSTRAINT FK_4EA8D34C8C03F15C FOREIGN KEY (employee_id) REFERENCES employee_type (id)');
        $this->addSql('ALTER TABLE employees_employeeTypes ADD CONSTRAINT FK_4EA8D34CC54C8C93 FOREIGN KEY (type_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE employees_employeeTypes ADD PRIMARY KEY (type_id, employee_id)');
    }
}
