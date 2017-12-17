<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171217195613 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employees_employeeTypes DROP FOREIGN KEY FK_4EA8D34CC54C8C93');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, author VARCHAR(100) NOT NULL, title VARCHAR(100) NOT NULL, lead VARCHAR(400) DEFAULT NULL, text VARCHAR(1000) DEFAULT NULL, picture_url VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_news_types (news_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_CFF0D917B5A459A0 (news_id), INDEX IDX_CFF0D917C54C8C93 (type_id), PRIMARY KEY(news_id, type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pages (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, description VARCHAR(200) DEFAULT NULL, text VARCHAR(1000) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE news_news_types ADD CONSTRAINT FK_CFF0D917B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id)');
        $this->addSql('ALTER TABLE news_news_types ADD CONSTRAINT FK_CFF0D917C54C8C93 FOREIGN KEY (type_id) REFERENCES news_types (id)');
        $this->addSql('DROP TABLE employeeTypes');
        $this->addSql('DROP TABLE employees_employeeTypes');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news_news_types DROP FOREIGN KEY FK_CFF0D917B5A459A0');
        $this->addSql('ALTER TABLE news_news_types DROP FOREIGN KEY FK_CFF0D917C54C8C93');
        $this->addSql('CREATE TABLE employeeTypes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, executive TINYINT(1) DEFAULT NULL, sort_index INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employees_employeeTypes (employee_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_4EA8D34C8C03F15C (employee_id), INDEX IDX_4EA8D34CC54C8C93 (type_id), PRIMARY KEY(employee_id, type_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employees_employeeTypes ADD CONSTRAINT FK_4EA8D34CC54C8C93 FOREIGN KEY (type_id) REFERENCES employeeTypes (id)');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE news_news_types');
        $this->addSql('DROP TABLE news_types');
        $this->addSql('DROP TABLE pages');
    }
}
