<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171223212615 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE teams (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(1000) DEFAULT NULL, league VARCHAR(100) DEFAULT NULL, picture_url VARCHAR(100) DEFAULT NULL, url VARCHAR(100) DEFAULT NULL, games_url VARCHAR(200) DEFAULT NULL, results_url VARCHAR(200) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teams_employees (team_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_45410DC8296CD8AE (team_id), INDEX IDX_45410DC88C03F15C (employee_id), PRIMARY KEY(team_id, employee_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teams_players (team_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_8E810F12296CD8AE (team_id), INDEX IDX_8E810F1299E6F5DF (player_id), PRIMARY KEY(team_id, player_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employees (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, telephone_number VARCHAR(40) DEFAULT NULL, email VARCHAR(400) DEFAULT NULL, address VARCHAR(100) DEFAULT NULL, zip_code INT DEFAULT NULL, place VARCHAR(100) DEFAULT NULL, picture_url VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employees_employee_types (employee_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_8D00C5D78C03F15C (employee_id), INDEX IDX_8D00C5D7C54C8C93 (type_id), PRIMARY KEY(employee_id, type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE players (id INT AUTO_INCREMENT NOT NULL, position_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, number INT DEFAULT NULL, birth_date DATE DEFAULT NULL, picture_url VARCHAR(100) DEFAULT NULL, INDEX IDX_264E43A6DD842E46 (position_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE games (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, team_id INT DEFAULT NULL, opponent VARCHAR(100) NOT NULL, starts_on DATETIME DEFAULT NULL, is_away TINYINT(1) DEFAULT NULL, home_score INT DEFAULT NULL, away_score INT DEFAULT NULL, url VARCHAR(200) DEFAULT NULL, INDEX IDX_FF232B31C54C8C93 (type_id), INDEX IDX_FF232B31296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, author VARCHAR(100) NOT NULL, title VARCHAR(100) NOT NULL, lead VARCHAR(400) DEFAULT NULL, text VARCHAR(10000) DEFAULT NULL, picture_url VARCHAR(100) DEFAULT NULL, url VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_news_types (news_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_CFF0D917B5A459A0 (news_id), INDEX IDX_CFF0D917C54C8C93 (type_id), PRIMARY KEY(news_id, type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ads (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(1000) DEFAULT NULL, address VARCHAR(400) DEFAULT NULL, picture_url VARCHAR(100) DEFAULT NULL, url VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ads_ad_types (ad_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_99C8BF524F34D596 (ad_id), INDEX IDX_99C8BF52C54C8C93 (type_id), PRIMARY KEY(ad_id, type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teams_ads (ad_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_E672D9A44F34D596 (ad_id), INDEX IDX_E672D9A4296CD8AE (team_id), PRIMARY KEY(ad_id, team_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_positions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, sort_index INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, executive TINYINT(1) DEFAULT NULL, sort_index INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE navigation_entries (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, url VARCHAR(100) DEFAULT NULL, sort_index INT DEFAULT NULL, INDEX IDX_6B7ABDB6727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE navigation_entries_boxes (box_id INT NOT NULL, entry_id INT NOT NULL, INDEX IDX_230D0681D8177B3F (box_id), INDEX IDX_230D0681BA364942 (entry_id), PRIMARY KEY(box_id, entry_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ad_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, show_count INT DEFAULT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pages (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, description VARCHAR(400) DEFAULT NULL, text VARCHAR(10000) DEFAULT NULL, url VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE boxes (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, text VARCHAR(10000) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE teams_employees ADD CONSTRAINT FK_45410DC8296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE teams_employees ADD CONSTRAINT FK_45410DC88C03F15C FOREIGN KEY (employee_id) REFERENCES employees (id)');
        $this->addSql('ALTER TABLE teams_players ADD CONSTRAINT FK_8E810F12296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE teams_players ADD CONSTRAINT FK_8E810F1299E6F5DF FOREIGN KEY (player_id) REFERENCES players (id)');
        $this->addSql('ALTER TABLE employees_employee_types ADD CONSTRAINT FK_8D00C5D78C03F15C FOREIGN KEY (employee_id) REFERENCES employees (id)');
        $this->addSql('ALTER TABLE employees_employee_types ADD CONSTRAINT FK_8D00C5D7C54C8C93 FOREIGN KEY (type_id) REFERENCES employee_types (id)');
        $this->addSql('ALTER TABLE players ADD CONSTRAINT FK_264E43A6DD842E46 FOREIGN KEY (position_id) REFERENCES player_positions (id)');
        $this->addSql('ALTER TABLE games ADD CONSTRAINT FK_FF232B31C54C8C93 FOREIGN KEY (type_id) REFERENCES game_types (id)');
        $this->addSql('ALTER TABLE games ADD CONSTRAINT FK_FF232B31296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE news_news_types ADD CONSTRAINT FK_CFF0D917B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id)');
        $this->addSql('ALTER TABLE news_news_types ADD CONSTRAINT FK_CFF0D917C54C8C93 FOREIGN KEY (type_id) REFERENCES news_types (id)');
        $this->addSql('ALTER TABLE ads_ad_types ADD CONSTRAINT FK_99C8BF524F34D596 FOREIGN KEY (ad_id) REFERENCES ads (id)');
        $this->addSql('ALTER TABLE ads_ad_types ADD CONSTRAINT FK_99C8BF52C54C8C93 FOREIGN KEY (type_id) REFERENCES ad_types (id)');
        $this->addSql('ALTER TABLE teams_ads ADD CONSTRAINT FK_E672D9A44F34D596 FOREIGN KEY (ad_id) REFERENCES ads (id)');
        $this->addSql('ALTER TABLE teams_ads ADD CONSTRAINT FK_E672D9A4296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE navigation_entries ADD CONSTRAINT FK_6B7ABDB6727ACA70 FOREIGN KEY (parent_id) REFERENCES navigation_entries (id)');
        $this->addSql('ALTER TABLE navigation_entries_boxes ADD CONSTRAINT FK_230D0681D8177B3F FOREIGN KEY (box_id) REFERENCES navigation_entries (id)');
        $this->addSql('ALTER TABLE navigation_entries_boxes ADD CONSTRAINT FK_230D0681BA364942 FOREIGN KEY (entry_id) REFERENCES boxes (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE teams_employees DROP FOREIGN KEY FK_45410DC8296CD8AE');
        $this->addSql('ALTER TABLE teams_players DROP FOREIGN KEY FK_8E810F12296CD8AE');
        $this->addSql('ALTER TABLE games DROP FOREIGN KEY FK_FF232B31296CD8AE');
        $this->addSql('ALTER TABLE teams_ads DROP FOREIGN KEY FK_E672D9A4296CD8AE');
        $this->addSql('ALTER TABLE teams_employees DROP FOREIGN KEY FK_45410DC88C03F15C');
        $this->addSql('ALTER TABLE employees_employee_types DROP FOREIGN KEY FK_8D00C5D78C03F15C');
        $this->addSql('ALTER TABLE teams_players DROP FOREIGN KEY FK_8E810F1299E6F5DF');
        $this->addSql('ALTER TABLE games DROP FOREIGN KEY FK_FF232B31C54C8C93');
        $this->addSql('ALTER TABLE news_news_types DROP FOREIGN KEY FK_CFF0D917B5A459A0');
        $this->addSql('ALTER TABLE ads_ad_types DROP FOREIGN KEY FK_99C8BF524F34D596');
        $this->addSql('ALTER TABLE teams_ads DROP FOREIGN KEY FK_E672D9A44F34D596');
        $this->addSql('ALTER TABLE players DROP FOREIGN KEY FK_264E43A6DD842E46');
        $this->addSql('ALTER TABLE news_news_types DROP FOREIGN KEY FK_CFF0D917C54C8C93');
        $this->addSql('ALTER TABLE employees_employee_types DROP FOREIGN KEY FK_8D00C5D7C54C8C93');
        $this->addSql('ALTER TABLE navigation_entries DROP FOREIGN KEY FK_6B7ABDB6727ACA70');
        $this->addSql('ALTER TABLE navigation_entries_boxes DROP FOREIGN KEY FK_230D0681D8177B3F');
        $this->addSql('ALTER TABLE ads_ad_types DROP FOREIGN KEY FK_99C8BF52C54C8C93');
        $this->addSql('ALTER TABLE navigation_entries_boxes DROP FOREIGN KEY FK_230D0681BA364942');
        $this->addSql('DROP TABLE teams');
        $this->addSql('DROP TABLE teams_employees');
        $this->addSql('DROP TABLE teams_players');
        $this->addSql('DROP TABLE employees');
        $this->addSql('DROP TABLE employees_employee_types');
        $this->addSql('DROP TABLE players');
        $this->addSql('DROP TABLE games');
        $this->addSql('DROP TABLE game_types');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE news_news_types');
        $this->addSql('DROP TABLE ads');
        $this->addSql('DROP TABLE ads_ad_types');
        $this->addSql('DROP TABLE teams_ads');
        $this->addSql('DROP TABLE player_positions');
        $this->addSql('DROP TABLE news_types');
        $this->addSql('DROP TABLE employee_types');
        $this->addSql('DROP TABLE navigation_entries');
        $this->addSql('DROP TABLE navigation_entries_boxes');
        $this->addSql('DROP TABLE ad_types');
        $this->addSql('DROP TABLE pages');
        $this->addSql('DROP TABLE boxes');
    }
}
