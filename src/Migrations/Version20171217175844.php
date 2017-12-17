<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171217175844 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employees_employeeTypes DROP FOREIGN KEY FK_4EA8D34CC54C8C93');
        $this->addSql('CREATE TABLE employees_employee_types (employee_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_8D00C5D78C03F15C (employee_id), INDEX IDX_8D00C5D7C54C8C93 (type_id), PRIMARY KEY(employee_id, type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, executive TINYINT(1) DEFAULT NULL, sort_index INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE players (id INT AUTO_INCREMENT NOT NULL, position_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, number INT NOT NULL, birth_date DATE DEFAULT NULL, picture_url VARCHAR(100) DEFAULT NULL, UNIQUE INDEX UNIQ_264E43A6DD842E46 (position_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_positions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, sort_index INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teams_players (team_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_8E810F12296CD8AE (team_id), INDEX IDX_8E810F1299E6F5DF (player_id), PRIMARY KEY(team_id, player_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employees_employee_types ADD CONSTRAINT FK_8D00C5D78C03F15C FOREIGN KEY (employee_id) REFERENCES employees (id)');
        $this->addSql('ALTER TABLE employees_employee_types ADD CONSTRAINT FK_8D00C5D7C54C8C93 FOREIGN KEY (type_id) REFERENCES employee_types (id)');
        $this->addSql('ALTER TABLE players ADD CONSTRAINT FK_264E43A6DD842E46 FOREIGN KEY (position_id) REFERENCES player_positions (id)');
        $this->addSql('ALTER TABLE teams_players ADD CONSTRAINT FK_8E810F12296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE teams_players ADD CONSTRAINT FK_8E810F1299E6F5DF FOREIGN KEY (player_id) REFERENCES players (id)');
        $this->addSql('DROP TABLE employeeTypes');
        $this->addSql('DROP TABLE employees_employeeTypes');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employees_employee_types DROP FOREIGN KEY FK_8D00C5D7C54C8C93');
        $this->addSql('ALTER TABLE teams_players DROP FOREIGN KEY FK_8E810F1299E6F5DF');
        $this->addSql('ALTER TABLE players DROP FOREIGN KEY FK_264E43A6DD842E46');
        $this->addSql('CREATE TABLE employeeTypes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, executive TINYINT(1) DEFAULT NULL, sort_index INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employees_employeeTypes (employee_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_4EA8D34C8C03F15C (employee_id), INDEX IDX_4EA8D34CC54C8C93 (type_id), PRIMARY KEY(employee_id, type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employees_employeeTypes ADD CONSTRAINT FK_4EA8D34C8C03F15C FOREIGN KEY (employee_id) REFERENCES employees (id)');
        $this->addSql('ALTER TABLE employees_employeeTypes ADD CONSTRAINT FK_4EA8D34CC54C8C93 FOREIGN KEY (type_id) REFERENCES employeeTypes (id)');
        $this->addSql('DROP TABLE employees_employee_types');
        $this->addSql('DROP TABLE employee_types');
        $this->addSql('DROP TABLE players');
        $this->addSql('DROP TABLE player_positions');
        $this->addSql('DROP TABLE teams_players');
    }
}
