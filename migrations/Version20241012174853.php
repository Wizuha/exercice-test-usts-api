<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241012174853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64930FCDC3A');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, INDEX IDX_2FB3D0EE979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE user_company DROP FOREIGN KEY FK_17B21745A76ED395');
        $this->addSql('ALTER TABLE user_company_company DROP FOREIGN KEY FK_7D317F17979B1AD6');
        $this->addSql('ALTER TABLE user_company_company DROP FOREIGN KEY FK_7D317F1730FCDC3A');
        $this->addSql('DROP TABLE user_company');
        $this->addSql('DROP TABLE user_company_company');
        $this->addSql('DROP INDEX IDX_8D93D64930FCDC3A ON user');
        $this->addSql('ALTER TABLE user DROP user_company_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_company (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_17B21745A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_company_company (user_company_id INT NOT NULL, company_id INT NOT NULL, INDEX IDX_7D317F17979B1AD6 (company_id), INDEX IDX_7D317F1730FCDC3A (user_company_id), PRIMARY KEY(user_company_id, company_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_company ADD CONSTRAINT FK_17B21745A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_company_company ADD CONSTRAINT FK_7D317F17979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_company_company ADD CONSTRAINT FK_7D317F1730FCDC3A FOREIGN KEY (user_company_id) REFERENCES user_company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE979B1AD6');
        $this->addSql('DROP TABLE project');
        $this->addSql('ALTER TABLE user ADD user_company_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64930FCDC3A FOREIGN KEY (user_company_id) REFERENCES user_company (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64930FCDC3A ON user (user_company_id)');
    }
}
