<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200805165047 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE App_Field_Constraint (id INT AUTO_INCREMENT NOT NULL, field_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E2622E4D443707B0 (field_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Constraint_Option (id INT AUTO_INCREMENT NOT NULL, constraint_id INT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_F40CF123E3087FFC (constraint_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Repository_Service (id INT AUTO_INCREMENT NOT NULL, repository_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(255) DEFAULT \'list\' NOT NULL, INDEX IDX_3A0A7CC450C9D4F7 (repository_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Service_Filter (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, type VARCHAR(20) NOT NULL, INDEX IDX_9770D0BED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Field_Option (id INT AUTO_INCREMENT NOT NULL, field_id INT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_BAEE3380443707B0 (field_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Project_Repository (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_BECDCEA4166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Acl_Customer (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_627894A6E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Filter_Property (id INT AUTO_INCREMENT NOT NULL, filter_id INT NOT NULL, field_id INT NOT NULL, value VARCHAR(255) DEFAULT NULL, INDEX IDX_BB70162BD395B25E (filter_id), UNIQUE INDEX UNIQ_BB70162B443707B0 (field_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Field_Relation (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, type VARCHAR(10) DEFAULT \'ManyToOne\' NOT NULL, mapped_by VARCHAR(255) DEFAULT NULL, inversed_by VARCHAR(255) DEFAULT NULL, orphan_removal TINYINT(1) DEFAULT \'0\' NOT NULL, join_column_name VARCHAR(255) DEFAULT NULL, join_column_referenced_column_name VARCHAR(255) DEFAULT \'id\' NOT NULL, join_column_is_unique TINYINT(1) DEFAULT \'0\' NOT NULL, join_column_is_nullable TINYINT(1) DEFAULT \'1\' NOT NULL, INDEX IDX_21FF0C4ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE App_Service_Field (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, relation_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, data_type VARCHAR(255) DEFAULT \'string\' NOT NULL, length INT UNSIGNED DEFAULT NULL, data_type_precision INT DEFAULT NULL, data_type_scale INT DEFAULT NULL, is_unique TINYINT(1) DEFAULT \'0\' NOT NULL, is_nullable TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_34E6C318ED5CA9E6 (service_id), UNIQUE INDEX UNIQ_34E6C3183256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE App_Field_Constraint ADD CONSTRAINT FK_E2622E4D443707B0 FOREIGN KEY (field_id) REFERENCES App_Service_Field (id)');
        $this->addSql('ALTER TABLE App_Constraint_Option ADD CONSTRAINT FK_F40CF123E3087FFC FOREIGN KEY (constraint_id) REFERENCES App_Field_Constraint (id)');
        $this->addSql('ALTER TABLE App_Repository_Service ADD CONSTRAINT FK_3A0A7CC450C9D4F7 FOREIGN KEY (repository_id) REFERENCES App_Project_Repository (id)');
        $this->addSql('ALTER TABLE App_Service_Filter ADD CONSTRAINT FK_9770D0BED5CA9E6 FOREIGN KEY (service_id) REFERENCES App_Repository_Service (id)');
        $this->addSql('ALTER TABLE App_Field_Option ADD CONSTRAINT FK_BAEE3380443707B0 FOREIGN KEY (field_id) REFERENCES App_Service_Field (id)');
        $this->addSql('ALTER TABLE App_Project_Repository ADD CONSTRAINT FK_BECDCEA4166D1F9C FOREIGN KEY (project_id) REFERENCES App_Project (id)');
        $this->addSql('ALTER TABLE App_Filter_Property ADD CONSTRAINT FK_BB70162BD395B25E FOREIGN KEY (filter_id) REFERENCES App_Service_Filter (id)');
        $this->addSql('ALTER TABLE App_Filter_Property ADD CONSTRAINT FK_BB70162B443707B0 FOREIGN KEY (field_id) REFERENCES App_Service_Field (id)');
        $this->addSql('ALTER TABLE App_Field_Relation ADD CONSTRAINT FK_21FF0C4ED5CA9E6 FOREIGN KEY (service_id) REFERENCES App_Repository_Service (id)');
        $this->addSql('ALTER TABLE App_Service_Field ADD CONSTRAINT FK_34E6C318ED5CA9E6 FOREIGN KEY (service_id) REFERENCES App_Repository_Service (id)');
        $this->addSql('ALTER TABLE App_Service_Field ADD CONSTRAINT FK_34E6C3183256915B FOREIGN KEY (relation_id) REFERENCES App_Field_Relation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE App_Constraint_Option DROP FOREIGN KEY FK_F40CF123E3087FFC');
        $this->addSql('ALTER TABLE App_Service_Filter DROP FOREIGN KEY FK_9770D0BED5CA9E6');
        $this->addSql('ALTER TABLE App_Field_Relation DROP FOREIGN KEY FK_21FF0C4ED5CA9E6');
        $this->addSql('ALTER TABLE App_Service_Field DROP FOREIGN KEY FK_34E6C318ED5CA9E6');
        $this->addSql('ALTER TABLE App_Filter_Property DROP FOREIGN KEY FK_BB70162BD395B25E');
        $this->addSql('ALTER TABLE App_Repository_Service DROP FOREIGN KEY FK_3A0A7CC450C9D4F7');
        $this->addSql('ALTER TABLE App_Service_Field DROP FOREIGN KEY FK_34E6C3183256915B');
        $this->addSql('ALTER TABLE App_Project_Repository DROP FOREIGN KEY FK_BECDCEA4166D1F9C');
        $this->addSql('ALTER TABLE App_Field_Constraint DROP FOREIGN KEY FK_E2622E4D443707B0');
        $this->addSql('ALTER TABLE App_Field_Option DROP FOREIGN KEY FK_BAEE3380443707B0');
        $this->addSql('ALTER TABLE App_Filter_Property DROP FOREIGN KEY FK_BB70162B443707B0');
        $this->addSql('DROP TABLE App_Field_Constraint');
        $this->addSql('DROP TABLE App_Constraint_Option');
        $this->addSql('DROP TABLE App_Repository_Service');
        $this->addSql('DROP TABLE App_Service_Filter');
        $this->addSql('DROP TABLE App_Field_Option');
        $this->addSql('DROP TABLE App_Project_Repository');
        $this->addSql('DROP TABLE Acl_Customer');
        $this->addSql('DROP TABLE App_Filter_Property');
        $this->addSql('DROP TABLE App_Field_Relation');
        $this->addSql('DROP TABLE App_Project');
        $this->addSql('DROP TABLE App_Service_Field');
    }
}
