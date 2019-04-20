<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190420143236 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repository (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_5CFE57CD166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assert_option (id INT AUTO_INCREMENT NOT NULL, field_assert_id INT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_175DA1EF113B5DA9 (field_assert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, repository_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_E19D9AD250C9D4F7 (repository_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field_option (id INT AUTO_INCREMENT NOT NULL, service_field_id INT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_70C28CB2BD415C8D (service_field_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field_assert (id INT AUTO_INCREMENT NOT NULL, service_field_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_9BABC3A9BD415C8D (service_field_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_field (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, data_type VARCHAR(255) NOT NULL, length VARCHAR(255) NOT NULL, is_unique TINYINT(1) NOT NULL, is_nullable TINYINT(1) NOT NULL, data_type_precision INT DEFAULT NULL, data_type_scale INT DEFAULT NULL, INDEX IDX_F287A8BFED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_81398E0992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_81398E09A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_81398E09C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE repository ADD CONSTRAINT FK_5CFE57CD166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE assert_option ADD CONSTRAINT FK_175DA1EF113B5DA9 FOREIGN KEY (field_assert_id) REFERENCES field_assert (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD250C9D4F7 FOREIGN KEY (repository_id) REFERENCES repository (id)');
        $this->addSql('ALTER TABLE field_option ADD CONSTRAINT FK_70C28CB2BD415C8D FOREIGN KEY (service_field_id) REFERENCES service_field (id)');
        $this->addSql('ALTER TABLE field_assert ADD CONSTRAINT FK_9BABC3A9BD415C8D FOREIGN KEY (service_field_id) REFERENCES service_field (id)');
        $this->addSql('ALTER TABLE service_field ADD CONSTRAINT FK_F287A8BFED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE repository DROP FOREIGN KEY FK_5CFE57CD166D1F9C');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD250C9D4F7');
        $this->addSql('ALTER TABLE service_field DROP FOREIGN KEY FK_F287A8BFED5CA9E6');
        $this->addSql('ALTER TABLE assert_option DROP FOREIGN KEY FK_175DA1EF113B5DA9');
        $this->addSql('ALTER TABLE field_option DROP FOREIGN KEY FK_70C28CB2BD415C8D');
        $this->addSql('ALTER TABLE field_assert DROP FOREIGN KEY FK_9BABC3A9BD415C8D');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE repository');
        $this->addSql('DROP TABLE assert_option');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE field_option');
        $this->addSql('DROP TABLE field_assert');
        $this->addSql('DROP TABLE service_field');
        $this->addSql('DROP TABLE customer');
    }
}
