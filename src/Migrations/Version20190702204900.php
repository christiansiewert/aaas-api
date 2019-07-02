<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190702204900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE App_Repository_Service (id INT AUTO_INCREMENT NOT NULL, repository_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_3A0A7CC450C9D4F7 (repository_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Project_Repository (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_BECDCEA4166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Assert_Option (id INT AUTO_INCREMENT NOT NULL, field_assert_id INT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_1751E07A113B5DA9 (field_assert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Field_Relation (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(10) DEFAULT \'OneToMany\' NOT NULL, target_entity VARCHAR(255) NOT NULL, mapped_by VARCHAR(255) DEFAULT NULL, inversed_by VARCHAR(255) DEFAULT NULL, orphan_removal TINYINT(1) DEFAULT \'0\' NOT NULL, join_column_name VARCHAR(255) DEFAULT NULL, join_column_referenced_column_name VARCHAR(255) DEFAULT \'id\' NOT NULL, join_column_is_unique TINYINT(1) DEFAULT \'0\' NOT NULL, join_column_is_nullable TINYINT(1) DEFAULT \'1\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Relation_Cascade (id INT AUTO_INCREMENT NOT NULL, field_relation_id INT NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_491CEC52F7E1228C (field_relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Field_Option (id INT AUTO_INCREMENT NOT NULL, service_field_id INT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_BAEE3380BD415C8D (service_field_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Field_Assert (id INT AUTO_INCREMENT NOT NULL, service_field_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_51877C9BBD415C8D (service_field_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Service_Field (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, relation_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, data_type VARCHAR(255) DEFAULT \'string\' NOT NULL, length INT UNSIGNED DEFAULT 255, is_unique TINYINT(1) DEFAULT \'0\' NOT NULL, is_nullable TINYINT(1) DEFAULT \'0\' NOT NULL, data_type_precision INT DEFAULT NULL, data_type_scale INT DEFAULT NULL, INDEX IDX_34E6C318ED5CA9E6 (service_id), UNIQUE INDEX UNIQ_34E6C3183256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Acl_Customer (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_627894A692FC23A8 (username_canonical), UNIQUE INDEX UNIQ_627894A6A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_627894A6C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE App_Repository_Service ADD CONSTRAINT FK_3A0A7CC450C9D4F7 FOREIGN KEY (repository_id) REFERENCES App_Project_Repository (id)');
        $this->addSql('ALTER TABLE App_Project_Repository ADD CONSTRAINT FK_BECDCEA4166D1F9C FOREIGN KEY (project_id) REFERENCES App_Project (id)');
        $this->addSql('ALTER TABLE App_Assert_Option ADD CONSTRAINT FK_1751E07A113B5DA9 FOREIGN KEY (field_assert_id) REFERENCES App_Field_Assert (id)');
        $this->addSql('ALTER TABLE App_Relation_Cascade ADD CONSTRAINT FK_491CEC52F7E1228C FOREIGN KEY (field_relation_id) REFERENCES App_Field_Relation (id)');
        $this->addSql('ALTER TABLE App_Field_Option ADD CONSTRAINT FK_BAEE3380BD415C8D FOREIGN KEY (service_field_id) REFERENCES App_Service_Field (id)');
        $this->addSql('ALTER TABLE App_Field_Assert ADD CONSTRAINT FK_51877C9BBD415C8D FOREIGN KEY (service_field_id) REFERENCES App_Service_Field (id)');
        $this->addSql('ALTER TABLE App_Service_Field ADD CONSTRAINT FK_34E6C318ED5CA9E6 FOREIGN KEY (service_id) REFERENCES App_Repository_Service (id)');
        $this->addSql('ALTER TABLE App_Service_Field ADD CONSTRAINT FK_34E6C3183256915B FOREIGN KEY (relation_id) REFERENCES App_Field_Relation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE App_Service_Field DROP FOREIGN KEY FK_34E6C318ED5CA9E6');
        $this->addSql('ALTER TABLE App_Repository_Service DROP FOREIGN KEY FK_3A0A7CC450C9D4F7');
        $this->addSql('ALTER TABLE App_Project_Repository DROP FOREIGN KEY FK_BECDCEA4166D1F9C');
        $this->addSql('ALTER TABLE App_Relation_Cascade DROP FOREIGN KEY FK_491CEC52F7E1228C');
        $this->addSql('ALTER TABLE App_Service_Field DROP FOREIGN KEY FK_34E6C3183256915B');
        $this->addSql('ALTER TABLE App_Assert_Option DROP FOREIGN KEY FK_1751E07A113B5DA9');
        $this->addSql('ALTER TABLE App_Field_Option DROP FOREIGN KEY FK_BAEE3380BD415C8D');
        $this->addSql('ALTER TABLE App_Field_Assert DROP FOREIGN KEY FK_51877C9BBD415C8D');
        $this->addSql('DROP TABLE App_Repository_Service');
        $this->addSql('DROP TABLE App_Project_Repository');
        $this->addSql('DROP TABLE App_Project');
        $this->addSql('DROP TABLE App_Assert_Option');
        $this->addSql('DROP TABLE App_Field_Relation');
        $this->addSql('DROP TABLE App_Relation_Cascade');
        $this->addSql('DROP TABLE App_Field_Option');
        $this->addSql('DROP TABLE App_Field_Assert');
        $this->addSql('DROP TABLE App_Service_Field');
        $this->addSql('DROP TABLE Acl_Customer');
    }
}
